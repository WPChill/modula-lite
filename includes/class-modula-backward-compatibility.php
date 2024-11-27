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

		// Backwards compatibility for using fancybox 5 & vimeo video links.
		add_filter( 'modula_shortcode_item_data', array( $this, 'backward_compatibility_video_vimeo_link' ), 81, 3 );
		add_filter( 'modula_album_lightbox_item', array( $this, 'backward_compatibility_video_vimeo_link_albums' ), 99999, 3 );
		add_filter( 'modula_album_template_data', array( $this, 'backward_compatibility_albums_jsconfig' ), 99999 );

		// Backwards compatibility SpeedUp
		add_filter( 'modula_shortcode_item_data', array( $this, 'generate_optimized_image_links' ), 110, 3 );
		add_filter( 'modula_album_shortcode_item_data', array( $this, 'generate_optimized_image_links' ), 110, 3 );
		add_filter( 'modula_album_lightbox_item', array( $this, 'generate_optimized_image_links' ), 110, 3 );
		add_filter( 'modula_link_item', array( $this, 'generate_modula_link_image_url' ), 110, 4 );
		add_filter( 'modula_template_image_srcset', array( $this, 'modula_speedup_srcset' ), 31, 3 );
	}

	public function backward_compatibility_admin_margin( $value, $key, $settings ) {

		if ( 'gutter' == $key && isset( $settings['type'] ) && 'creative-gallery' == $settings['type'] ) {
			if ( isset( $settings['margin'] ) ) {
				return $settings['margin'];
			}
		}

		return $value;
	}

	public function backward_compatibility_front_margin( $js_config, $settings ) {

		if ( isset( $settings['type'] ) && 'creative-gallery' == $settings['type'] && isset( $settings['margin'] ) ) {
			$js_config['gutter'] = absint( $settings['margin'] );
		}
		return $js_config;
	}

	public function backward_compatibility_backbone_margin( $settings ) {

		if ( isset( $settings['type'] ) && 'creative-gallery' == $settings['type'] && isset( $settings['margin'] ) ) {
			$settings['gutter'] = absint( $settings['margin'] );
		}

		return $settings;
	}

	public function backward_compatibility_admin_fancybox( $value, $key, $settings ) {

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
			$value = ( '1' == $settings['disableSocial'] ) ? 0 : 1;
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
	public function backward_compatibility_front_enable_socials( $item_data, $image, $settings ) {

		if ( isset( $settings['disableSocial'] ) ) {
			$item_data['hide_socials'] = boolval( $settings['disableSocial'] );
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
	public function backward_compatibility_enable_socials( $settings ) {
		if ( isset( $settings['disableSocial'] ) ) {
			$settings['enableSocial'] = ( 1 == $settings['disableSocial'] ) ? 0 : 1;
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

		if ( 'tablet_gutter' == $key && ! isset( $settings['tablet_gutter'] ) && isset( $settings['gutter'] ) ) {
			return absint( $settings['gutter'] );
		}

		if ( 'mobile_gutter' == $key && ! isset( $settings['mobile_gutter'] ) && isset( $settings['gutter'] ) ) {
			return absint( $settings['gutter'] );
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

		if ( ! isset( $settings['tablet_gutter'] ) && isset( $settings['gutter'] ) ) {
			$settings['tablet_gutter'] = absint( $settings['gutter'] );
		}

		if ( ! isset( $settings['mobile_gutter'] ) && isset( $settings['gutter'] ) ) {
			$settings['mobile_gutter'] = absint( $settings['gutter'] );
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
		if ( isset( $settings['height'] ) ) {
			if ( $key == 'height' and ! is_array( $settings['height'] ) ) {
					$size = str_replace( array( 'px', '%' ), '', $settings['height'] );
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

			if ( ! is_array( $settings['height'] ) ) {
				$settings['height'] = array( absint( $settings['height'] ), absint( $settings['height'] ), absint( $settings['height'] ) );

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

		if ( isset( $settings['height'] ) and ! is_array( $settings['height'] ) ) {
			$settings['height'] = array( absint( $settings['height'] ), absint( $settings['height'] ), absint( $settings['height'] ) );
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
	public function backward_compatibility_admin_thumb_size( $value, $key, $settings ) {

		// Set Image Size to custom
		if ( 'grid_image_size' == $key && isset( $settings['img_size'] ) ) {
			return sanitize_text_field( 'custom' );
		}

		// Set image sizes
		if ( 'grid_image_dimensions' == $key && isset( $settings['img_size'] ) && 'custom-grid' != $settings['type'] ) {

			return array(
				'width'  => absint( $settings['img_size'] ),
				'height' => absint( $settings['img_size'] ),
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
	public function backward_compatibility_backbone_thumb_size( $settings ) {

		if ( isset( $settings['img_size'] ) ) {

			$settings['grid_image_size'] = 'custom';
			if ( 'custom-grid' == $settings['type'] && ! isset( $settings['img_crop'] ) ) {
				$settings['img_crop'] = 1;
			} else {
				$settings['grid_image_dimensions'] = array(
					'width'  => absint( $settings['img_size'] ),
					'height' => absint( $settings['img_size'] ),
				);

				unset( $settings['img_size'] );
			}
		}

		return $settings;
	}

	public function modula_fancybox_5_settings_matcher( $options, $settings ) {

		if ( ! isset( $options['mainClass'] ) && isset( $settings['gallery_id'] ) ) {
			$options['mainClass'] = 'modula-fancybox-container modula-lightbox-' . $settings['gallery_id'];
		}

		if ( isset( $options['loop'] ) && $options['loop'] ) {
			unset( $options['loop'] );
			$options['Carousel']['infinite'] = true;
		}

		if ( isset( $options['transitionEffect'] ) && 'slide' == $options['transitionEffect'] ) {
			unset( $options['transitionEffect'] );
			$options['Carousel']['transition'] = 'slide';
		}

		if ( isset( $options['infobar'] ) && $options['infobar'] ) {
			unset( $options['infobar'] );
			$options['Toolbar']['display']['left'][] = 'infobar';
		} elseif ( isset( $options['infobar'] ) && ! $options['infobar'] ) {
			$options['Toolbar']['display']['left'] = array();
		}

		if ( isset( $options['buttons'] ) ) {
			// we have overruling options from addons, reset the toolbar.
			if ( ! isset( $options['toolbar'] ) || ! $options['toolbar'] ) {
				$options['Toolbar']['display']['right'] = array();
			}

			if ( is_array( $options['buttons'] ) && isset( $options['toolbar'] ) && $options['toolbar'] ) {
				foreach ( $options['buttons'] as $button ) {
					switch ( $button ) {
						case 'zoom':
							$options['Toolbar']['display']['right'][] = 'zoomIn';
							$options['Toolbar']['display']['right'][] = 'zoomOut';
							break;
						case 'share':
							$options['Toolbar']['items']['share']['tpl'] = '<button data-fancybox-share class="f-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M2.55 19c1.4-8.4 9.1-9.8 11.9-9.8V5l7 7-7 6.3v-3.5c-2.8 0-10.5 2.1-11.9 4.2z"/></svg></button>';
							$options['Toolbar']['display']['right'][]    = 'share';
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
								array_splice( $options['Toolbar']['display']['right'], $key, 1 );
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
							$options['Toolbar']['display']['right'][]          = 'downloadAll';
							break;
						case 'fullScreen':
							$options['Toolbar']['display']['right'][] = 'fullscreen';
							break;
						case 'slideShow':
							$options['Toolbar']['display']['right'][] = 'slideshow';
							break;

					}
				}
				// This is required to show the toolbar if there aren't
				// any images in lightbox ( eg. 2 videos, 0 images ).
				$options['Toolbar']['enabled'] = true;
			}
			unset( $options['buttons'] );
		}

		if ( isset( $options['keyboard'] ) ) {
			if ( $options['keyboard'] ) {
				$options['keyboard'] = array(
					'Escape'     => 'close',
					'Delete'     => 'close',
					'Backspace'  => 'close',
					'PageUp'     => 'next',
					'PageDown'   => 'prev',
					'ArrowUp'    => 'prev',
					'ArrowDown'  => 'next',
					'ArrowRight' => 'next',
					'ArrowLeft'  => 'prev',
				);
			} else {
				$options['keyboard'] = array(
					'Escape'     => 'close',
					'Delete'     => 'close',
					'Backspace'  => 'close',
					'PageUp'     => false,
					'PageDown'   => false,
					'ArrowUp'    => false,
					'ArrowDown'  => false,
					'ArrowRight' => false,
					'ArrowLeft'  => false,
				);
			}
		}

		if ( isset( $options['wheel'] ) && $options['wheel'] ) {
			$options['wheel'] = 'slide';
		}

		if ( isset( $options['clickSlide'] ) ) {
			unset( $options['clickSlide'] );
			$options['backdropClick'] = 'close';
		}

		if ( isset( $options['dblclickSlide'] ) ) {
			unset( $options['dblclickSlide'] );
			$options['backdropDblClick'] = 'close';
		}

		if ( isset( $options['thumbs'] ) && isset( $options['thumbs']['autoStart'] ) ) {
			if ( $options['thumbs']['autoStart'] ) {
				$options['Thumbs']['showOnStart'] = true;
			} else {
				$options['Thumbs']['showOnStart'] = false;
			}

			unset( $options['thumbs'] );
		}

		if ( isset( $settings['lightbox_thumbsPosition'] ) ) {
			$options['Thumbs']['position'] = $settings['lightbox_thumbsPosition'];
		}

		if ( isset( $options['fullScreen'] ) && isset( $options['fullScreen']['autoStart'] ) ) {
			$options['Fullscreen'] = array( 'autoStart' => $options['fullScreen']['autoStart'] );
		}

		if ( isset( $options['slideShow'] ) ) {
			if ( isset( $options['slideShow']['autoStart'] ) ) {
				$options['Slideshow']['playOnStart'] = $options['slideShow']['autoStart'];
			}
			if ( isset( $options['slideShow']['speed'] ) ) {
				$options['Slideshow']['timeout'] = absint( $options['slideShow']['speed'] );
			}
			$options['Carousel']['infinite'] = true;
			unset( $options['slideShow'] );
		}

		if ( isset( $options['fullScreen'] ) && isset( $options['fullScreen']['autoStart'] ) ) {
			$options['Fullscreen'] = array( 'autoStart' => $options['fullScreen']['autoStart'] );
		}

		if ( isset( $options['options'] ) && isset( $options['options']['protect'] ) ) {
			$options['Images']['protected'] = $options['options']['protect'];
		}

		// Video Backwards comp.
		if ( ! isset( $options['Html']['videoTpl'] ) ) {
			$video_attrs = array(
				'controls',
				'muted',
				'playsinline',
				'controlsList',
				'autoplay',
			);

			if ( isset( $settings['loop-videos'] ) && 1 == $settings['loop-videos'] ) {

				$video_attrs[] = 'loop';
			}

			if ( ! isset( $settings['autoplay-videos'] ) || 1 != $settings['autoplay-videos'] ) {
				//Set autoplay false, default is true.
				$options['Html']['videoAutoplay'] = 0;

				//Remove autoplay attr.
				array_pop( $video_attrs );
			}

			$video_attrs     = implode( ' ', $video_attrs );
			$browser_support = sprintf( 'Sorry, your browser doesn\'t support embedded videos, %s download %s and watch with your favorite video player!', '<a href="{{src}}">', '</a>' );
			$video_tpl       = '<video class="fancybox__html5video" ' . esc_attr( $video_attrs ) . ' controlsList="nodownload" poster="{{poster}}" src="{{src}}" type="{{format}}" >  ' . $browser_support . ' </video>';

			$options['Html']['videoTpl'] = $video_tpl;
		}

		unset( $options['video'], $options['youtube'], $options['vimeo'] );
		// END Video Backwards comp.

		if ( isset( $settings['lightbox_touch'] ) && $settings['lightbox_touch'] ) {
			$options['Carousel']['Panzoom']['touch'] = true;
		}

		if ( isset( $settings['lightbox_transitionEffect'] ) ) {
			$options['Carousel']['transition'] = ( 'false' ===  $settings['lightbox_transitionEffect'] ) ? 'fade' : $settings['lightbox_transitionEffect'];
		}

		if ( isset( $settings['lightbox_animationEffect'] )
			&& $settings['lightbox_animationEffect'] !== 'false' ) {
			$options['Images']['zoom'] = false;
			$options['showClass']      = 'm-' . $settings['lightbox_animationEffect'] . 'In';
			$options['hideClass']      = 'm-' . $settings['lightbox_animationEffect'] . 'Out';
		}

		return $options;
	}

	public function modula_fancybox_5_css_matcher( $css, $gallery_id, $settings ) {

		// caption positioning
		if ( isset( $settings['captionPosition'] ) ) {
			$pos = 'center';
			if ( 'left' == $settings['captionPosition'] ) {
				$pos = 'flex-start';
			} elseif ( 'right' == $settings['captionPosition'] ) {
				$pos = 'flex-end';
			}
			$css .= '.modula-fancybox-container.modula-lightbox-' . $settings['gallery_id'] . ' .fancybox__caption {align-self:' . esc_attr( $pos ) . '}';
		}

		return $css;
	}

	/**
	 * Vimeo video compatibility for fancybox5
	 *
	 * @param $item_data
	 * @param $image
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.8.0
	 */
	public function backward_compatibility_video_vimeo_link( $item_data, $image, $settings ) {

		if ( isset( $image['video_url'] ) && '' !== $image['video_url'] && strpos( $image['video_url'], 'vimeo' ) ) {
			$video_url = esc_url( $image['video_url'] );
			// check if it is not in simple format.
			if ( ! strpos( $video_url, 'player' ) ) {
				return $item_data;
			} else {
				$pattern = '/player.vimeo.com\/video\/(\d+)\?/';

				// Check if the embed URL matches the pattern
				if ( preg_match( $pattern, $video_url, $matches ) ) {
					// Construct the video link using the extracted video ID
					$video_id   = $matches[1];
					$video_link = "https://vimeo.com/{$video_id}";

					$item_data['img_attributes']['data-full'] = $video_link;
				}
			}
		}

		return $item_data;
	}

	/**
	 * Vimeo albums video compatibility for fancybox5
	 *
	 * @param $item_data
	 * @param $image
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.8.0
	 */
	public function backward_compatibility_video_vimeo_link_albums( $image_config, $image, $gallery_settings ) {

		if ( isset( $image['video_url'] ) && '' !== $image['video_url'] && strpos( $image['video_url'], 'vimeo' ) ) {
			$video_url = $image['video_url'];
			// check if it is not in simple format.
			if ( ! strpos( $video_url, 'player' ) ) {

				$image_config['src'] = esc_url( $video_url );
				return $image_config;
			} else {
				$pattern = '/player.vimeo.com\/video\/(\d+)\?/';

				// Check if the embed URL matches the pattern
				if ( preg_match( $pattern, $video_url, $matches ) ) {
					// Construct the video link using the extracted video ID
					$video_id   = $matches[1];
					$video_link = "https://vimeo.com/{$video_id}";

					$image_config['src'] = esc_url( $video_link );
				}
			}
		}

		return $image_config;
	}

	/**
	 * Vimeo albums video compatibility for fancybox5
	 *
	 * @param $item_data
	 * @param $image
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.8.0
	 */
	public function backward_compatibility_albums_jsconfig( $template_data ) {

		// Get lightbox config data.
		$data = json_decode( $template_data['album_container']['data-config'], true );
		$js_config = isset( $template_data['js_config'] ) ? $template_data['js_config'] : array();
		// Set Modula's fancybox 5 default options.
		$data['lightbox_settings'] = array_merge( Modula_Helper::lightbox_default_options(), $data['lightbox_settings'] );
		// Convert old fancybox settings to new.
		$js_config['lightbox_settings'] = $this->modula_fancybox_5_settings_matcher( $data['lightbox_settings'], $template_data['settings'] );
		// Insert new settings in tempalte data.
		$template_data['album_container']['data-config'] = json_encode( $js_config );

		return $template_data;
	}



	/**
	 * SpeedUp compatibility
	 *
	 * @param $item_data
	 * @param $image
	 * @param $settings
	 *
	 * @return mixed
	 * @since 2.8.0
	 */
	public function generate_optimized_image_links( $item_data, $item, $settings ) {

		// Ensure that the settings are set.
		$settings = wp_parse_args( $settings, Modula_CPT_Fields_Helper::get_defaults() );

		if ( isset( $settings['enable_optimization'] ) && 'disabled' == $settings['enable_optimization'] ) {
			return $item_data;
		}

		$old = 'cdn.wp-modula.com';
		$new = apply_filters( 'modula_speedup_compatibility_domain', 'wp-modula.b-cdn.net' );

		if ( isset( $item_data['img_attributes']['data-full'] ) ) {
			$item_data['img_attributes']['data-full'] = str_replace( $old, $new, $item_data['img_attributes']['data-full'] );
		}
		if ( isset( $item_data['img_attributes']['src'] ) ) {
			$item_data['img_attributes']['src'] = str_replace( $old, $new, $item_data['img_attributes']['data-src'] );
		}
		if ( isset( $item_data['img_attributes']['data-src'] ) ) {
			$item_data['img_attributes']['data-src'] = str_replace( $old, $new, $item_data['img_attributes']['data-src'] );
		}
		if ( isset( $item_data['link_attributes']['data-thumb'] ) ) {
			$item_data['link_attributes']['data-thumb'] = str_replace( $old, $new, $item_data['link_attributes']['data-thumb'] );
		}
		if ( isset( $item_data['src'] ) ) {
			$item_data['src'] = str_replace( $old, $new, $item_data['src'] );
		}
		if ( isset( $item_data['opts']['thumb'] ) ) {
			$item_data['opts']['thumb'] = str_replace( $old, $new, $item_data['opts']['thumb'] );
		}

		return $item_data;
	}

	public function generate_modula_link_image_url( $image_config, $image, $image_id, $gallery_settings ) {

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
