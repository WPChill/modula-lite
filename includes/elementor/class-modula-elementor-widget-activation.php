<?php

namespace ElementorModula;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class Modula_Elementor_Widget_Activation {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	private function include_widgets_files() {
		require_once( MODULA_PATH . 'includes/elementor/widgets/class-modula-elementor.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since  1.2.0
	 * @access public
	 */
	public function register_widgets() {
		$this->include_widgets_files();
		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Modula_Elementor_Widget() );
	}

	public function __construct() {

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );

		// Enqueue needed scripts for elementor Editor
        add_action( 'elementor/editor/before_enqueue_scripts', array($this, 'modula_elementor_enqueue_editor_scripts' ));

		// Enqueue needed scripts and styles in Elementor preview
		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'modula_elementor_enqueue_scripts' ) );
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'modula_elementor_enqueue_styles' ) );

		add_action('wp_ajax_modula_elementor_ajax_search',array($this,'modula_elementor_ajax_search'));

	}

    public function modula_elementor_enqueue_editor_scripts() {
        wp_enqueue_script( 'modula-elementor-editor', MODULA_URL . 'assets/js/admin/modula-elementor-editor.js', null, MODULA_LITE_VERSION, true );
        wp_localize_script('modula-elementor-editor','modula_elementor_ajax',array(
            'ajax_url' => admin_url( 'admin-ajax.php' )
        ));

        wp_enqueue_script( 'modula-selectize', MODULA_URL . 'assets/js/admin/selectize.js', null, MODULA_LITE_VERSION, true );
        wp_enqueue_style( 'modula-selectize', MODULA_URL . 'assets/css/admin/selectize.default.css' );
    }

	/**
	 * Enqueue scripts in Elementor preview
	 */
	public function modula_elementor_enqueue_scripts() {

		do_action( 'modula_elementor_before_enqueue_scripts' );

		wp_enqueue_script( 'modula-isotope' );
		wp_enqueue_script( 'modula-isotope-packery' );
		wp_enqueue_script( 'modula-grid-justified-gallery' );
		wp_enqueue_script( 'modula-lazysizes' );
		wp_enqueue_script( 'modula' );

		do_action( 'modula_elementor_before_enqueue_elementor-preview' );

		wp_enqueue_script( 'modula-elementor-preview', MODULA_URL . 'assets/js/admin/modula-elementor-preview.js', null, MODULA_LITE_VERSION, true );

		do_action( 'modula_elementor_after_enqueue_scripts' );
	}

	/**
	 *  Enqueue styles in Elementor preview
	 */
	public function modula_elementor_enqueue_styles() {
		do_action( 'modula_elementor_before_enqueue_styles' );
		wp_enqueue_style( 'modula' );
		do_action( 'modula_elementor_after_enqueue_styles' );
	}

	public function modula_elementor_ajax_search() {

        if ('modula_elementor_ajax_search' == $_POST['action']) {

            if ('' != $_POST['s']) {

                $args = array(
                    'post_type'      => 'modula-gallery',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                    's'              => sanitize_text_field($_POST['s'])
                );

                $query = new \WP_Query($args);

                if ( $query->have_posts() ) {
                	$galleries = $query->posts;
                    wp_send_json_success( $galleries );
                }

                wp_send_json_success();
                
            }
        }

        wp_send_json_error();
    }
}

// Instantiate Plugin Class
Modula_Elementor_Widget_Activation::instance();
