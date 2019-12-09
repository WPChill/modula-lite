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
        add_action('wp_enqueue_scripts', array($this, 'enqueue_page_builder_scripts'));

    }

    /**
     * Include Modula Beaver Block
     */
    public function include_beaver_block() {
        if (class_exists('FLBuilder')) {
            require_once MODULA_PATH . 'includes/modula-beaver-block/class-modula-beaver-block.php';
        }
    }

    /**
     * Enqueue needed scripts in the admin required for pagebuilder preview
     */
    public function enqueue_page_builder_scripts() {

        // only enqueue for Beaver page builder live editing
        if (class_exists('FLBuilderModel') && FLBuilderModel::is_builder_active()) {

            wp_register_script('modula-beaver-preview', MODULA_URL . 'assets/js/modula-beaver-preview.js', array('jquery'), MODULA_LITE_VERSION, true);
            wp_enqueue_script('modula-beaver-preview');
            
        }
    }
}

$modula_beaver = new Modula_Beaver();