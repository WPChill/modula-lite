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
     * Add activation hook. Need to be this way so that the About page can be created and accessed
     * @param $check
     * @since 2.2.4
     *
     */
    public function modula_on_activation($check) {

        if ($check) {
            add_action('activated_plugin', array($this, 'redirect_on_activation'));
        }
    }

    /**
     * Redirect to About page when activated
     *
     * @param $plugin
     * @since 2.2.4
     */
    public function redirect_on_activation($plugin) {

        if (MODULA_FILE == $plugin) {
            exit(wp_redirect(admin_url('edit.php?post_type=modula-gallery&page=modula-about-page')));
        }
    }

    /**
     * @since 2.2.4
     * Enqueue admin About style
     */
    public function admin_scripts() {

        $screen = get_current_screen();
        if ('modula-gallery_page_modula-about-page' == $screen->base) {
            wp_enqueue_style('modula-about-style', MODULA_URL . 'assets/css/about.min.css', null, MODULA_LITE_VERSION);
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