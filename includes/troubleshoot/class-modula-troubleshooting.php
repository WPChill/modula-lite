<?php

class Modula_Troubleshooting {

    private static $instance;

    /**
     * Modula_Troubleshooting constructor.
     */
    public function __construct() {
        $this->define_troubleshooting_admin_hooks();
        $this->define_troubleshooting_hooks();
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    }

    /**
     * @return Modula_Troubleshooting
     */
    public static function get_instance() {

        if (!isset(self::$instance) && !(self::$instance instanceof Modula_Troubleshooting)) {
            self::$instance = new Modula_Troubleshooting();
        }

        return self::$instance;

    }

    public function admin_enqueue_scripts() {
        $current_screen = get_current_screen();
        if ('modula-gallery_page_modula-troubleshooting' == $current_screen->base) {
            wp_enqueue_script('modula-troubleshoot-conditions', MODULA_URL . 'assets/js/modula-troubleshoot-conditions.js', array(), MODULA_LITE_VERSION, true);
        }

    }

    /**
     * Define public troubleshooting hooks
     */
    public function define_troubleshooting_hooks() {

    }

    /**
     * Define admin troubleshooting hooks
     */
    public function define_troubleshooting_admin_hooks() {

        add_action('admin_menu', array($this, 'register_troubleshoot_menu_item'), 20);
        add_action('admin_init', array($this, 'update_troubleshooting_options'));

    }

    /**
     * Register troubleshooting submenu page
     */
    public function register_troubleshoot_menu_item() {

        add_submenu_page('edit.php?post_type=modula-gallery', esc_html__('Troubleshooting', 'modula-best-grid-gallery'), esc_html__('Troubleshooting', 'modula-best-grid-gallery'), 'manage_options', 'modula-troubleshooting', array($this, 'troubleshooting_options'));
    }

    /**
     * Add troubleshooting options section
     */
    public function troubleshooting_options() {
        wp_enqueue_style('modula-cpt-style', MODULA_URL . 'assets/css/modula-cpt.css', null, MODULA_LITE_VERSION);
        require_once MODULA_PATH . 'includes/admin/tabs/troubleshooting-options.php';
    }

    /**
     * Update troubleshooting options
     */
    public function update_troubleshooting_options() {

        if (!isset($_POST['modula-troubleshooting-submit'])) {
            return;
        }

        $troubleshooting_options['enqueue_files'] = isset($_POST['modula_troubleshooting_option']['enqueue_files']) ? $_POST['modula_troubleshooting_option']['enqueue_files'] : '';

        // check if master toggle is set, else set all subelements on false
        if ($troubleshooting_options['enqueue_files']) {

            $troubleshooting_options['grid_type']        = isset($_POST['modula_troubleshooting_option']['grid_type']) ? $_POST['modula_troubleshooting_option']['grid_type'] : false;
            $troubleshooting_options['lightbox']         = isset($_POST['modula_troubleshooting_option']['lightbox_type']) ? $_POST['modula_troubleshooting_option']['lightbox_type'] : false;
            $troubleshooting_options['pass_protect']     = isset($_POST['modula_troubleshooting_option']['pass_protect']) ? $_POST['modula_troubleshooting_option']['pass_protect'] : false;
            $troubleshooting_options['download_protect'] = isset($_POST['modula_troubleshooting_option']['download_protect']) ? $_POST['modula_troubleshooting_option']['download_protect'] : false;
            $troubleshooting_options['deeplink']         = isset($_POST['modula_troubleshooting_option']['deeplink']) ? $_POST['modula_troubleshooting_option']['deeplink'] : false;
        } else {

            $troubleshooting_options['grid_type']        = false;
            $troubleshooting_options['lightbox']         = false;
            $troubleshooting_options['pass_protect']     = false;
            $troubleshooting_options['download_protect'] = false;
            $troubleshooting_options['deeplink']         = false;
        }


        update_option('modula_troubleshooting_option', $troubleshooting_options);
    }

}

$modula_troubleshoot = Modula_Troubleshooting::get_instance();