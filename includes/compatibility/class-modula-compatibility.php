<?php


class Modula_Compatibility {

	/**
	 * Holds the class object.
	 *
	 * @since 2.5.0
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Modula_Compatibility constructor.
	 *
	 * @since 2.5.0
	 */
	function __construct() {

		add_filter( 'modula_speedup_tab_content', array( $this, 'modula_lazyloading_compatibilty_admin' ), 5 );
		add_filter( 'modula_field_type_toggle_format', array( $this, 'modula_lazyloading_compatibilty_admin_field' ), 99, 2 );
		add_filter( 'modula_gallery_settings', array( $this, 'modula_gallery_config_compatibility' ), 99 );
		add_filter( 'modula_lazyload_compatibility_script', array( $this, 'modula_lazyload_compatibility_script' ), 99 );
		add_filter( 'modula_lazyload_compatibility_item', array( $this, 'modula_lazyload_compatibility_item' ), 99 );
		add_filter( 'modula_admin_field_value', array( $this, 'lazyload_admin_compatibility' ), 99, 3 );
		add_filter( 'modula_backbone_settings', array( $this, 'lazyload_backbone_compatibility' ), 99 );

	}

	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Compatibility object.
	 * @since 2.5.0
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !( self::$instance instanceof Modula_Compatibility ) ) {
			self::$instance = new Modula_Compatibility();
		}

		return self::$instance;

	}


	/**
	 * Compatibility text that is shown in tabs
	 *
	 * @param       $description
	 *
	 * @return string
	 * @since 2.5.0
	 */
	public function generate_compatibility_box( $description ) {

		$content_box = '<div class="modula-compatibility">';
		$content_box .= '<p class="modula-compatibility-description">' . esc_html( $description ) . '</p>';
		$content_box .= '</div>';

		return $content_box;
	}

	/**
	 * Lazyload compatibility check for certain plugins/themes
	 *
	 * @param $tab_content
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function modula_lazyloading_compatibilty_admin( $tab_content ) {

		if ( $this->sg_optimizer_check() ) {

			$compatibility_description = esc_html__( 'We detected that you are using Site Ground Optimizer lazyloading software that conflicts with ours. If you wish to use ours, please disable Site Ground\'s lazy loading. Else, our lazy loading will be disabled by default.', 'modula-best-grid-gallery' );

			$tab_content .= $this->generate_compatibility_box( $compatibility_description );
		}

		if ( $this->avada_check() ) {

			$compatibility_description = esc_html__( 'We detected that you are using Avada lazyloading software that conflicts with ours. If you wish to use ours, please disable Avada\'s lazy loading. Else, our lazy loading will be disabled by default.', 'modula-best-grid-gallery' );

			$tab_content .= $this->generate_compatibility_box( $compatibility_description );
		}

		if ( $this->jetpack_check() ) {

			$compatibility_description = esc_html__( 'We detected that you are using Jepack\'s lazyloading software that conflicts with ours. We enabled our by default so that we can overwrite Jetpack\'s one for our galleries.', 'modula-best-grid-gallery' );

			$tab_content .= $this->generate_compatibility_box( $compatibility_description );
		}

		return $tab_content;

	}

	/**
	 * Check if Site Ground Optimizer is active and has enabled lazyloading
	 *
	 * @return bool
	 */
	public function sg_optimizer_check() {
		if ( class_exists( '\SiteGround_Optimizer\Options\Options' ) && \SiteGround_Optimizer\Options\Options::is_enabled( 'siteground_optimizer_lazyload_images' ) ) {

			return true;
		}

		return false;
	}

	/**
	 * Check if Avada is active and has enabled lazyloading
	 *
	 * @return bool
	 */
	public function avada_check(){

		if ( !defined('AVADA_VERSION') || !class_exists('FusionReduxFramework') ){
			return false;
		}

		$avada_options = get_option( 'fusion_options' );

		if ( $avada_options && isset( $avada_options['lazy_load'] ) && 'avada' == $avada_options['lazy_load'] ){
			return true;
		}

		return false;
	}

	/**
	 * Check if Jetpack is active and has enabled lazyloading
	 *
	 * @return bool
	 */
	public function jetpack_check(){

		if ( !class_exists('Jetpack') || !defined('JETPACK__VERSION') ){
			return false;
		}

		$jetpack_modules = get_option( 'jetpack_active_modules' );

		if ( $jetpack_modules && in_array( 'lazy-images', $jetpack_modules ) ){
			return true;
		}

		return false;
	}

	/**
	 * Check if other lazyloading software is used
	 *
	 * @return bool
	 * @since 2.5.0
	 */
	public function check_lazyloading() {

		if ( $this->sg_optimizer_check() || $this->avada_check() || $this->jetpack_check() ) {

			return true;
		}

		return false;
	}

	/**
	 * Add extra HTML markup on fields format
	 *
	 * @param $format
	 * @param $field
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function modula_lazyloading_compatibilty_admin_field( $format, $field ) {

		if ( $this->check_lazyloading() ) {

			if ( 'lazy_load' == $field[ 'id' ] ) {
				$format .= '<div class="modula-compatibility-block"></div>';
			}
		}

		return $format;
	}

	/**
	 * Gallery configuration lazyload compatibility
	 *
	 * @param $js_config
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function modula_gallery_config_compatibility( $js_config ) {

		if ( $this->check_lazyloading() ) {

			$js_config[ 'lazyLoad' ] = 1;
		}

		return $js_config;
	}

	/**
	 * Dequeue Modula's lazyload script
	 *
	 * @return bool
	 * @since 2.5.0
	 */
	public function modula_lazyload_compatibility_script($return) {

		if ( $this->check_lazyloading() ){
			if ( !$this->jetpack_check() ){
				return false;
			} else {
				return true;
			}

		}

		return $return;
	}

	/**
	 * Return item data if other lazyloading is enabled
	 *
	 * @return bool
	 * @since 2.5.0
	 */
	public function modula_lazyload_compatibility_item() {

		if ( $this->check_lazyloading() ) {
			return false;
		}

		return true;
	}

	/**
	 * Admin lazy load value
	 *
	 * @param $value
	 * @param $key
	 * @param $settings
	 *
	 * @return int
	 * @since 2.5.0
	 */
	public function lazyload_admin_compatibility( $value, $key, $settings ){

		if ( 'lazy_load' == $key && $this->check_lazyloading() ){
			if ( !$this->jetpack_check() ){
				return 0;
			} else {
				return 1;
			}
		}

		return $value;
	}

	/**
	 * Settings updated options
	 *
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function lazyload_backbone_compatibility( $settings ){

		if ( isset( $settings['lazy_load'] ) && $this->check_lazyloading() ){

			if ( !$this->jetpack_check() ){
				$settings['lazy_load'] = 0;
			} else {
				$settings['lazy_load'] = 1;
			}
		}

		return $settings;
	}

}

$modula_compatibility = Modula_Compatibility::get_instance();