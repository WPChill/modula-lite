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
				return '<svg
					width="20px"
					height="20px"
					viewBox="0 0 20 20"
					aria-hidden="true">
						<path d="M20,10.1c0-5.5-4.5-10-10-10S0,4.5,0,10.1c0,5,3.7,9.1,8.4,9.9v-7H5.9v-2.9h2.5V7.9C8.4,5.4,9.9,4,12.2,4c1.1,0,2.2,0.2,2.2,0.2v2.5h-1.3c-1.2,0-1.6,0.8-1.6,1.6v1.9h2.8L13.9,13h-2.3v7C16.3,19.2,20,15.1,20,10.1z"/>
					</svg>';
				break;
			case 'twitter':
				return '<svg
					width="20px"
					height="20px"
					viewBox="0 0 20 20"
					aria-hidden="true">
						<path d="M2.9 0C1.3 0 0 1.3 0 2.9v14.3C0 18.7 1.3 20 2.9 20h14.3c1.6 0 2.9-1.3 2.9-2.9V2.9C20 1.3 18.7 0 17.1 0H2.9zm13.2 3.8L11.5 9l5.5 7.2h-4.3l-3.3-4.4-3.8 4.4H3.4l5-5.7-5.3-6.7h4.4l3 4 3.5-4h2.1zM14.4 15 6.8 5H5.6l7.7 10h1.1z"/>
					</svg>';
				break;
			case 'whatsapp':
				return '<svg
					width="20px"
					height="20px"
					viewBox="0 0 20 20"
					aria-hidden="true">
						<path d="M10,0C4.5,0,0,4.5,0,10c0,1.9,0.5,3.6,1.4,5.1L0.1,20l5-1.3C6.5,19.5,8.2,20,10,20c5.5,0,10-4.5,10-10S15.5,0,10,0zM6.6,5.3c0.2,0,0.3,0,0.5,0c0.2,0,0.4,0,0.6,0.4c0.2,0.5,0.7,1.7,0.8,1.8c0.1,0.1,0.1,0.3,0,0.4C8.3,8.2,8.3,8.3,8.1,8.5C8,8.6,7.9,8.8,7.8,8.9C7.7,9,7.5,9.1,7.7,9.4c0.1,0.2,0.6,1.1,1.4,1.7c0.9,0.8,1.7,1.1,2,1.2c0.2,0.1,0.4,0.1,0.5-0.1c0.1-0.2,0.6-0.7,0.8-1c0.2-0.2,0.3-0.2,0.6-0.1c0.2,0.1,1.4,0.7,1.7,0.8s0.4,0.2,0.5,0.3c0.1,0.1,0.1,0.6-0.1,1.2c-0.2,0.6-1.2,1.1-1.7,1.2c-0.5,0-0.9,0.2-3-0.6c-2.5-1-4.1-3.6-4.2-3.7c-0.1-0.2-1-1.3-1-2.6c0-1.2,0.6-1.8,0.9-2.1C6.1,5.4,6.4,5.3,6.6,5.3z"/>
					</svg>';
				break;
			case 'pinterest':
				return '<svg
					width="20px"
					height="20px"
					viewBox="0 0 20 20"
					aria-hidden="true">
						<path d="M10,0C4.5,0,0,4.5,0,10c0,4.1,2.5,7.6,6,9.2c0-0.7,0-1.5,0.2-2.3c0.2-0.8,1.3-5.4,1.3-5.4s-0.3-0.6-0.3-1.6c0-1.5,0.9-2.6,1.9-2.6c0.9,0,1.3,0.7,1.3,1.5c0,0.9-0.6,2.3-0.9,3.5c-0.3,1.1,0.5,1.9,1.6,1.9c1.9,0,3.2-2.4,3.2-5.3c0-2.2-1.5-3.8-4.2-3.8c-3,0-4.9,2.3-4.9,4.8c0,0.9,0.3,1.5,0.7,2C6,12,6.1,12.1,6,12.4c0,0.2-0.2,0.6-0.2,0.8c-0.1,0.3-0.3,0.3-0.5,0.3c-1.4-0.6-2-2.1-2-3.8c0-2.8,2.4-6.2,7.1-6.2c3.8,0,6.3,2.8,6.3,5.7c0,3.9-2.2,6.9-5.4,6.9c-1.1,0-2.1-0.6-2.4-1.2c0,0-0.6,2.3-0.7,2.7c-0.2,0.8-0.6,1.5-1,2.1C8.1,19.9,9,20,10,20c5.5,0,10-4.5,10-10C20,4.5,15.5,0,10,0z"/>
					</svg>';
				break;
			case 'linkedin':
				return '<svg
					width="20px"
					height="20px"
					viewBox="0 0 20 20"
					aria-hidden="true">
						<path d="M18.6,0H1.4C0.6,0,0,0.6,0,1.4v17.1C0,19.4,0.6,20,1.4,20h17.1c0.8,0,1.4-0.6,1.4-1.4V1.4C20,0.6,19.4,0,18.6,0z M6,17.1h-3V7.6h3L6,17.1L6,17.1zM4.6,6.3c-1,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7c0.9,0,1.7,0.8,1.7,1.7C6.3,5.5,5.5,6.3,4.6,6.3z M17.2,17.1h-3v-4.6c0-1.1,0-2.5-1.5-2.5c-1.5,0-1.8,1.2-1.8,2.5v4.7h-3V7.6h2.8v1.3h0c0.4-0.8,1.4-1.5,2.8-1.5c3,0,3.6,2,3.6,4.5V17.1z"/>
					</svg>';
				break;
			case 'email':
				return '
					<svg
					width="20"
					height="20"
					viewBox="0 0 20 20"
					aria-hidden="true">
						<path d="M10,10.1L0,4.7C0.1,3.2,1.4,2,3,2h14c1.6,0,2.9,1.2,3,2.8L10,10.1z M10,11.8c-0.1,0-0.2,0-0.4-0.1L0,6.4V15c0,1.7,1.3,3,3,3h4.9h4.3H17c1.7,0,3-1.3,3-3V6.4l-9.6,5.2C10.2,11.7,10.1,11.7,10,11.8z"/>
					</svg>';
			break;
			case 'share':
				return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1" width="24" height="24"><path d="M2.55 19c1.4-8.4 9.1-9.8 11.9-9.8V5l7 7-7 6.3v-3.5c-2.8 0-10.5 2.1-11.9 4.2z"></path></svg>';
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
			'animated' => true,
			'Thumbs'  => array(
				'type' => 'modern',
				'showOnStart' => false,
			),
			'Toolbar' => array(
				'display' => array(
					'right' => array('close'),
				),
				'enabled' => true,
			),
			'Carousel' => array(
				'Panzoom' => array(
					'touch' => false,
				),
				'infinite' => false,
			),
			'keyboard' => false,
			"touch" => false,
			'backdropClick' => false, //The action to perform when the user clicks on the backdrop
			'l10n' => array(
				'CLOSE'             => esc_html__( 'Close', 'modula-best-grid-gallery' ),
				'NEXT'              => esc_html__( 'Next', 'modula-best-grid-gallery' ),
				'PREV'              => esc_html__( 'Previous', 'modula-best-grid-gallery' ),
				'Error'             => esc_html__( 'The requested content cannot be loaded. Please try again later.', 'modula-best-grid-gallery' ),
				'PLAY_START'        => esc_html__( 'Start slideshow', 'modula-best-grid-gallery' ),
				'PLAY_STOP'         => esc_html__( 'Pause slideshow', 'modula-best-grid-gallery' ),
				'FULL_SCREEN'       => esc_html__( 'Full screen', 'modula-best-grid-gallery' ),
				'THUMBS'            => esc_html__( 'Thumbnails', 'modula-best-grid-gallery' ),
				'DOWNLOAD'          => esc_html__( 'Download', 'modula-best-grid-gallery' ),
				'SHARE'             => esc_html__( 'Share', 'modula-best-grid-gallery' ),
				'ZOOM'              => esc_html__( 'Zoom', 'modula-best-grid-gallery' ),
				'EMAIL'             => sprintf( esc_html__( 'Here is the link to the image : %s and this is the link to the gallery : %s', 'modula-best-grid-gallery' ), '%%image_link%%' , '%%gallery_link%%' ),
				'MODAL'		        => esc_html__( 'You can close this modal content with the ESC key', 'modula-best-grid-gallery' ),
				'ERROR'		        => esc_html__( 'Something Went Wrong, Please Try Again Later', 'modula-best-grid-gallery' ),
				'IMAGE_ERROR'		=> esc_html__( 'Image Not Found', 'modula-best-grid-gallery' ),
				'ELEMENT_NOT_FOUND' => esc_html__( 'HTML Element Not Found', 'modula-best-grid-gallery' ),
				'AJAX_NOT_FOUND'	=> esc_html__( 'Error Loading AJAX : Not Found', 'modula-best-grid-gallery' ),
				'AJAX_FORBIDDEN'    => esc_html__( 'Error Loading AJAX : Forbidden', 'modula-best-grid-gallery' ),
				'IFRAME_ERROR'      => esc_html__( 'Error Loading Page', 'modula-best-grid-gallery' ),
				'TOGGLE_ZOOM'       => esc_html__( 'Toggle zoom level', 'modula-best-grid-gallery' ),
				'TOGGLE_THUMBS'     => esc_html__( 'Toggle thumbnails', 'modula-best-grid-gallery' ),
				'TOGGLE_SLIDESHOW'  => esc_html__( 'Toggle slideshow', 'modula-best-grid-gallery' ),
				'TOGGLE_FULLSCREEN' => esc_html__( 'Toggle full-screen mode', 'modula-best-grid-gallery' ),
			),
			'Images' => array(
				'Panzoom' => array(
					'maxScale' => 2,
				),
			),

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

	public static function get_default_image_licenses() {
		return array(
			'none'     => array(
				'name'    => __( 'None', 'modula-best-grid-gallery' ),
				'image'   => '',
				'license' => '',
			),
			'by'       => array(
				'name'    => __( 'Attribution 4.0 International License (CC BY 4.0)', 'modula-best-grid-gallery' ),
				'image'   => esc_url( MODULA_URL . 'assets/images/licensing/by.png' ),
				'license' => 'http://creativecommons.org/licenses/by/4.0/',
			),
			'by-sa'    => array(
				'name'    => __( 'Attribution-ShareAlike 4.0 International License (CC BY-SA 4.0)', 'modula-best-grid-gallery' ),
				'image'   => esc_url( MODULA_URL . 'assets/images/licensing/by-sa.png' ),
				'license' => 'http://creativecommons.org/licenses/by-sa/4.0/',
			),
			'by-nc'    => array(
				'name'    => __( 'Attribution-NonCommercial 4.0 International License (CC BY-NC 4.0)', 'modula-best-grid-gallery' ),
				'image'   => esc_url( MODULA_URL . 'assets/images/licensing/by-nc.png' ),
				'license' => 'http://creativecommons.org/licenses/by-nc/4.0/',
			),
			'by-nc-sa' => array(
				'name'    => __( 'Attribution-NonCommercial-ShareAlike 4.0 International License (CC BY-NC-SA 4.0)', 'modula-best-grid-gallery' ),
				'image'   => esc_url( MODULA_URL . 'assets/images/licensing/by-nc-sa.png' ),
				'license' => 'http://creativecommons.org/licenses/by-nc-sa/4.0/',
			),
			'by-nc-nd' => array(
				'name'    => __( 'Attribution-NonCommercial-NoDerivatives 4.0 International License (CC BY-NC-ND 4.0)', 'modula-best-grid-gallery' ),
				'image'   => esc_url( MODULA_URL . 'assets/images/licensing/by-nc-nd.png' ),
				'license' => 'http://creativecommons.org/licenses/by-nc-nd/4.0/',
			),
			'by-nd'    => array(
				'name'    => __( 'Attribution-NoDerivatives 4.0 International License (CC BY-ND 4.0)', 'modula-best-grid-gallery' ),
				'image'   => esc_url( MODULA_URL . 'assets/images/licensing/by-nd.png' ),
				'license' => 'http://creativecommons.org/licenses/by-nd/4.0/',
			),
			'cc0'      => array(
				'name'    => __( 'CC0 Universal Public Domain Dedication license (CC0)', 'modula-best-grid-gallery' ),
				'image'   => esc_url( MODULA_URL . 'assets/images/licensing/zero.png' ),
				'license' => 'https://creativecommons.org/publicdomain/zero/1.0/',
			),
		);
	}

	/**
	 * Returns Image Licensing licenses
	 *
	 *
	 * @return array
	 * @since 2.7.5
	 */
	public static function get_image_licenses( $specific = false ) {
		$defaults = self::get_default_image_licenses();
		$filtered = apply_filters( 'modula-image-licensing-licenses', $defaults );

		if ( $specific ) {
			return isset( $filtered[ $specific ] ) ? $filtered[ $specific ] : array();
		}

		return $filtered;
	}

	/**
	 * Returns Image Licensing licenses
	 *
	 *
	 * @return string
	 * @since 2.7.9
	 */
	public static function render_license_box( $image_licensing = 'none' ) {
		if ( 'none' === $image_licensing ) {
			$image_attrib_options = get_option( 'modula_image_licensing_option', false );
			// If no image licensing options are set, return empty string
			if ( ! $image_attrib_options || ! isset( $image_attrib_options['image_licensing'] ) || 'none' === $image_attrib_options['image_licensing'] ) {
				return '';
			}
			// Set image licensing to the option value because the image licensing is set to "none"
			$image_licensing = $image_attrib_options['image_licensing'];
		}

		$ccs = self::get_image_licenses();
		// If the image licensing options are not set, return empty string
		if ( ! isset( $ccs[ $image_licensing ] ) ) {
			return '';
		}

		$cc = $ccs[ $image_licensing ];

		ob_start();
		?>
		<div class="modula-creative-commons-wrap">
			<a rel="license" href="<?php
			echo esc_url( $cc['license'] ); ?>" target="_blank"><img alt="Creative Commons License" style="border-width:0" src="<?php
				echo esc_url( $cc['image'] ); ?>"/></a>
			<span> <?php
				printf( __( 'This work is licensed under a %s %s %s', 'modula-best-grid-gallery' ), '<a rel="license" href="' . esc_url( $cc['license'] ) . '" target="_blank" >', esc_html( $cc['name'] ), '</a>' ); ?></span>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render Image Licensing licenses
	 *
	 *
	 * @return string
	 * @since 2.7.9
	 */
	public static function render_ia_item_ld_json( $image_licensing, $img_url ) {
		$license     = self::get_image_licenses( $image_licensing['image_licensing'] );
		$license_url = isset( $license['license'] ) ? $license['license'] : '';
		$company     = isset( $image_licensing['image_licensing_company'] ) ? $image_licensing['image_licensing_company'] : '';
		$author      = isset( $image_licensing['image_licensing_author'] ) ? $image_licensing['image_licensing_author'] : '';

		$json_array = array(
			"@context"        => "https://schema.org/",
			"@type"           => "ImageObject",
			"contentUrl"      => esc_url( $img_url ),
			"license"         => esc_url( $license_url ),
			"creditText"      => esc_html( $company ),
			"creator"         => array(
				"@type" => "Person",
				"name"  => esc_html( $author ),
			),
			"copyrightNotice" => esc_html( $company ),
		);

		return $json_array;
	}

	public static function render_lightbox_share_template(){

		$share_buttons = array(
			'facebook' =>
				'<a class="modula-fancybox-share__button modula-fancybox-share__button--fb" href="https://www.facebook.com/sharer/sharer.php?u={modulaShareUrl}">
				<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m287 456v-299c0-21 6-35 35-35h38v-63c-7-1-29-3-55-3-54 0-91 33-91 94v306m143-254h-205v72h196" /></svg>
				<span>Facebook</span></a>',

			'twitter' =>
				'<a class="modula-fancybox-share__button modula-fancybox-share__button--tw" href="https://twitter.com/intent/tweet?url={modulaShareUrl}&text={descr}">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="512px" height="512px" clip-rule="evenodd" baseProfile="basic"><polygon fill="#fff" points="437.333,64 105.245,448 66.867,448 393.955,64"/><polygon fill="#1da1f2" fill-rule="evenodd" points="332.571,448 83.804,74.667 178.804,74.667 427.571,448" clip-rule="evenodd"/><path fill="#fff" d="M168.104,96l219.628,320h-43.733L121.371,96H168.104 M184.723,64H61.538l263.542,384h121.185L184.723,64L184.723,64z"/></svg>
				<span>Twitter</span></a>',

			'pinterest' =>
				'<a class="modula-fancybox-share__button modula-fancybox-share__button--pt" href="https://www.pinterest.com/pin/create/button/?url={modulaShareUrl}&description={descr}&media={media}">
				<svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m265 56c-109 0-164 78-164 144 0 39 15 74 47 87 5 2 10 0 12-5l4-19c2-6 1-8-3-13-9-11-15-25-15-45 0-58 43-110 113-110 62 0 96 38 96 88 0 67-30 122-73 122-24 0-42-19-36-44 6-29 20-60 20-81 0-19-10-35-31-35-25 0-44 26-44 60 0 21 7 36 7 36l-30 125c-8 37-1 83 0 87 0 3 4 4 5 2 2-3 32-39 42-75l16-64c8 16 31 29 56 29 74 0 124-67 124-157 0-69-58-132-146-132z" fill="#fff"/></svg>
				<span>Pinterest</span></a>',

			'whatsapp' =>
				'<a class="modula-fancybox-share__button modula-fancybox-share__button--wa" href="https://api.whatsapp.com/send?text={modulaShareUrl}&review_url=true">
				<svg aria-hidden="true" focusable="false" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1536 1600"><path d="M985 878q13 0 97.5 44t89.5 53q2 5 2 15q0 33-17 76q-16 39-71 65.5T984 1158q-57 0-190-62q-98-45-170-118T476 793q-72-107-71-194v-8q3-91 74-158q24-22 52-22q6 0 18 1.5t19 1.5q19 0 26.5 6.5T610 448q8 20 33 88t25 75q0 21-34.5 57.5T599 715q0 7 5 15q34 73 102 137q56 53 151 101q12 7 22 7q15 0 54-48.5t52-48.5zm-203 530q127 0 243.5-50t200.5-134t134-200.5t50-243.5t-50-243.5T1226 336t-200.5-134T782 152t-243.5 50T338 336T204 536.5T154 780q0 203 120 368l-79 233l242-77q158 104 345 104zm0-1382q153 0 292.5 60T1315 247t161 240.5t60 292.5t-60 292.5t-161 240.5t-240.5 161t-292.5 60q-195 0-365-94L0 1574l136-405Q28 991 28 780q0-153 60-292.5T249 247T489.5 86T782 26z" fill="currentColor"/></svg>
				<span>WhatsApp</span></a>',

			'linkedin' =>
				'<a class="modula-fancybox-share__button modula-fancybox-share__button--li" href="//linkedin.com/shareArticle?mini=true&url={modulaShareUrl}">
				<svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in" class="svg-inline--fa fa-linkedin-in fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
				<span>LinkedIn</span></a>',

			'email' =>
				'<a class="modula-fancybox-share__button modula-fancybox-share__button--email" href="mailto:?subject={subject}&body={emailMessage}">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 3v18h24v-18h-24zm6.623 7.929l-4.623 5.712v-9.458l4.623 3.746zm-4.141-5.929h19.035l-9.517 7.713-9.518-7.713zm5.694 7.188l3.824 3.099 3.83-3.104 5.612 6.817h-18.779l5.513-6.812zm9.208-1.264l4.616-3.741v9.348l-4.616-5.607z" fill="currentColor"></path></svg>
				<span>Email</span></a>',
		);

		return apply_filters( 'modula_share_buttons_template', $share_buttons );
	}
}
