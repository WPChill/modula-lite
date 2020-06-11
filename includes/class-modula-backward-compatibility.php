<?php

/**
 * 
 */
class Modula_Backward_Compatibility {
	
	function __construct() {
		
		// Backwards compatibility to ver. 2.3.0
		// Margin from creative gallery
		add_filter( 'modula_admin_field_value', array( $this, 'backward_compatibility_admin_margin' ), 10, 3 );
		add_filter( 'modula_gallery_settings', array( $this, 'backward_compatibility_front_margin' ), 10, 3 );
		add_filter( 'modula_backbone_settings', array( $this, 'backward_compatibility_backbone_margin' ), 10 );
		// Changed from disableSocials to enableSocials setting
		add_filter( 'modula_admin_field_value', array( $this, 'backward_compatibility_admin_enable_socials' ), 10, 3 );
		add_filter( 'modula_shortcode_item_data', array( $this, 'backward_compatibility_front_enable_socials' ), 15, 3 );
		add_filter( 'modula_backbone_settings', array( $this, 'backward_compatibility_enable_socials' ), 10 );

		// Lightbox set by default to fancybox
		add_filter( 'modula_admin_field_value', array( $this, 'backward_compatibility_admin_fancybox' ), 10, 3 );
		add_filter( 'modula_backbone_settings', array( $this, 'backward_compatibility_backbone_fancybox' ), 10 );

	}

	public function backward_compatibility_admin_margin( $value, $key, $settings ){

		if ( 'gutter' == $key && isset( $settings['type'] ) && 'creative-gallery' == $settings['type'] ) {
			if ( isset( $settings['margin'] ) ) {
				return $settings['margin'];
			}
		}

		return $value;

	}

	public function backward_compatibility_front_margin( $js_config, $settings ){

		if ( isset( $settings['type'] ) && 'creative-gallery' == $settings['type'] && isset( $settings['margin'] ) ) {
			$js_config['gutter'] = absint( $settings['margin'] );
		}
		return $js_config;

	}

	public function backward_compatibility_backbone_margin( $settings ){

		if ( isset( $settings['type'] ) && 'creative-gallery' == $settings['type'] && isset( $settings['margin'] ) ) {
			$settings['gutter'] = absint( $settings['margin'] );
		}

		return $settings;

	}

	public function backward_compatibility_admin_fancybox( $value, $key, $settings ){

		if ( 'lightbox' == $key && apply_filters( 'modula_disable_lightboxes', true ) && ! in_array( $value, array( 'no-link', 'direct', 'attachment-page' ) ) ) {
			return 'fancybox';
		}

		return $value;

	}

	public function backward_compatibility_backbone_fancybox( $settings ){

		if ( apply_filters( 'modula_disable_lightboxes', true ) && isset( $settings['lightbox'] ) && ! in_array( $settings['lightbox'], array( 'no-link', 'direct', 'attachment-page' ) ) ) {
			$settings['lightbox'] = 'fancybox';
		}

		return $settings;

	}

	/**
	 * Enable/Disable social icons compatibility
	 *
	 * @param $value
	 * @param $key
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.3.2
	 */
	public function backward_compatibility_admin_enable_socials( $value, $key, $settings ) {

		if ( 'enableSocial' == $key && isset( $settings['disableSocial'] ) ) {
			$value =  ('1' == $settings['disableSocial']) ? 0 : 1;
		}

		return $value;
	}

	/**
	 * Front end compatibility for enableSocial
	 *
	 * @param $item_data
	 * @param $image
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.3.3
	 */
	public function backward_compatibility_front_enable_socials($item_data,$image,$settings){

		if(isset($settings['disableSocial']) ){
			$item_data['hide_socials'] = boolval($settings['disableSocial']);
		}

		return $item_data;
	}

	/**
	 * Backbone compatibility for enableSocial setting
	 *
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.3.3
	 */
	public function backward_compatibility_enable_socials($settings){
		if(isset($settings['disableSocial'])){
			$settings['enableSocial'] = (1 == $settings['disableSocial']) ? 0 : 1;
		}

		return $settings;
	}

}

new Modula_Backward_Compatibility();