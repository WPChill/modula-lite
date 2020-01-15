<?php

class Modula_Update {

    /**
     * Holds the class object.
     *
     * @since 2.2.4
     *
     * @var object
     */
    public static $instance;


    /**
     * Primary class constructor.
     *
     * @since 2.2.4
     */
    public function __construct() {

        add_action('upgrader_process_complete', array($this, 'update_modula'), 10, 2);
        add_action('admin_menu', array($this, 'modula_about_menu'));
        add_filter('submenu_file', array($this, 'remove_about_submenu_item'));
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
    }


    /**
     * @since 2.2.4
     * Add the About submenu
     */
    function modula_about_menu() {

        // Register the hidden submenu.
        add_submenu_page('edit.php?post_type=modula-gallery', esc_html__('About', 'modula-best-grid-gallery'), esc_html__('About', 'modula-best-grid-gallery'), 'manage_options', 'modula-about-page', array($this, 'about_page'));
    }

    /**
     * @param $submenu_file
     * @return mixed
     *
     * Remove the About submenu
     */
    function remove_about_submenu_item($submenu_file) {

        remove_submenu_page('edit.php?post_type=modula-gallery', 'modula-about-page');

        return $submenu_file;
    }


    /**
     * Returns the singleton instance of the class.
     *
     * @return object The Modula_Update object.
     * @since 2.2.4
     *
     */
    public static function get_instance() {
        if (!isset(self::$instance) && !(self::$instance instanceof Modula_Update)) {
            self::$instance = new Modula_Update();
        }
        return self::$instance;
    }


    /**
     * @param $upgrader_object
     * @param $options
     *
     * @since 2.2.4
     * Upgrade Modula Best Grid Gallery redirection
     */
    public function update_modula($upgrader_object, $options) {

        // check if update and if update type plugin
        if ($options['action'] == 'update' && $options['type'] == 'plugin') {
            foreach ($options['plugins'] as $each_plugin) {
                // check if is Modula Best Grid Gallery plugin
                if ($each_plugin == MODULA_FILE) {
                    wp_redirect(admin_url('edit.php?post_type=modula-gallery&page=modula-about-page'));
                }
            }
        }
    }

    /**
     * @since 2.2.4
     * Enqueue admin About style
     */
    public function admin_scripts() {

        $screen = get_current_screen();
        if ('modula-gallery_page_modula-about-page' == $screen->base) {
            wp_enqueue_style('modula-about-style', MODULA_URL . 'assets/css/about.css', null, MODULA_LITE_VERSION);
        }
    }


    /**
     * @since 2.2.4
     * Display About page
     */
    public function about_page() {

        include MODULA_PATH . 'includes/admin/tabs/about.php';
    }

}

$modula_update = Modula_Update::get_instance();