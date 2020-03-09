<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Modula_Nextgen_Importer {

    /**
     * Holds the class object.
     *
     * @var object
     *
     * @since 2.2.7
     */
    public static $instance;

    /**
     * Primary class constructor.
     *
     * @since 2.2.7
     */
    public function __construct() {

        // Add AJAX
        add_action('wp_ajax_modula_importer_nextgen_gallery_import', array($this, 'nextgen_gallery_import'));
        add_action('wp_ajax_modula_importer_nextgen_gallery_imported_update', array($this, 'update_imported'));

    }

    /**
     * Get all NextGEN Galleries
     *
     * @return mixed
     *
     * @since 2.2.7
     */
    public function get_galleries() {

        global $wpdb;
        $empty_galleries = array();

        if(!$wpdb->get_var("SHOW TABLES LIKE '".$wpdb->prefix . "ngg_gallery'")){
            return false;
        }

        $galleries = $wpdb->get_results(" SELECT * FROM " . $wpdb->prefix . "ngg_gallery");
        if (count($galleries) != 0) {
            foreach ($galleries as $key => $gallery) {
                $count = $this->images_count($gallery->gid);

                if ($count == 0) {
                    unset($galleries[$key]);
                    $empty_galleries[$key] = $gallery;
                }
            }

            if (count($galleries) != 0) {
                $return_galleries['valid_galleries'] = $galleries;
            }
            if (count($empty_galleries) != 0) {
                $return_galleries['empty_galleries'] = $empty_galleries;
            }

            if (count($return_galleries) != 0) {
                return $return_galleries;
            }
        }

        return false;
    }


    /**
     * Get gallery image count
     *
     * @param $id
     * @return int
     *
     * @since 2.2.7
     */
    public function images_count($id){
        global $wpdb;

        $sql = $wpdb->prepare("SELECT COUNT(pid) FROM " . $wpdb->prefix . "ngg_pictures
    						WHERE galleryid = %d ",
            $id);

        $images = $wpdb->get_results($sql);
        $count = get_object_vars($images[0]);
        $count = $count['COUNT(pid)'];

        return $count;
    }


    /**
     * Imports a gallery from NextGEN into Modula
     *
     * @param string $gallery_id
     *
     * @since 2.2.7
     */
    public function nextgen_gallery_import($gallery_id = '') {

        global $wpdb;
        $modula_importer = Modula_Importer::get_instance();

        // Set max execution time so we don't timeout
        ini_set( 'max_execution_time', 0 );
        set_time_limit( 0 );

        // If no gallery ID, get from AJAX request
        if ( empty( $gallery_id ) ) {

            // Run a security check first.
            check_ajax_referer( 'modula-importer', 'nonce' );

            if ( !isset( $_POST['id'] ) ) {
                $this->modula_import_result( false, esc_html__( 'No gallery was selected', 'modula-best-grid-gallery' ), false );
            }

            $gallery_id = absint( $_POST['id'] );

        }

        $imported_galleries = get_option( 'modula_importer' );

        if ( isset( $imported_galleries['galleries']['nextgen'][ $gallery_id ] ) ) {

            $modula_gallery = get_post_type( $imported_galleries['galleries']['nextgen'][ $gallery_id ] );
            // If already migrated don't migrate
            if ( 'modula-gallery' == $modula_gallery ) {

                // Trigger delete function if option is set to delete
                if ( isset($_POST['clean']) && 'delete' == $_POST['clean'] ) {
                    $this->clean_entries( $gallery_id );
                }
                $this->modula_import_result( false, esc_html__( 'Gallery already migrated!', 'modula-best-grid-gallery' ), false );
            }
        }

        // Get image path
        $sql     = $wpdb->prepare("SELECT path, title, galdesc, pageid 
    						FROM " . $wpdb->prefix . "ngg_gallery
    						WHERE gid = %d
    						LIMIT 1",
            $gallery_id);
        $gallery = $wpdb->get_row($sql);

        $images = $modula_importer->prepare_images('nextgen',$gallery_id);
        $attachments = array();

        if (is_array($images) && count($images) > 0) {
            // Add each image to Media Library
            foreach ($images as $image) {

                // Store image in WordPress Media Library
                $attachment = $this->add_image_to_library($gallery->path, $image->filename, $image->description, $image->alttext);

                if ($attachment !== false ) {

                    // Add to array of attachments
                    $attachments[] = $attachment;
                }
            }
        }

        if (count($attachments) == 0) {
            // Trigger delete function if option is set to delete
            if(isset($_POST['clean']) && 'delete' == $_POST['clean']){
                $this->clean_entries($gallery_id);
            }
            $this->modula_import_result(false, esc_html__('No images found in gallery. Skipping gallery...', 'modula-best-grid-gallery'),false);
        }

        // Get Modula Gallery defaults, used to set modula-settings metadata
        $modula_settings = Modula_CPT_Fields_Helper::get_defaults();

        // Build Modula Gallery modula-images metadata
        $modula_images = array();
        foreach ($attachments as $attachment) {
            $modula_images[] = array(
                'id'          => absint($attachment['ID']),
                'alt'         => sanitize_text_field($attachment['alt']),
                'title'       => sanitize_text_field($attachment['title']),
                'description' => wp_filter_post_kses($attachment['caption']),
                'halign'      => 'center',
                'valign'      => 'middle',
                'link'        => esc_url_raw($attachment['src']),
                'target'      => '',
                'width'       => 2,
                'height'      => 2,
                'filters'     => ''
            );
        }

        // Create Modula CPT
        $modula_gallery_id = wp_insert_post(array(
            'post_type'   => 'modula-gallery',
            'post_status' => 'publish',
            'post_title'  => sanitize_text_field($gallery->title),
        ));

        // Attach meta modula-settings to Modula CPT
        update_post_meta($modula_gallery_id, 'modula-settings', $modula_settings);

        // Attach meta modula-images to Modula CPT
        update_post_meta($modula_gallery_id, 'modula-images', $modula_images);

        $nextgen_shortcode = '[ngg_images gallery_ids="' . $gallery_id . '"]';
        $nextgen_shortcode_2 = '[ngg src="galleries" ids="' . $gallery_id . '" display="basic_thumbnail" thumbnail_crop="0"]';
        $modula_shortcode  = '[modula id="' . $modula_gallery_id . '"]';

        // Replace NextGEN shortcode with Modula Shortcode in Posts, Pages and CPTs
        $sql = $wpdb->prepare("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content, '%s', '%s')",
            $nextgen_shortcode, $modula_shortcode);
        $sql_2 = $wpdb->prepare("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content, '%s', '%s')",
            $nextgen_shortcode_2, $modula_shortcode);
        $wpdb->query($sql);
        $wpdb->query($sql_2);

        //@todo : gutenberg block replacement functionality
        /*$sql_gutenberg       = "SELECT * FROM " . $wpdb->prefix . "posts WHERE `post_content` LIKE '%wp:imagely/nextgen-gallery%'";
        $galleries_gutenberg = $wpdb->get_results($sql_gutenberg);

        if(count($galleries_gutenberg) > 0){
            foreach($galleries_gutenberg as $gutenberg){
                $content       = $gutenberg->post_content;
                $search_string = '/ids\s*=\s*\"([\s\S]*?)\"/';
                $pattern       = '/<!-- wp:imagely/nextgen-gallery -->\s*\[\s*ngg\s*ids\s*=\s*\"([\s\S]*?)\"/';
                $result        = preg_match_all($pattern, $content, $matches);
                var_dump($content,$result);die();
                if ( $result && $result > 0 ) {
                    var_dump($matches[0]);die();
                    foreach ( $matches[0] as $sc ) {
                    }
                }
            }

        }*/

        if(isset($_POST['clean']) && 'delete' == $_POST['clean']){
            $this->clean_entries($gallery_id);
        }
        $this->modula_import_result(true, wp_kses_post('<i class="imported-check dashicons dashicons-yes"></i>'),$modula_gallery_id);
    }

    /**
     * Update imported galleries
     *
     *
     * @since 2.2.7
     */
    public function update_imported() {

        check_ajax_referer('modula-importer', 'nonce');
        $galleries         = $_POST['galleries'];
        $importer_settings = get_option('modula_importer');

        if(!is_array($importer_settings)){
            $importer_settings = array();
        }

        if (!isset($importer_settings['galleries']['nextgen'])) {
            $importer_settings['galleries']['nextgen'] = array();
        }

        if ( is_array( $galleries ) && count( $galleries ) > 0 ) {
            foreach ( $galleries as $key => $value ) {
                $importer_settings['galleries']['nextgen'][ absint($key) ] = absint($value);
            }
        }

        update_option('modula_importer', $importer_settings);

        // Set url if migration complete
        $url = admin_url('edit.php?post_type=modula-gallery&page=modula&modula-tab=importer&migration=complete');

        if(isset($_POST['clean']) && 'delete' == $_POST['clean']){
            // Set url if migration and cleaning complete
            $url = admin_url('edit.php?post_type=modula-gallery&page=modula&modula-tab=importer&migration=complete&delete=complete');
        }

        echo $url;
        wp_die();
    }


    /**
     * Add image to library
     *
     * @param $source_path
     * @param $source_file
     * @param $description
     * @param $alt
     * @return mixed
     *
     * @since 2.2.7
     */
    public function add_image_to_library($source_path, $source_file, $description, $alt) {

        global $wpdb;
        $sql = $wpdb->prepare(
            "SELECT * FROM $wpdb->posts WHERE guid LIKE %s",
            '%/'.$source_file
        );

        $queried = $wpdb->get_results( $sql );

        if (count($queried) > 0) {
            return array(
                'ID'    => $queried[0]->ID,
                'title' => $queried[0]->post_title,
                'alt'   => get_post_meta($queried[0]->ID, '_wp_attachment_image_alt', true),
                'caption' =>  $queried[0]->post_content
            );
        }

        // Get full path and filename
        $source_file_path = ABSPATH . $source_path . '/' . $source_file;

        // Get WP upload dir
        $uploadDir = wp_upload_dir();

        // Create destination file paths and URLs
        $destination_file      = wp_unique_filename($uploadDir['path'], $source_file);
        $destination_file_path = $uploadDir['path'] . '/' . $destination_file;
        $destination_url       = $uploadDir['url'] . '/' . $destination_file;

        // Check file is valid
        $wp_filetype = wp_check_filetype($source_file, null);
        extract($wp_filetype);

        if ((!$type || !$ext) && !current_user_can('unfiltered_upload')) {
            return false;
        }

        $result = copy($source_file_path, $destination_file_path);

        if (!$result) {

            return false;
        }

        // Set file permissions
        $stat  = stat($destination_file_path);
        $perms = $stat['mode'] & 0000666;
        chmod($destination_file_path, $perms);

        // Apply upload filters
        $return = apply_filters('wp_handle_upload', array(
            'file' => $destination_file_path,
            'url'  => $destination_url,
            'type' => $type,
        ));

        // Construct the attachment array
        $attachment = array(
            'post_mime_type' => sanitize_text_field($type),
            'guid'           => esc_url_raw($destination_url),
            'post_title'     => sanitize_text_field($alt),
            'post_name'      => sanitize_text_field($alt),
            'post_content'   => wp_filter_post_kses($description),
        );

        // Save as attachment
        $attachmentID = wp_insert_attachment($attachment, $destination_file_path);

        // Update attachment metadata
        if (!is_wp_error($attachmentID)) {
            $metadata = wp_generate_attachment_metadata($attachmentID, $destination_file_path);
            wp_update_attachment_metadata($attachmentID, wp_generate_attachment_metadata($attachmentID, $destination_file_path));
        }

        update_post_meta($attachmentID, '_wp_attachment_image_alt', $alt);
        $attachment               = get_post($attachmentID);
        $attachment->post_excerpt = $description;
        wp_update_post($attachment);

        // Return attachment data
        return array(
            'ID'      => $attachmentID,
            'src'     => $destination_url,
            'title'   => $alt,
            'alt'     => $alt,
            'caption' => $description,
        );

    }


    /**
     * Returns result
     *
     * @param $success
     * @param $message
     * @param $modula_gallery_id
     *
     * @since 2.2.7
     */
    public function modula_import_result( $success, $message, $modula_gallery_id = false ) {
        echo json_encode( array(
            'success'           => (bool)$success,
            'message'           => (string)$message,
            'modula_gallery_id' => $modula_gallery_id
        ) );
        die;
    }


    /**
     * Returns the singleton instance of the class.
     *
     * @since 2.2.7
     */
    public static function get_instance() {

        if (!isset(self::$instance) && !(self::$instance instanceof Modula_Nextgen_Importer)) {
            self::$instance = new Modula_Nextgen_Importer();
        }

        return self::$instance;

    }

    /**
     * Delete old entries from database
     *
     * @param $gallery_id
     *
     * @since 2.2.7
     */
    public function clean_entries($gallery_id){
        global $wpdb;
        $sql      = $wpdb->prepare( "DELETE FROM  ".$wpdb->prefix ."ngg_gallery WHERE gid = $gallery_id" );
        $sql_meta = $wpdb->prepare( "DELETE FROM  ".$wpdb->prefix ."ngg_pictures WHERE galleryid = $gallery_id" );
        $wpdb->query( $sql );
        $wpdb->query( $sql_meta );
    }

}

// Load the class.
$modula_nextgen_importer = Modula_Nextgen_Importer::get_instance();