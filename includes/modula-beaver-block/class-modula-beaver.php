<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Modula_Beaver {

    /**
     * Modula_Beaver constructor.
     */
    public function __construct() {
        add_action('init', array($this, 'include_beaver_block'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_page_builder_scripts'));

    }

    /**
     * Include Modula Beaver Block
     */
    public function include_beaver_block() {
        if (class_exists('FLBuilder')) {
            require_once 'class-modula-beaver-block.php';
        }
    }

    /**
     * Enqueue needed scripts in the admin required for pagebuilder preview
     */
    public function enqueue_page_builder_scripts() {

        // only enqueue for SiteOrigin page builder
        if (class_exists('FLBuilder')) {

            // get Beaver Builder post types
            $beaver_post_types = FLBuilderModel::get_post_types();
            $current_screen    = get_current_screen();

            if (in_array($current_screen->post_type, $beaver_post_types)) {
                wp_register_style('modula', MODULA_URL . 'assets/css/modula.min.css', null, MODULA_LITE_VERSION);
                wp_register_script('modula-preview', MODULA_URL . 'assets/js/jquery-modula.min.js', array('jquery'), MODULA_LITE_VERSION, true);
                wp_register_script('modula-beaver-preview', MODULA_URL . 'assets/js/modula-beaver-preview.js', array('jquery'), MODULA_LITE_VERSION, true);

                wp_enqueue_style('modula');
                wp_enqueue_script('modula-preview');
                wp_enqueue_script('modula-beaver-preview');
            }
        }
    }
}

$modula_beaver = new Modula_Beaver();