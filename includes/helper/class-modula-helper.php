<?php

/**
 *  Helper Class for Modula Gallery
 */
class Modula_Helper {

	/*
	*
	* Generate html attributes based on array
	*
	* @param array atributes
	*
	* @return string
	*
	*/
	public static function generate_attributes( $attributes ) {
		$return = '';
		foreach ( $attributes as $name => $value ) {

			if ( is_array( $value ) && 'class' == $name ) {
				$value = implode( ' ', $value );
			}elseif ( is_array( $value ) ) {
				$value = json_encode( $value );
			}

			if ( in_array( $name, array( 'alt', 'rel', 'title' ) ) ) {
				$value = str_replace( '<script', '&lt;script', $value );
				$value = strip_tags( htmlspecialchars( $value ) );
				$value = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $value );
			}

			$return .= ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
		}

		return $return;

	}

	public static function get_icon( $icon ) {

		switch ( $icon ) {
			case 'facebook':
				return '<svg aria-hidden="true" data-prefix="fab" data-icon="facebook-f" class="svg-inline--fa fa-facebook-f fa-w-9" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 264 512"><path fill="currentColor" d="M76.7 512V283H0v-91h76.7v-71.7C76.7 42.4 124.3 0 193.8 0c33.3 0 61.9 2.5 70.2 3.6V85h-48.2c-37.8 0-45.1 18-45.1 44.3V192H256l-11.7 91h-73.6v229"></path></svg>';
				break;
			case 'twitter':
				return '<svg aria-hidden="true" data-prefix="fab" data-icon="twitter" class="svg-inline--fa fa-twitter fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>';
				break;
			case 'whatsapp':
				return '<svg aria-hidden="true" focusable="false" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1536 1600"><path d="M985 878q13 0 97.5 44t89.5 53q2 5 2 15q0 33-17 76q-16 39-71 65.5T984 1158q-57 0-190-62q-98-45-170-118T476 793q-72-107-71-194v-8q3-91 74-158q24-22 52-22q6 0 18 1.5t19 1.5q19 0 26.5 6.5T610 448q8 20 33 88t25 75q0 21-34.5 57.5T599 715q0 7 5 15q34 73 102 137q56 53 151 101q12 7 22 7q15 0 54-48.5t52-48.5zm-203 530q127 0 243.5-50t200.5-134t134-200.5t50-243.5t-50-243.5T1226 336t-200.5-134T782 152t-243.5 50T338 336T204 536.5T154 780q0 203 120 368l-79 233l242-77q158 104 345 104zm0-1382q153 0 292.5 60T1315 247t161 240.5t60 292.5t-60 292.5t-161 240.5t-240.5 161t-292.5 60q-195 0-365-94L0 1574l136-405Q28 991 28 780q0-153 60-292.5T249 247T489.5 86T782 26z" fill="currentColor"/></svg>';
				break;
			case 'pinterest':
				return '<svg aria-hidden="true" data-prefix="fab" data-icon="pinterest-p" class="svg-inline--fa fa-pinterest-p fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg>';
				break;
			case 'linkedin':
				return '<svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in" class="svg-inline--fa fa-linkedin-in fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>';
				break;
			case 'email':
				return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 3v18h24v-18h-24zm6.623 7.929l-4.623 5.712v-9.458l4.623 3.746zm-4.141-5.929h19.035l-9.517 7.713-9.518-7.713zm5.694 7.188l3.824 3.099 3.83-3.104 5.612 6.817h-18.779l5.513-6.812zm9.208-1.264l4.616-3.741v9.348l-4.616-5.607z" fill="currentColor"/></svg>';
			break;
			default:
				$return = apply_filters( 'modula_get_icon', '', $icon );
				return $return;
				break;
		}

	}

	public static function hover_effects_elements( $effect ) {

		$effects_with_title         = apply_filters( 'modula_effects_with_title', array( 'under', 'fluid-up', 'hide', 'quiet', 'reflex', 'curtain', 'lens', 'appear', 'crafty', 'seemo', 'comodo', 'pufrobo', 'lily', 'sadie', 'honey', 'layla', 'zoe', 'oscar', 'marley', 'ruby', 'roxy', 'bubba', 'dexter', 'sarah', 'chico', 'milo', 'julia', 'hera', 'winston', 'selena', 'terry', 'phoebe', 'apollo', 'steve', 'jazz', 'ming', 'lexi', 'duke', 'tilt_1', 'tilt_3', 'tilt_7','greyscale', 'centered-bottom' ) );
		$effects_with_description   = apply_filters( 'modula_effects_with_description', array( 'under', 'fluid-up', 'hide', 'reflex', 'lens', 'crafty', 'pufrobo', 'lily', 'sadie', 'layla', 'zoe', 'oscar', 'marley', 'ruby', 'roxy', 'bubba', 'dexter', 'sarah', 'chico', 'milo', 'julia', 'selena', 'apollo', 'steve', 'jazz', 'ming', 'lexi', 'duke', 'tilt_1', 'tilt_3', 'tilt_7','greyscale', 'centered-bottom' ) );
		$effects_with_social        = apply_filters( 'modula_effects_with_social', array( 'under', 'comodo', 'seemo', 'appear', 'lens', 'curtain', 'reflex', 'catinelle', 'quiet', 'hide', 'pufrobo', 'lily', 'sadie', 'zoe', 'ruby', 'roxy', 'bubba', 'dexter', 'sarah', 'chico', 'julia', 'hera', 'winston', 'selena', 'terry', 'phoebe', 'ming','greyscale', 'centered-bottom' ) );
		$effects_with_extra_scripts = apply_filters( 'modula_effects_with_scripts', array( 'tilt_1', 'tilt_3', 'tilt_7' ) );

		return array(
			'title'       => in_array( $effect, $effects_with_title ),
			'description' => in_array( $effect, $effects_with_description ),
			'social'      => in_array( $effect, $effects_with_social ),
			'scripts'     => in_array( $effect, $effects_with_extra_scripts )
		);

	}

	/**
	 * Callback to sort tabs/fields on priority.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public static function sort_data_by_priority( $a, $b ) {
		if ( !isset( $a['priority'], $b['priority'] ) ) {
			return -1;
		}
		if ( $a['priority'] == $b['priority'] ) {
			return 0;
		}
		return $a['priority'] < $b['priority'] ? -1 : 1;
	}

	public static function get_image_info( $att_id, $what ) {

		$caption = '';

		switch ( $what ) {
			case 'title':
				$caption = get_the_title( $att_id );
				break;
			case 'caption':
				$caption = wp_get_attachment_caption( $att_id );
				break;
			case 'description':
				$caption = get_the_content( $att_id );
				break;
		}

		return $caption;

	}

	public static function get_title( $item, $default_source ) {

		$title = isset( $item['title'] ) ? $item['title'] : '';

		if ( '' == $title && 'none' != $default_source ) {
			$title = self::get_image_info( $item['id'], $default_source );
		}

		return $title;

	}

	public static function get_description( $item, $default_source ) {

		$description = isset( $item['description'] ) ? $item['description'] : '';

		if ( '' == $description && 'none' != $default_source ) {
			$description = self::get_image_info( $item['id'], $default_source );
		}

		return $description;

	}

	public static function get_galleries() {

		$galleries     = get_posts( array( 'post_type' => 'modula-gallery', 'posts_per_page' => -1 ) );
		$gallery_array = array( 'none' => esc_html__( 'None', 'modula-best-grid-gallery' ) );
		foreach ( $galleries as $gallery ) {
			$gallery_array[$gallery->ID] = esc_html( $gallery->post_title );
		}

		return $gallery_array;
	}

	public static function sanitize_rgba_colour( $color ) {

		if ( empty( $color ) ) {
			return '';
		}

		if ( is_array( $color ) ){
			return 'rgba(0,0,0,0)';
		}

		if ( false === strpos( $color, 'rgba' ) ) {

			return sanitize_hex_color( $color );

		}

		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

		return 'rgba(' . absint( $red ) . ',' . absint( $green ) . ',' . absint( $blue ) . ',' . floatval( $alpha ) . ')';

	}


	public static function lightbox_default_options() {

		$fancybox_options = array(
			'loop'            => false,
			'arrows'          => false,
			'toolbar'         => true,
			'keyboard'        => false,
			'wheel'           => false,
			'buttons'         => array(
				'close',
			),
			'hash'            => false,
			'lang'            => 'en',
			'touch'           => false,
			'protect'         => false,
			'i18n'            => array(
				'en' => array(
					'CLOSE'       => esc_html__( 'Close', 'modula-best-grid-gallery' ),
					'NEXT'        => esc_html__( 'Next', 'modula-best-grid-gallery' ),
					'PREV'        => esc_html__( 'Previous', 'modula-best-grid-gallery' ),
					'Error'       => esc_html__( 'The requested content cannot be loaded. Please try again later.', 'modula-best-grid-gallery' ),
					'PLAY_START'  => esc_html__( 'Start slideshow', 'modula-best-grid-gallery' ),
					'PLAY_STOP'   => esc_html__( 'Pause slideshow', 'modula-best-grid-gallery' ),
					'FULL_SCREEN' => esc_html__( 'Full screen', 'modula-best-grid-gallery' ),
					'THUMBS'      => esc_html__( 'Thumbnails', 'modula-best-grid-gallery' ),
					'DOWNLOAD'    => esc_html__( 'Download', 'modula-best-grid-gallery' ),
					'SHARE'       => esc_html__( 'Share', 'modula-best-grid-gallery' ),
					'ZOOM'        => esc_html__( 'Zoom', 'modula-best-grid-gallery' ),
				)
			),
			'clickSlide'      => false,
			'clickOutside'    => false,
			'dblclickContent' => false,
			'dblclickSlide'   => false,
			'dblclickOutside' => false,
			'clickContent'    => false,
		);

		return $fancybox_options;

	}

	/**
	 * Get image sizes
	 *
	 * @param        $size_type
	 * @param string $size
	 *
	 * @return array|bool|mixed
	 *
	 * @since 2.3.0
	 */
	public static function get_image_sizes( $size_type = false, $size = '' ) {

		global $_wp_additional_image_sizes;

		$sizes                        = array();
		$get_intermediate_image_sizes = get_intermediate_image_sizes();


		// Create the full array with sizes
		foreach ( $get_intermediate_image_sizes as $_size ) {
			// only default
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

				$image_size_txt            = ucfirst( strtolower( str_replace( '_', ' ', $_size ) ) );
				$image_sizes_array[$_size] = $image_size_txt;

				$sizes[$_size]['width']  = get_option( $_size . '_size_w' );
				$sizes[$_size]['height'] = get_option( $_size . '_size_h' );
				$sizes[$_size]['crop'] = (bool) get_option( $_size . '_crop' );

			} elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {

				if ( 'post-thumbnail' != $_size ) {
					$image_size_txt            = ucfirst( strtolower( str_replace( '_', ' ', $_size ) ) );
					$image_sizes_array[$_size] = $image_size_txt;
				}

				$sizes[$_size] = array(
					'width'  => $_wp_additional_image_sizes[$_size]['width'],
					'height' => $_wp_additional_image_sizes[$_size]['height'],
					'crop' => (bool) get_option( $_size . '_crop' )
				);
			}
		}

		// Get only 1 size if found
		if ( $size ) {
			if ( isset( $sizes[$size] ) ) {
				return $sizes[$size];
			} else {
				return false;
			}
		}

		$image_sizes_array['full']   = esc_html__( 'Full', 'modula-best-grid-gallery' );
		$image_sizes_array['custom'] = esc_html__( 'Custom', 'modula-best-grid-gallery' );

		if ( $size_type ) {
			return $image_sizes_array;
		}
		return $sizes;
	}

	/**
	 * Modula Placeholders
	 *
	 * @return mixed|void
	 * @since 2.3.3
	 */
	public static function modula_gallery_placeholders() {

		return apply_filters( 'modula_gallery_placeholders', array());

	}

	/**
	 * Placeholders real/front value
	 *
	 * @param $value
	 * @param $object
	 *
	 * @return string|string[]
	 * @since 2.3.3
	 */
	public static function modula_placeholders_value($value,$object) {

		$values = apply_filters('modula_placeholder_values',array('setting'=>array(),'front'=>array()),$object);

		return str_replace( $values['setting'], $values['front'], $value);
	}

}
