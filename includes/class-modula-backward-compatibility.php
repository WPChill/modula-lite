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

		// Responsive gutter
		add_filter( 'modula_admin_field_value', array( $this, 'backward_compatibility_admin_responsive_gutter' ), 10, 3 );
		add_filter( 'modula_backwards_compatibility_front', array( $this, 'backward_compatibility_front_responsive_gutter' ), 10 );
		add_filter( 'modula_backbone_settings', array( $this, 'backward_compatibility_backbone_responsive_gutter' ), 10 );

		// Responsive height
		add_filter( 'modula_admin_field_value', array( $this, 'backward_compatibility_admin_responsive_height' ), 10, 3 );
		add_filter( 'modula_backwards_compatibility_front', array( $this, 'backward_compatibility_front_responsive_height' ), 10 );
		add_filter( 'modula_backbone_settings', array( $this, 'backward_compatibility_backbone_responsive_height' ), 10 );

		// Thumbnail sizes
		// add_filter( 'modula_admin_field_value', array( $this, 'backward_compatibility_admin_thumb_size' ), 10, 3 );
		// add_filter( 'modula_backbone_settings', array( $this, 'backward_compatibility_backbone_thumb_size' ), 10 );

		// Backwards compatibility SpeedUp
		add_filter( 'modula_shortcode_item_data', array( $this, 'generate_optimized_image_links' ), 110, 3 );
		add_filter( 'modula_album_shortcode_item_data', array( $this, 'generate_optimized_image_links' ), 110, 3 );
		add_filter( 'modula_album_lightbox_item', array( $this, 'generate_optimized_image_links' ), 110, 3 );
		add_filter( 'modula_link_item', array( $this, 'generate_modula_link_image_url' ), 110, 4 );
		add_filter( 'modula_template_image_srcset', array( $this, 'modula_speedup_srcset' ), 31, 3 );

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

		if ( 'lightbox' == $key && apply_filters( 'modula_disable_lightboxes', true ) && ! in_array( $value, array( 'no-link', 'direct', 'external-url', 'attachment-page' ) ) ) {
			return 'fancybox';
		}

		return $value;

	}

	public function backward_compatibility_backbone_fancybox( $settings ) {
		if ( apply_filters( 'modula_disable_lightboxes', true ) && isset( $settings['lightbox'] ) && ! in_array( $settings['lightbox'], array( 'no-link', 'direct', 'external-url', 'attachment-page' ) ) ) {
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

	/**
	 * Backwards compatibility for responsie gutter
	 *
	 * @param $value
	 * @param $key
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function backward_compatibility_admin_responsive_gutter( $value, $key, $settings ) {

		if ( 'tablet_gutter' == $key && !isset( $settings[ 'tablet_gutter' ] ) && isset( $settings[ 'gutter' ] ) ) {
			return absint( $settings[ 'gutter' ] );
		}

		if ( 'mobile_gutter' == $key && !isset( $settings[ 'mobile_gutter' ] ) && isset( $settings[ 'gutter' ] ) ) {
			return absint( $settings[ 'gutter' ] );
		}

		return $value;

	}

	/**
	 *  Backwards compatibility for responsie gutter
	 *
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function backward_compatibility_front_responsive_gutter( $settings ) {

		// Backwards compatibility for tablet & mobile gutter.
		if ( isset( $settings['gutter'] ) ) {

			if ( ! isset( $settings['tablet_gutter'] ) ) {
				$settings['tablet_gutter'] = absint( $settings['gutter'] );
			}

			if ( ! isset( $settings['mobile_gutter'] ) ) {
				$settings['mobile_gutter'] = absint( $settings['gutter'] );
			}

		}

		return $settings;

	}

	/**
	 *  Backwards compatibility for responsie gutter
	 *
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function backward_compatibility_backbone_responsive_gutter( $settings ) {

		if ( !isset( $settings[ 'tablet_gutter' ] ) && isset( $settings[ 'gutter' ] ) ) {
			$settings[ 'tablet_gutter' ] = absint( $settings[ 'gutter' ] );
		}

		if ( !isset( $settings[ 'mobile_gutter' ] ) && isset( $settings[ 'gutter' ] ) ) {
			$settings[ 'mobile_gutter' ] = absint( $settings[ 'gutter' ] );
		}

		return $settings;

	}

	/**
	 * Backwards compatibility for responsie height
	 *
	 * @param $value
	 * @param $key
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.5.6
	 */
	public function backward_compatibility_admin_responsive_height( $value, $key, $settings ) {
		if(isset($settings['height'])){
			if($key == 'height' and !is_array($settings['height'])){
					$size = str_replace( array('px', '%'), '', $settings['height']);
					return array( $size, $size, $size );
			}
		}

		return $value;

	}

	/**
	 *  Backwards compatibility for responsie height
	 *
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.5.6
	 */
	public function backward_compatibility_front_responsive_height( $settings ) {

		// Backwards compatibility for tablet & mobile height.
		if ( isset( $settings['height'] ) ) {

			if( !is_array($settings['height'])){
				$settings['height'] = array( absint($settings['height'] ), absint($settings['height'] ), absint($settings['height'] ) );

			}

		}

		return $settings;

	}

	/**
	 *  Backwards compatibility for responsie height
	 *
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.5.6
	 */
	public function backward_compatibility_backbone_responsive_height( $settings ) {

		if ( isset( $settings[ 'height' ] ) and !is_array($settings[ 'height' ] ) ) {
			$settings[ 'height' ] = array( absint( $settings[ 'height' ] ),absint( $settings[ 'height' ] ),absint( $settings[ 'height' ] ) );
		}

		return $settings;

	}

	/**
	 * Backwards compatibility for thumbnail size
	 *
	 * @param $value
	 * @param $key
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function backward_compatibility_admin_thumb_size( $value, $key, $settings ){

		// Set Image Size to custom
		if ( 'grid_image_size' == $key && isset( $settings['img_size'] ) ) {
			return sanitize_text_field('custom');
		}

		// Set image sizes
		if ( 'grid_image_dimensions' == $key && isset( $settings[ 'img_size' ] ) && 'custom-grid' != $settings['type'] ) {

			return array(
				'width'  => absint( $settings[ 'img_size' ] ),
				'height' => absint( $settings[ 'img_size' ] )
			);
		}

		return $value;

	}

	/**
	 * Backwards compatibility for thumbnail size
	 *
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.5.0
	 */
	public function backward_compatibility_backbone_thumb_size( $settings ){

		if ( isset( $settings[ 'img_size' ] ) ) {

			$settings[ 'grid_image_size' ] = 'custom';
			if ( 'custom-grid' == $settings['type'] && ! isset( $settings['img_crop'] ) ) {
				$settings['img_crop'] = 1;
			}else{
				$settings[ 'grid_image_dimensions' ] = array(
					'width'  => absint( $settings[ 'img_size' ] ),
					'height' => absint( $settings[ 'img_size' ] )
				);

				unset($settings[ 'img_size' ]);
			}

			
		}

		return $settings;

	}


	/**
	 * SpeedUp compatibility
	 *
	 * @param $item_data
	 * @param $image
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.7.92
	 */
	public function generate_optimized_image_links( $item_data, $item, $settings ) {

		// Ensure that the settings are set.
		$settings = wp_parse_args( $settings, Modula_CPT_Fields_Helper::get_defaults() );

		if ( isset( $settings['enable_optimization'] ) && 'disabled' == $settings['enable_optimization'] ) {
			return $item_data;
		}

		$old = 'cdn.wp-modula.com';
		$new = apply_filters( 'modula_speedup_compatibility_domain', 'wp-modula.b-cdn.net' );

		if( isset( $item_data['img_attributes']['data-full'] ) ){
			$item_data['img_attributes']['data-full'] = str_replace( $old, $new, $item_data['img_attributes']['data-full'] );
		}
		if( isset( $item_data['img_attributes']['src'] ) ){
			$item_data['img_attributes']['src'] = str_replace( $old, $new, $item_data['img_attributes']['data-src'] );
		}
		if( isset( $item_data['img_attributes']['data-src'] ) ){
			$item_data['img_attributes']['data-src'] = str_replace( $old, $new, $item_data['img_attributes']['data-src'] );
		}
		if( isset( $item_data['link_attributes']['data-thumb'] ) ){
			$item_data['link_attributes']['data-thumb'] = str_replace( $old, $new, $item_data['link_attributes']['data-thumb'] );
		}
		if( isset( $item_data['src'] ) ){
			$item_data['src'] = str_replace( $old, $new, $item_data['src'] );
		}
		if( isset( $item_data['opts']['thumb'] ) ){
			$item_data['opts']['thumb'] = str_replace( $old, $new, $item_data['opts']['thumb'] );
		}

		return $item_data;

	}

	public function generate_modula_link_image_url( $image_config, $image, $image_id, $gallery_settings ){

		return $this->generate_optimized_image_links( $image_config, $image, $gallery_settings );
	}

	public function modula_speedup_srcset( $srcset, $data, $image_meta ) {

		if ( ! isset( $data->compression ) || ! $data->compression ) {
			return $srcset;
		}

		$old = 'cdn.wp-modula.com';
		$new = apply_filters( 'modula_speedup_compatibility_domain', 'wp-modula.b-cdn.net' );

		$srcset = str_replace( $old, $new, $srcset ); 

		return $srcset;

	}

}

new Modula_Backward_Compatibility();