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

        $general_fields = Modula_CPT_Fields_Helper::get_fields('general');

        $troubleshooting_fields['grid_type'] = array(
            'name'          => __('Select Grid type', 'modula-best-grid-gallery'),
            'data_settings' => 'grid_type',
            'type'          => 'select',
            'values'        => $general_fields['type']['values']
        );

        $troubleshooting_fields['lightbox'] = array(
            'name'          => __('Select Lightbox', 'modula-best-grid-gallery'),
            'data_settings' => 'lightbox',
            'type'          => 'select',
            'values'        => $general_fields['lightbox']['values']['Lightboxes']
        );

        $troubleshooting_fields['test'] = array(
            'name'          => __('Select test', 'modula-best-grid-gallery'),
            'data_settings' => 'test',
            'type'          => 'toggle',
            'values'        => $general_fields['lightbox']['values']['Lightboxes']
        );

        $troubleshooting_fields = apply_filters('modula_troubleshooting_fields', $troubleshooting_fields);

        ob_start();

        include MODULA_PATH . 'includes/admin/tabs/troubleshooting-options.php';

        $html = ob_get_contents();

        ob_end_clean();

        echo $html;
    }

    /**
     * Update troubleshooting options
     */
    public function update_troubleshooting_options() {

        if (!isset($_POST['modula-troubleshooting-submit'])) {
            return;
        }

        $troubleshooting_options = $_POST['modula_troubleshooting_option'];
        $ts_options              = array();

        if (is_array($troubleshooting_options) && !empty($troubleshooting_options)) {
            foreach ($troubleshooting_options as $option => $value) {
                $ts_options[$option] = $value;
            }
        }

        update_option('modula_troubleshooting_option', $ts_options);
    }

}

$modula_troubleshoot = Modula_Troubleshooting::get_instance();