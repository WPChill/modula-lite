<?php

class Modula_Troubleshooting {

    private static $instance;

    /**
     * Modula_Troubleshooting constructor.
     */
    public function __construct() {
        $this->define_troubleshooting_admin_hooks();
        $this->define_troubleshooting_hooks();
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

    /**
     * Define public troubleshooting hooks
     */
    public function define_troubleshooting_hooks() {

    }

    /**
     * Define admin troubleshooting hooks
     */
    public function define_troubleshooting_admin_hooks() {

        add_action('admin_menu', array($this, 'register_troubleshoot_menu_item'),20);
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

        $troubleshooting_options['enqueue_css'] = isset($_POST['modula_troubleshooting_option']['enqueue_css']) ? $_POST['modula_troubleshooting_option']['enqueue_css'] : '';
        $troubleshooting_options['enqueue_js']  = isset($_POST['modula_troubleshooting_option']['enqueue_js']) ? $_POST['modula_troubleshooting_option']['enqueue_js'] : '';


        update_option('modula_troubleshooting_option', $troubleshooting_options);
    }

}

$modula_troubleshoot = Modula_Troubleshooting::get_instance();