<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Modula_Final_Tiles_Importer {

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
        add_action('wp_ajax_modula_importer_final_tiles_gallery_import', array($this, 'final_tiles_gallery_import'));
        add_action('wp_ajax_modula_importer_final_tiles_gallery_imported_update', array($this, 'update_imported'));

    }

    /**
     * Get all Final Tiles Galleries
     *
     * @return mixed
     *
     * @since 2.2.7
     */
    public function get_galleries() {

        global $wpdb;
        $empty_galleries = array();

        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "finaltiles_gallery'")) {
            $galleries = $wpdb->get_results(" SELECT * FROM " . $wpdb->prefix . "finaltiles_gallery");
            if (count($galleries) != 0) {
                foreach ($galleries as $key => $gallery) {
                    $count = $this->images_count($gallery->Id);

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
        }

        if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "FinalTiles_gallery'" ) ) {
            $galleries = $wpdb->get_results( " SELECT * FROM " . $wpdb->prefix . "FinalTiles_gallery" );
            if ( count( $galleries ) != 0 ) {
                foreach ( $galleries as $key => $gallery ) {
                    $count = $this->images_count( $gallery->Id );

                    if ( $count == 0 ) {
                        unset( $galleries[ $key ] );
                        $empty_galleries[ $key ] = $gallery;
                    }
                }

                if ( count( $galleries ) != 0 ) {
                    $return_galleries['valid_galleries'] = $galleries;
                }
                if ( count( $empty_galleries ) != 0 ) {
                    $return_galleries['empty_galleries'] = $empty_galleries;
                }

                if ( count( $return_galleries ) != 0 ) {
                    return $return_galleries;
                }
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
        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "finaltiles_gallery'")) {
            // Get images from Final Tiles
            $sql    = $wpdb->prepare("SELECT COUNT(Id) FROM " . $wpdb->prefix . "finaltiles_gallery_images
    						WHERE gid = %d ",
                $id);
            $images = $wpdb->get_results($sql);
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "FinalTiles_gallery'")) {
            // Get images from Final Tiles
            $sql    = $wpdb->prepare("SELECT COUNT(Id) FROM " . $wpdb->prefix . "FinalTiles_gallery_images
    						WHERE gid = %d",
                $id);
            $images = $wpdb->get_results($sql);
        }

        $count = get_object_vars($images[0]);
        $count = $count['COUNT(Id)'];

        return $count;
    }


    /**
     * Imports a gallery from Final Tiles to Modula
     *
     * @param string $gallery_id
     *
     * @since 2.2.7
     */
    public function final_tiles_gallery_import($gallery_id = '') {

        global $wpdb;
        $modula_importer = Modula_Importer::get_instance();

        // Set max execution time so we don't timeout
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        // If no gallery ID, get from AJAX request
        if (empty($gallery_id)) {

            // Run a security check first.
            check_ajax_referer('modula-importer', 'nonce');

            if (!isset($_POST['id'])) {
                $this->modula_import_result(false, esc_html__('No gallery was selected', 'modula-best-grid-gallery'),false);
            }

            $gallery_id = absint($_POST['id']);

        }

        $imported_galleries = get_option('modula_importer');

        // If already migrated don't migrate
        if ( isset( $imported_galleries['galleries']['final_tiles'][ $gallery_id ] ) ) {

            $modula_gallery = get_post_type( $imported_galleries['galleries']['final_tiles'][ $gallery_id ] );

            if ( 'modula-gallery' == $modula_gallery ) {
                // Trigger delete function if option is set to delete
                if ( isset($_POST['clean']) && 'delete' == $_POST['clean'] ) {
                    $this->clean_entries( $gallery_id );
                }
                $this->modula_import_result( false, esc_html__( 'Gallery already migrated!', 'modula-best-grid-gallery' ), false );
            }
        }

        // Seems like on some servers tables are saved lowercase
        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "finaltiles_gallery'")) {

            // Get gallery configuration
            $sql     = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "finaltiles_gallery
    						WHERE id = %d",
                $gallery_id);
            $gallery = $wpdb->get_row($sql);
        }

        if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->prefix . "FinalTiles_gallery'")) {

            // Get gallery configuration
            $sql     = $wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "FinalTiles_gallery
    						WHERE id = %d",
                $gallery_id);
            $gallery = $wpdb->get_row($sql);
        }

        $images = $modula_importer->prepare_images('final_tiles',$gallery_id);

        $gallery_config = json_decode($gallery->configuration);

        // Build Modula Gallery modula-images metadata
        $modula_images = array();
        if (is_array($images) && count($images) > 0) {
            // Add each image to Media Library
            foreach ($images as $image) {

                $modula_images[] = array(
                    'id'          => absint($image->imageId),
                    'alt'         => sanitize_text_field($image->alt),
                    'title'       => sanitize_text_field($image->title),
                    'description' => wp_filter_post_kses($image->description),
                    'halign'      => 'center',
                    'valign'      => 'middle',
                    'link'        => esc_url_raw($image->link),
                    'target'      => (isset($image->target) && '_blank' == $image->target ) ? 1 : 0,
                    'width'       => 2,
                    'height'      => 2,
                    'filters'     => ''
                );
            }
        }

        if (count($modula_images) == 0) {
            // Trigger delete function if option is set to delete
            if(isset($_POST['clean']) && 'delete' == $_POST['clean']){
                $this->clean_entries($gallery_id);
            }
            $this->modula_import_result(false, esc_html__('No images found in gallery. Skipping gallery...', 'modula-best-grid-gallery'),false);
        }

        // Get Modula Gallery defaults, used to set modula-settings metadata
        $modula_settings = Modula_CPT_Fields_Helper::get_defaults();


        // Create Modula CPT
        $modula_gallery_id = wp_insert_post(array(
            'post_type'   => 'modula-gallery',
            'post_status' => 'publish',
            'post_title'  => sanitize_text_field($gallery_config->name),
        ));

        // Attach meta modula-settings to Modula CPT
        update_post_meta($modula_gallery_id, 'modula-settings', $modula_settings);

        // Attach meta modula-images to Modula CPT
        update_post_meta($modula_gallery_id, 'modula-images', $modula_images);

        $ftg_shortcode    = '[FinalTilesGallery id="' . $gallery_id . '"]';
        $modula_shortcode = '[modula id="' . $modula_gallery_id . '"]';

        // Replace Final Tiles Grid Gallery shortcode with Modula Shortcode in Posts, Pages and CPTs
        $sql = $wpdb->prepare("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content, '%s', '%s')",
            $ftg_shortcode, $modula_shortcode);
        $wpdb->query($sql);

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
        $importer_settings = get_option('modula_importer');
        $galleries  = $_POST['galleries'];

        if(!is_array($importer_settings)){
            $importer_settings = array();
        }

        if (!isset($importer_settings['galleries']['final_tiles'])) {
            $importer_settings['galleries']['final_tiles'] = array();
        }

        if ( is_array( $galleries ) && count( $galleries ) > 0 ) {
            foreach ( $galleries as $key => $value ) {
                $importer_settings['galleries']['final_tiles'][ absint($key) ] = absint($value);
            }
        }

        update_option('modula_importer', $importer_settings);

        // Set url for migration complete
        $url = admin_url('edit.php?post_type=modula-gallery&page=modula&modula-tab=importer&migration=complete');

        if(isset($_POST['clean']) && 'delete' == $_POST['clean']){
            // Set url for migration and cleaning complete
            $url = admin_url('edit.php?post_type=modula-gallery&page=modula&modula-tab=importer&migration=complete&delete=complete');
        }

        echo $url;
        wp_die();


    }


    /**
     * Returns result
     *
     * @param $success
     * @param $message
     *
     * @since 2.2.7
     */
    public function modula_import_result($success, $message,$modula_gallery_id = false) {
        echo json_encode(array(
            'success' => (bool)$success,
            'message' => (string)$message,
            'modula_gallery_id' => $modula_gallery_id
        ));
        die;
    }


    /**
     * Returns the singleton instance of the class.
     *
     * @since 2.2.7
     */
    public static function get_instance() {

        if (!isset(self::$instance) && !(self::$instance instanceof Modula_Final_Tiles_Importer)) {
            self::$instance = new Modula_Final_Tiles_Importer();
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

        if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "finaltiles_gallery'" ) ) {
            $sql      = $wpdb->prepare( "DELETE FROM  " . $wpdb->prefix . "finaltiles_gallery WHERE Id = $gallery_id" );
            $sql_meta = $wpdb->prepare( "DELETE FROM  " . $wpdb->prefix . "finaltiles_gallery_images WHERE gid = $gallery_id" );


            $wpdb->query( $sql );
            $wpdb->query( $sql_meta );
        }

        if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "FinalTiles_gallery'" ) ) {
            $sql_2      = $wpdb->prepare( "DELETE FROM  " . $wpdb->prefix . "FinalTiles_gallery WHERE Id = $gallery_id" );
            $sql_meta_2 = $wpdb->prepare( "DELETE FROM  " . $wpdb->prefix . "FinalTiles_gallery_images WHERE gid = $gallery_id" );

            $wpdb->query( $sql_2 );
            $wpdb->query( $sql_meta_2 );
        }
    }
}

// Load the class.
$modula_final_tiles_importer = Modula_Final_Tiles_Importer::get_instance();