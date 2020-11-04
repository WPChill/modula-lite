<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Modula_WP_Core_Gallery_Importer {

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
        add_action('wp_ajax_modula_importer_wp_core_gallery_import', array($this, 'wp_core_gallery_import'));

    }

    /**
     * Get all posts/pages that have wp core galleries
     *
     * @return mixed
     *
     * @since 2.2.7
     */
    public function get_galleries() {

        global $wpdb;
        $empty_galleries = array();

        $post_in   = "'post','page'";
        $post_types = get_post_types(array('show_in_menu' => true,'public'=>true));

        foreach($post_types as $post_type){
            // exclude previous set and attachment from sql query
            if($post_type != 'post' && $post_type != 'page' && $post_type != 'attachment'){
                $post_in .= ",'".$post_type."'";
            }
        }

        $sql       = "SELECT * FROM " . $wpdb->prefix . "posts WHERE `post_content` LIKE '%[galler%' AND `post_type` IN ($post_in)";
        $galleries = $wpdb->get_results($sql);

        if (count($galleries) != 0) {
            $i = 1;
            foreach($galleries as $gallery){
                $content       = $gallery->post_content;
                $search_string = '[gallery';
                $pattern       = '/\\' . $search_string . '[\s\S]*?\]/';
                $result        = preg_match_all($pattern, $content, $matches);

                if ( $result && $result > 0 ) {
                    foreach ( $matches[0] as $sc ) {

                        $pattern       = '/ids\s*=\s*\"([\s\S]*?)\"/';
                        $result        = preg_match( $pattern, $sc, $gallery_ids );
                        $images        = ( $gallery_ids[1] && NULL != $gallery_ids[1] ) ? explode( ',', $gallery_ids[1] ) : false;

                        // if there are images we should build our array
                        if ( $images && count( $images ) != 0 ) {
                            // need all of these because multiple galleries can be found on 1 post type
                            $core_gal[ $i ]['title']     = '#' . $i . ' from ' . $gallery->post_title;
                            // need shortcode so that we can search only for that string when we replace/migrate
                            $core_gal[ $i ]['shortcode'] = $sc;
                            $core_gal[ $i ]['images']    = count( $images );
                            $core_gal[ $i ]['page_id']   = $gallery->ID;
                            // need gallery number to prevent double id and double selecting
                            $core_gal[ $i ]['gal_nr']   = $i;
                        }
                        $i++;
                    }
                }
            }

            if (count($core_gal) != 0) {
                $return_galleries['valid_galleries'] = $core_gal;
            }

            if (count($return_galleries) != 0) {
                return $return_galleries;
            }
        }


        return false;
    }


    /**
     * Replace WP Core gallery and create Modula gallery
     *
     * @param array $galery_atts
     *
     * @since 2.2.7
     */
    public function wp_core_gallery_import($galery_atts = array()) {

        global $wpdb;
        $modula_importer = Modula_Importer::get_instance();

        // Set max execution time so we don't timeout
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        // If no gallery ID, get from AJAX request
        if (empty($galery_atts)) {

            // Run a security check first.
            check_ajax_referer('modula-importer', 'nonce');

            if (!isset($_POST['id'])) {
                $this->modula_import_result(false, esc_html__('No gallery was selected', 'modula-best-grid-gallery'));
            }

            // Need to make replace so we can search our shortcode in content
            $galery_atts = str_replace('\"','"',$_POST['id']);
        }


        // Get page with gallery
        $post          = get_post($galery_atts['id']);
        $content       = $post->post_content;
        $search_string = $galery_atts['shortcode'];
        $result        = preg_match_all($search_string, $content, $matches);

        if ($result && $result > 0) {

            foreach ($matches[0] as $sc) {
                $modula_images = array();
                $pattern           = '/\s\ids\s*=\s*\"([\s\S]*?)\"/';
                $result            = preg_match($pattern, $sc, $gallery_ids);
                $image_ids = $modula_importer->prepare_images('wp_core',$gallery_ids[1]);
                $gallery_image_ids = $gallery_ids[0];

                foreach ($image_ids as $image) {

                    $img = get_post($image);
                    if ($img) {
                        // Build Modula Gallery modula-images metadata
                        $modula_images[] = array(
                            'id'          => absint($image),
                            'alt'         => sanitize_text_field(get_post_meta( $image, '_wp_attachment_image_alt', true )),
                            'title'       => sanitize_text_field($img->post_title),
                            'description' => wp_filter_post_kses($img->post_content),
                            'halign'      => 'center',
                            'valign'      => 'middle',
                            'link'        => '',
                            'target'      => '',
                            'width'       => 2,
                            'height'      => 2,
                            'filters'     => ''
                        );
                    }
                }

                if (count($modula_images) == 0) {
                    $this->modula_import_result(false, esc_html__('No images found in gallery. Skipping gallery...', 'modula-best-grid-gallery'));
                }

                // Get Modula Gallery defaults, used to set modula-settings metadata
                $modula_settings = Modula_CPT_Fields_Helper::get_defaults();

                // Create Modula CPT
                $modula_gallery_id = wp_insert_post(array(
                    'post_type'   => 'modula-gallery',
                    'post_status' => 'publish',
                    'post_title'  => sanitize_text_field($_POST['gallery_title']),
                ));


                // Attach meta modula-settings to Modula CPT
                update_post_meta($modula_gallery_id, 'modula-settings', $modula_settings);

                // Attach meta modula-images to Modula CPT
                update_post_meta($modula_gallery_id, 'modula-images', $modula_images);

                $wp_core_shortcode    = $galery_atts['shortcode'];
                $modula_shortcode = '[modula id="' . $modula_gallery_id . '"]';

                // Replace Gallery PhotoBlocks shortcode with Modula Shortcode in Posts, Pages and CPTs
                $sql = $wpdb->prepare("UPDATE " . $wpdb->prefix . "posts SET post_content = REPLACE(post_content, '%s', '%s')",
                    $wp_core_shortcode, $modula_shortcode);
                $wpdb->query($sql);
            }
        }

        $this->modula_import_result(true, wp_kses_post('<i class="imported-check dashicons dashicons-yes"></i>'));
    }


    /**
     * Returns result
     *
     * @param $success
     * @param $message
     *
     * @since 2.2.7
     */
    public function modula_import_result($success, $message) {
        echo json_encode(array(
            'success' => (bool)$success,
            'message' => (string)$message,
        ));
        die;
    }


    /**
     * Returns the singleton instance of the class.
     *
     * @since 2.2.7
     */
    public static function get_instance() {

        if (!isset(self::$instance) && !(self::$instance instanceof Modula_WP_Core_Gallery_Importer)) {
            self::$instance = new Modula_WP_Core_Gallery_Importer();
        }

        return self::$instance;

    }

}

// Load the class.
$wp_core_importer = Modula_WP_Core_Gallery_Importer::get_instance();