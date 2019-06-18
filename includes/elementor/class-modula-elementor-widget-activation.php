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

		// Enqueue needed scripts and styles in Elementor preview
		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'modula_elementor_enqueue_scripts' ) );

		add_action( 'elementor/preview/enqueue_styles', array( $this, 'modula_elementor_enqueue_styles' ) );
	}

	public function test( $settings ) {
		return $settings;
	}


	/**
	 * Enqueue scripts in Elementor preview
	 */
	public function modula_elementor_enqueue_scripts() {
		wp_enqueue_script( 'modula', MODULA_URL . 'assets/js/jquery-modula.min.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		// @TODO enqueue script from pro vesion
		//wp_enqueue_script( 'modula-pro', '/wp-content/plugins/modula-pro/assets/js/modula-pro.js', array( 'jquery' ), '', true );
	}

	/**
	 *  Enqueue styles in Elementor preview
	 */
	public function modula_elementor_enqueue_styles(){
		// @TODO enqueue style from pro version
		//wp_enqueue_style( 'modula-pro-effects', MODULA_PRO_PATH.'assets/css/effects.css', '', null );
	}
}

// Instantiate Plugin Class
Modula_Elementor_Widget_Activation::instance();
