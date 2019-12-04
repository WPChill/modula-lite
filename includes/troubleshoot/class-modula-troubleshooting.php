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

        add_action('wp_enqueue_scripts', array($this, 'public_enqueue_scripts'), 99999);

    }

    /**
     * Define admin troubleshooting hooks
     */
    public function define_troubleshooting_admin_hooks() {

        add_action('admin_menu', array($this, 'register_troubleshoot_menu_item'), 20);
        add_action('admin_init', array($this, 'update_troubleshooting_options'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));

    }

    /**
     * Enqueue admin scripts
     */
    public function admin_enqueue_scripts() {
        $current_screen = get_current_screen();
        if ('modula-gallery_page_modula-troubleshooting' == $current_screen->base) {
            wp_enqueue_script('modula-troubleshoot-conditions', MODULA_URL . 'assets/js/modula-troubleshoot-conditions.js', array(), MODULA_LITE_VERSION, true);
        }

    }

    /**
     * Enqueue public scripts and styles
     */
    public function public_enqueue_scripts() {

        $ts_opt = get_option('modula_troubleshooting_option');

        if (isset($ts_opt['enqueue_files']) && '1' == $ts_opt['enqueue_files']) {

            $scripts = $this::enqueued_front_scripts();

            if (!isset($ts_opt['grid_type']) || 'custom-grid' != $ts_opt['grid_type']) {
                unset($scripts['scripts']['packery']);
            }

            if (!isset($ts_opt['lightbox']) || 'lightbox2' != $ts_opt['lightbox']) {
                unset($scripts['scripts']['lightbox2_script']);
                unset($scripts['styles']['lightbox2_stylesheet']);
            }

            if (!isset($ts_opt['lazy_load']) || '1' != $ts_opt['lazy_load']) {
                unset($scripts['scripts']['modula-lazysizes']);
            }

            foreach ($scripts['scripts'] as $script_slug => $name) {
                if (!wp_script_is($script_slug, 'enqueued')) {
                    wp_enqueue_script($script_slug, '', '', true);
                }
            }

            foreach ($scripts['styles'] as $style_slug => $name) {
                if (!wp_style_is($style_slug, 'enqueued')) {
                    wp_enqueue_style($style_slug);
                }
            }
        }

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
            'name'          => __('Select which grid type script to enqueue', 'modula-best-grid-gallery'),
            'data_settings' => 'grid_type',
            'type'          => 'select',
            'values'        => $general_fields['type']['values'],
            'default'       => 'creative-gallery'
        );

        $troubleshooting_fields['lightbox'] = array(
            'name'          => __('Select which Lightbox script to enqueue', 'modula-best-grid-gallery'),
            'data_settings' => 'lightbox',
            'type'          => 'select',
            'values'        => $general_fields['lightbox']['values']['Lightboxes'],
            'default'       => 'lightbox2'
        );

        $troubleshooting_fields['lazy_load'] = array(
            'name'          => __('Enqueue Lazyload script', 'modula-best-grid-gallery'),
            'data_settings' => 'lazy_load',
            'type'          => 'toggle',
            'default'       => 0
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


    /**
     * @return mixed|void
     *
     * Enqueue frontend scripts
     */
    public static function enqueued_front_scripts() {
        $scripts['scripts'] = apply_filters('modula_frontend_scripts', array(
            'lightbox2_script' => 'Lightbox2 script',
            'packery'          => 'Packery script',
            'modula-lazysizes' => 'Lazy load script',
            'modula'           => 'Modula main js file'
        ));

        $scripts['styles'] = apply_filters('modula_frontend_styles', array(
            'lightbox2_stylesheet' => 'Lightbox2 style',
            'modula'               => 'Modula main style'
        ));

        return $scripts;
    }

}

$modula_troubleshoot = Modula_Troubleshooting::get_instance();