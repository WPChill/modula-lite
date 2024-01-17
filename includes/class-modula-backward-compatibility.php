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

		add_filter( 'modula_fancybox_options', array( $this, 'modula_fancybox_5_settings_matcher' ), 99999, 2 );
		add_filter( 'modula_shortcode_css', array( $this, 'modula_fancybox_5_css_matcher' ), 99999, 3 );
		add_filter( 'modula_link_shortcode_css', array( $this, 'modula_fancybox_5_css_matcher' ), 99999, 3 );
		
		
		// Thumbnail sizes
		// add_filter( 'modula_admin_field_value', array( $this, 'backward_compatibility_admin_thumb_size' ), 10, 3 );
		// add_filter( 'modula_backbone_settings', array( $this, 'backward_compatibility_backbone_thumb_size' ), 10 );

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

		if ( 'lightbox' == $key && apply_filters( 'modula_disable_lightboxes', true ) && ! in_array( $value, array( 'no-link', 'direct', 'external-url' ) ) ) {
			return 'fancybox';
		}

		return $value;

	}

	public function backward_compatibility_backbone_fancybox( $settings ){

		if ( apply_filters( 'modula_disable_lightboxes', true ) && isset( $settings['lightbox'] ) && ! in_array( $settings['lightbox'], array( 'no-link', 'direct', 'external-url' ) ) ) {
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

	public function modula_fancybox_5_settings_matcher( $options, $settings ){

		if( ! isset( $options['mainClass'] ) ){
			$options['mainClass'] = "modula-fancybox-container modula-lightbox-" . $settings['gallery_id'];
		}
		
		if( isset( $options['loop'] ) && $options['loop'] ){
			unset( $options['loop'] );
			$options['Carousel']['infinite'] = true;
		}
		
		if( isset( $options['transitionEffect'] ) && 'slide' == $options['transitionEffect'] ){
			unset( $options['transitionEffect'] );
			$options['Carousel']['transition'] = 'slide';
		}

		if( isset( $options['toolbar'] ) && $options['toolbar'] ){
			unset( $options['toolbar'] );
			if( ! isset( $options['Toolbar'] ) || ! isset( $options['Toolbar']['display'] ) || ! isset( $options['Toolbar']['display']['right'] ) ){
				$options['Toolbar']['display']['right'] = [];
			}
		}
				
		if( isset( $options['infobar'] )){
			unset( $options['infobar'] );
			$options['Toolbar']['display']['left'][] = 'infobar';
		}

		if( isset( $options['buttons'] )){
			if( is_array( $options['buttons'] ) ){
				foreach( $options['buttons'] as $button ){
					switch ( $button ) {
						case 'zoom':
							$options['Toolbar']['display']['right'][] = 'zoomIn';
							$options['Toolbar']['display']['right'][] = 'zoomOut';
							$options['Toolbar']['display']['right'][] = 'iterateZoom';
							break;
						case 'share':
							$options['Toolbar']['items']['share']['tpl'] = '<button data-fancybox-share class="f-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M2.55 19c1.4-8.4 9.1-9.8 11.9-9.8V5l7 7-7 6.3v-3.5c-2.8 0-10.5 2.1-11.9 4.2z"/></svg></button>';
							$options['Toolbar']['display']['right'][] = 'share';
							break;
						case 'download':
							$options['Toolbar']['display']['right'][] = 'download';
							break;
						case 'thumbs':
							$options['Toolbar']['display']['right'][] = 'thumbs';
							break;
						case 'close':
							// if close button is set from LITE, remove it.
							if ( ( $key = array_search( 'close', $options['Toolbar']['display']['right'] ) ) !== false ) {
								array_splice($options['Toolbar']['display']['right'], $key, 1 );
							}
							// Add close button at the updated position.
							$options['Toolbar']['display']['right'][] = 'close';
							break;
						case 'downloadAll':
							$options['Toolbar']['items']['downloadAll']['tpl'] = '<a class="modula-fancybox-button download-all f-button" title="Download All" href="' . esc_url( modula_download_req_url( $settings['gallery_id'] ) ) . '"> <svg xmlns="http://www.w3.org/2000/svg" width="2480" height="3507" viewBox="0 0 2480 3507">
							<rect class="cls-1" x="5" y="2512" width="2475" height="996"/>
							<path id="ALL" class="cls-2" d="M627.528,2585.41L352.443,3406.16H487.6l64.474-199.75H848.647L917.9,3406.16H1054.01L759.34,2585.41H627.528Zm66.383,175.66,112.709,324.9H591.232Zm438.419-175.66v820.75h452.74V3282.19h-323.8V2585.41H1132.33Zm541.09,0v820.75h452.75V3282.19h-323.8V2585.41H1673.42Z"/>
							<rect class="cls-1" x="1001" y="6" width="453" height="1506"/>
							<path class="cls-3" d="M296,1399.6l295.125-296.49,406.3,408.19H1456.28L1869.66,1096,2185,1412.8,1253.13,2349Z"/>
							</svg></a>';
							$options['Toolbar']['display']['right'][] = 'downloadAll';
							break;
						case 'fullScreen':
							$options['Toolbar']['display']['right'][] = 'fullscreen';
							break;
						case 'slideShow':
							$options['Toolbar']['display']['right'][] = 'slideshow';
							break;
							
					}
				}
			}

			unset( $options['buttons'] );
		}

		if( isset( $options['keyboard'] ) ){
			if( $options['keyboard'] ){
				$options['keyboard'] = array(
					'Escape' => "close",
					'Delete' => "close",
					'Backspace' => "close",
					'PageUp' => "next",
					'PageDown' => "prev",
					'ArrowUp' => "prev",
					'ArrowDown' => "next",
					'ArrowRight' => "next",
					'ArrowLeft' => "prev",
				);
			}else{
				$options['keyboard'] = array(
					'Escape' => "close",
				);
			}

		}

		if( isset( $options['wheel'] ) && $options['wheel'] ){
			$options['wheel'] = 'slide';
		}

		if( isset( $options['clickSlide'] ) ){
			unset( $options['clickSlide'] );
			$options['backdropClick'] = 'close';
		}

		if( isset( $options['dblclickSlide'] ) ){
			unset( $options['dblclickSlide'] );
			$options['backdropDblClick'] = 'close';
		}

		if( isset( $options['thumbs'] ) && isset( $options['thumbs']['autoStart'] ) ){
			if( $options['thumbs']['autoStart'] ){
				$options['Thumbs']['showOnStart'] = true;
			}else{
				$options['Thumbs']['showOnStart'] = false;
			}

			unset( $options['thumbs'] );
		}

		if( isset( $options['fullScreen'] ) && isset( $options['fullScreen']['autoStart'] ) ){
			$options['Fullscreen'] = array( 'autoStart' => $options['fullScreen']['autoStart'] );
		}

		if( isset( $options['slideShow'] ) ){
			if( isset( $options['slideShow']['autoStart'] ) ){
				$options['Slideshow']['playOnStart'] = $options['slideShow']['autoStart'];
			}
			if( isset( $options['slideShow']['speed'] ) ){
				$options['Slideshow']['timeout'] = absint( $options['slideShow']['speed'] );
			}
			$options['Carousel']['infinite'] = true;
			unset( $options['slideShow'] );
		}

		if( isset( $options['fullScreen'] ) && isset( $options['fullScreen']['autoStart'] ) ){
			$options['Fullscreen'] = array( 'autoStart' => $options['fullScreen']['autoStart'] );
		}

		if( isset( $options['options'] ) && isset( $options['options']['protect'] ) ){
			$options['Images']['protected'] = $options['options']['protect'];
		}
		//echo '<pre>';var_dump($options);wp_die();
		return $options;
	}

	public function modula_fancybox_5_css_matcher(  $css, $gallery_id, $settings ){

		// caption positioning
		if ( isset( $settings['captionPosition'] ) ) {
			$pos = 'center';
			if ( 'left' == $settings['captionPosition'] ) {
				$pos = 'flex-start';
			}elseif ( 'right' == $settings['captionPosition'] ) {
				$pos = 'flex-end';
			}
			$css .= '.modula-fancybox-container.modula-lightbox-'. $settings['gallery_id'] . ' .fancybox__caption {align-self:' . esc_attr( $pos ) . '}';
		}

		if ( isset( $settings['lightbox_background_color'] ) && '' != $settings['lightbox_background_color'] ) {
			$css .= '.modula-fancybox-container.modula-lightbox-'.$settings['gallery_id'].' .fancybox__backdrop{background:' . $settings['lightbox_background_color'] . ';opacity:1 !important;}';
		}
		
		if ( isset( $settings['lightbox_active_colors'] ) && '' != $settings['lightbox_active_colors'] ){
			$css .= 'html body .modula-fancybox-container.modula-lightbox-'. $settings['gallery_id'] . ' .f-progress{background-color:' . $settings['lightbox_active_colors'] . ';}';
		}

		
		return $css;
	}

	

}

new Modula_Backward_Compatibility();