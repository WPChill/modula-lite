<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Modula_Importer {

    /**
     * Holds the class object.
     *
     * @since 2.2.7
     *
     * @var object
     */
    public static $instance;

    /**
     * Primary class constructor.
     *
     * @since 2.2.7
     */
    public function __construct() {

        // Add Importer Tab
        add_filter('modula_admin_page_tabs', array($this, 'add_importer_tab'));

       // Render Importer tab
        add_action('modula_admin_tab_importer', array($this, 'render_importer_tab'));

        // Include required scripts for import
        add_action('admin_enqueue_scripts', array($this, 'admin_importer_scripts'));

        add_filter('modula_admin_page_link',array($this,'migrator_menu'), 5,1);

        // Required files
        require_once MODULA_PATH . 'includes/migrate/wp-core-gallery/class-modula-wp-core-gallery-importer.php';

        // Load the plugin.
        $this->init();

    }

	/**
	 * Add sub-menu entry for Migrate
	 *
	 * @param $links
	 *
	 * @return mixed
	 */
    public function migrator_menu($links) {

        $links[] = array(
        	'page_title' => esc_html__( 'Migrate', 'modula-best-grid-gallery' ),
	        'menu_title'=> esc_html__( 'Migrate', 'modula-best-grid-gallery' ),
	        'capability' => 'manage_options',
	        'menu_slug' => 'edit.php?post_type=modula-gallery&page=modula&modula-tab=importer',
	        'function' => '',
	        'priority' => 45
        );
        return $links;
    }


    /**
     * Loads the plugin into WordPress.
     *
     * @since 2.2.7
     */
    public function init() {

        // Load admin only components.
        if (is_admin()) {
            add_filter('modula_uninstall_db_options',array($this,'uninstall_options'),16,1);
            add_action('wp_ajax_modula_importer_get_galleries',array($this,'get_source_galleries'));
        }

    }


    /**
     * Enqueue import script
     *
     * @since 2.2.7
     */
    public function admin_importer_scripts() {

        $screen = get_current_screen();

        // only enqueue script if we are in Modula Settings page
        if ('modula-gallery' == $screen->post_type && 'modula-gallery_page_modula' == $screen->base ) {

            $ajax_url      = admin_url('admin-ajax.php');
            $nonce         = wp_create_nonce('modula-importer');
            $empty_gallery = esc_html__('Please choose at least one gallery to migrate.', 'modula-best-grid-gallery');

            wp_enqueue_style('modula-importer', MODULA_URL . 'assets/css/admin/modula-importer.css', array(), MODULA_LITE_VERSION);
            wp_enqueue_script('modula-importer', MODULA_URL . 'assets/js/admin/modula-importer.js', array('jquery'), MODULA_LITE_VERSION, true);
            wp_localize_script(
                'modula-importer',
                'modula_importer',
                array(
                    'ajax'                    => $ajax_url,
                    'nonce'                   => $nonce,
                    'importing'               => '<span style="color:green">' . esc_html__(' Migration started...', 'modula-best-grid-gallery') . '</span>',
                    'empty_gallery_selection' => $empty_gallery,
                )
            );
        }
    }


    /**
     * Add Importer tab
     *
     * @param $tabs
     * @return mixed
     *
     * @since 2.2.7
     */
    public function add_importer_tab($tabs) {
        $tabs['importer'] = array(
            'label'    => esc_html__('Migrate galleries', 'modula-best-grid-gallery'),
            'priority' => 50,
        );

        return $tabs;
    }


    /**
     * Render Importer tab
     *
     * @since 2.2.7
     */
    public function render_importer_tab() {
        include 'tabs/modula-importer-tab.php';
    }


    /**
     * Add migrate DB options to uninstall
     *
     * @param $options_array
     * @return mixed
     *
     * @since 2.2.7
     */
    public function uninstall_options($options_array){
        array_push($options_array,'modula_importer');

        return $options_array;
    }

    /**
     * Get gallery sources
     *
     * @return mixed
     *
     * @since 2.2.7
     */
    public function get_sources() {

        global $wpdb;
        $sources = array();

        // Assume they are none
	    $wp_core      = false;


        $sql     = "SELECT COUNT(ID) FROM " . $wpdb->prefix . "posts WHERE `post_content` LIKE '%[galler%' AND `post_status` = 'publish'";
        $wp_core = $wpdb->get_results($sql);

        // Need to get this so we can handle the object to check if mysql returned 0
        $wp_core_return = (NULL != $wp_core) ? get_object_vars($wp_core[0]) : false;

        // Check to see if there are any entries and insert into array
	    if ( $wp_core && null != $wp_core && ! empty( $wp_core ) && $wp_core_return && '0' != $wp_core_return['COUNT(ID)'] ) {
		    $sources['wp_core'] = 'WP Core Galleries';
	    }

	    $sources = apply_filters( 'modula_migrator_sources', $sources );

	    if ( ! empty( $sources ) ) {
		    return $sources;
	    }

        return false;
    }


    /**
     * Get galleries for sources
     *
     * @since 2.2.7
     */
    public function get_source_galleries() {

        check_ajax_referer('modula-importer', 'nonce');
        $source = isset($_POST['source']) ? sanitize_text_field( wp_unslash( $_POST['source'] ) ) : false;

        if (!$source || 'none' == $source) {
            echo esc_html__('There is no source selected', 'modula-best-grid-gallery');
            wp_die();
        }

        $import_settings = get_option('modula_importer');
        $import_settings = wp_parse_args($import_settings, array('galleries' => array()));
        $galleries       = array();
        $html            = '';

	    switch ( $source ) {
		    case 'wp_core':
			    $gal_source = Modula_WP_Core_Gallery_Importer::get_instance();
			    $galleries  = $gal_source->get_galleries();
			    break;
		    default:
			    $galleries = apply_filters( 'modula_source_galleries_' . $source, array() );
			    break;
	    }

        // Although this isn't necessary, sources have been checked before in tab
        // it is best if we do another check, just to be sure.
        if (!isset($galleries['valid_galleries']) && isset($galleries['empty_galleries']) && count($galleries['empty_galleries']) > 0) {
            printf(esc_html__('While we’ve found %s gallery(ies) we could import , we were unable to find any images associated with it(them). There’s no content for us to import .','modula-best-grid-gallery'),count($galleries['empty_galleries']));
            wp_die();
        }

        foreach ($galleries['valid_galleries'] as $key => $gallery) {
            $imported = false;
            $importing_status = '';
            switch ( $source ) {
                case 'wp_core':
                    $value = json_encode( array( 'id' => $gallery['page_id'], 'shortcode' => $gallery['shortcode'] ) );
	                $g_gallery = array(
		                'id'       => $gallery['page_id'] . '-' . $gallery['gal_nr'],
		                'imported' => ( isset( $import_settings['galleries'][ $source ] ) && 'modula-gallery' == $modula_gallery ),
		                'title'    => '<a href="' . admin_url( '/post.php?post=' . absint( $gallery['page_id'] ) . '&action=edit' ) . '" target="_blank">' . esc_html( $gallery['title'] ) . '</a>',
		                'count'    => $gallery['images']
	                );
                    break;
                default:
	                $g_gallery = apply_filters( 'modula_g_gallery_' . $source, array(), $gallery, $import_settings );
					break;

            }

	        // Small fix for wp_core galleries
	        $val          = ( $value ) ? $value : $g_gallery['id'];
	        $upload_count = absint( $g_gallery['count'] );
	        $id           = absint( $g_gallery['id'] );

            $html .= '<div class="modula-importer-checkbox-wrapper">' .
                     '<label for="' . esc_attr( $source ) . '-galleries-' . esc_attr( $id ) . '"' .
                     ' data-id="' . esc_attr( $id ) . '" ' . ( $imported ? 'data-imported="true" class="imported"' : '' ) . '>' .
                     '<input type="checkbox" name="gallery"' .
                     ' id="' . esc_attr( $source ) . '-galleries-' . esc_attr( $id ) . '"' .
                     'data-image-count="'.esc_attr($upload_count).'" data-id="'.esc_attr($id).'" value="' . esc_attr( $val ) . '"/>';
           // Title is escaped above
            $html .= $g_gallery['title'] ;

            // Display text on LITE. On PRO version
            $lite = apply_filters( 'modula_lite_migration_text', '' );
            $html .= $lite;

            $html .= '<span class="modula-importer-gallery-status">';

            if ( $imported ) {
                $html .= '<i class="imported-check dashicons dashicons-yes"></i>';
            }

            $html .= '</span>';

	        $html .= $importing_status . '</label></div>';

        }

        echo $html;
        wp_die();
    }


	/**
	 * Prepare gallery images
	 *
	 *
	 * @param $source
	 * @param $data
	 *
	 * @return array|bool|object|void 0|array|bool|mixed|object|null
	 *
	 * @since 2.2.7
	 */
    public function prepare_images($source,$data){

        global $wpdb;
        $images = array();

        switch ($source){

            case 'wp_core':
                $images         = explode(',', $data);
                break;
	        default :
		        $images = apply_filters( 'modula_migrator_images_' . $source, array(), $data );
        }

	    if ( $images && ! empty( $images ) ) {
		    return $images;
	    }

        return false;

    }

    /**
     * Returns the singleton instance of the class.
     *
     * @return object The Modula_Importer object.
     *
     * @since 2.2.7
     */
    public static function get_instance() {

        if (!isset(self::$instance) && !(self::$instance instanceof Modula_Importer)) {
            self::$instance = new Modula_Importer();
        }

        return self::$instance;
    }
}

$modula_importer = Modula_Importer::get_instance();