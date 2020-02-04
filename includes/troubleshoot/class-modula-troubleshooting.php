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

        add_filter( 'modula_troubleshooting_frontend_handles', array( $this, 'check_lightbox' ), 10, 2 );
        add_filter( 'modula_troubleshooting_frontend_handles', array( $this, 'check_lazyload' ), 20, 2 );
        add_filter( 'modula_troubleshooting_frontend_handles', array( $this, 'check_gridtype' ), 30, 2 );
        add_filter( 'modula_troubleshooting_frontend_handles', array( $this, 'main_lite_files' ), 50, 2 );

        add_action( 'wp_enqueue_scripts', array($this, 'public_enqueue_scripts'), 99999);

    }

    /**
     * Define admin troubleshooting hooks
     */
    public function define_troubleshooting_admin_hooks() {

        add_filter('modula_admin_page_tabs', array($this, 'add_misc_tab'));
        add_action('modula_admin_tab_misc', array($this, 'show_misc_tab'));
        add_action('admin_init', array( $this, 'update_troubleshooting_options' ));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));

    }

    /**
     * Enqueue admin scripts
     */
    public function admin_enqueue_scripts() {

        $current_screen = get_current_screen();

        if ('modula-gallery_page_modula' == $current_screen->base) {
            wp_enqueue_script('modula-troubleshoot-conditions', MODULA_URL . 'assets/js/modula-troubleshoot-conditions.js', array(), MODULA_LITE_VERSION, true);
            wp_enqueue_style('modula-cpt-style', MODULA_URL . 'assets/css/modula-cpt.css', null, MODULA_LITE_VERSION);
        }

    }

    /**
     * Enqueue public scripts and styles
     */
    public function public_enqueue_scripts() {
        $defaults = apply_filters( 'modula_troubleshooting_defaults', array(
            'enqueue_files'    => false,
            'pass_protect'     => false,
            'download_protect' => false,
            'deeplink'         => false,
            'gridtypes'        => array(),
            'lightboxes'       => array(),
        ));

        $ts_opt = get_option( 'modula_troubleshooting_option', array() );
        $ts_opt = wp_parse_args( $ts_opt, $defaults );

        if ( $ts_opt['enqueue_files'] ) {

            $handles = array(
                'scripts' => array(),
                'styles'  => array(),
            );

            /**
             * Hook: modula_troubleshooting_frontend_handles.
             *
             * @hooked check_lightbox - 10
             * @hooked check_lazyload - 20
             * @hooked check_gridtype - 30
             * @hooked main_lite_files - 50
             */
            $handles = apply_filters( 'modula_troubleshooting_frontend_handles', $handles, $ts_opt );

            foreach ( $handles['scripts'] as $script_slug ) {
                if ( ! wp_script_is($script_slug, 'enqueued') ) {
                    wp_enqueue_script( $script_slug );
                }
            }

            foreach ( $handles['styles'] as $style_slug ) {
                if ( ! wp_style_is($style_slug, 'enqueued') ) {
                    wp_enqueue_style($style_slug);
                }
            }
        }

    }

    public function add_misc_tab($tabs){

        $tabs['misc'] = array(
            'label'    => esc_html__('Misc', 'modula-best-grid-gallery'),
            'priority' => 80
        );
        return $tabs;
    }

    public function show_misc_tab(){
        include MODULA_PATH . 'includes/admin/tabs/troubleshooting-options.php';
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

        if ( is_array( $troubleshooting_options ) && !empty( $troubleshooting_options ) ) {
            foreach ( $troubleshooting_options as $option => $value ) {
                if ( is_array( $value ) ) {
                    $ts_options[ $option ] = array_map( 'sanitize_text_field', $value );
                }else{
                    $ts_options[ $option ] = sanitize_text_field( $value );
                }
                
            }
        }

        update_option('modula_troubleshooting_option', $ts_options);
    }

    public function check_lightbox( $handles, $options ){

        $lightboxes = apply_filters( 'modula_troubleshooting_lightboxes_handles', array(
            'lightbox2' => array(
                'scripts' => 'modula-lightbox2',
                'styles'  => 'modula-lightbox2',
            )
        ));

        if ( ! empty( $options['lightboxes'] ) ) {
            foreach ( $options['lightboxes'] as $lightbox ) {
                
                if ( in_array( $lightbox, $lightboxes ) ) {
                    if ( isset( $lightboxes[ $lightbox ]['scripts'] ) ) {
                        $handles['scripts'][] = $lightboxes[ $lightbox ]['scripts'];
                    }
                    if ( isset( $lightboxes[ $lightbox ]['styles'] ) ) {
                        $handles['styles'][] = $lightboxes[ $lightbox ]['styles'];
                    }
                }

            }
        }

        return $handles;

    }

    public function check_lazyload( $handles, $options ){
        
        if ( $options['lazy_load'] ) {
            $handles['scripts'][] = 'modula-lazysizes';
        }

        return $handles;

    }

    public function check_gridtype( $handles, $options ){
        
        $gridtypes = apply_filters( 'modula_troubleshooting_gridtypes_handles', array(
            'custom-grid' => array(
                'scripts' => 'packery',
            )
        ));

        if ( ! empty( $options['gridtypes'] ) ) {
            foreach ( $options['gridtypes'] as $gridtype ) {
                
                if ( isset( $gridtypes[ $gridtype ] ) ) {
                    if ( isset( $gridtypes[ $gridtype ]['scripts'] ) ) {
                        $handles['scripts'][] = $gridtypes[ $gridtype ]['scripts'];
                    }
                    if ( isset( $gridtypes[ $gridtype ]['styles'] ) ) {
                        $handles['styles'][] = $gridtypes[ $gridtype ]['styles'];
                    }
                }

            }
        }

        return $handles;

    }

    public function main_lite_files( $handles ){
        $handles['scripts'][] = 'modula';
        $handles['styles'][] = 'modula';
        $handles['styles'][] = 'modula-effects';

        return $handles;
    }

}

$modula_troubleshoot = Modula_Troubleshooting::get_instance();