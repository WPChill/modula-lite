<?php

/**
 *
 */
class Modula_Shortcode {

	private $loader;

	function __construct() {

		$this->loader  = new Modula_Template_Loader();

		add_shortcode( 'modula', array( $this, 'gallery_shortcode_handler' ) );
		add_shortcode( 'Modula', array( $this, 'gallery_shortcode_handler' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_gallery_scripts' ) );

		// Add shortcode related hooks
		add_filter( 'modula_shortcode_item_data', 'modula_generate_image_links', 10, 3 );
		add_filter( 'modula_shortcode_item_data', 'modula_check_lightboxes_and_links', 15, 3 );
		add_filter( 'modula_shortcode_item_data', 'modula_check_hover_effect', 20, 3 );
		add_filter( 'modula_shortcode_item_data', 'modula_check_custom_grid', 25, 3 );
	}

	public function add_gallery_scripts() {

		wp_register_style( 'lightbox2_stylesheet', MODULA_URL . 'assets/css/lightbox.min.css', null, MODULA_LITE_VERSION );

		// @todo: move effects to modula style
		wp_register_style( 'modula', MODULA_URL . 'assets/css/modula.css', null, MODULA_LITE_VERSION );
		wp_register_style( 'modula-effects', MODULA_URL . 'assets/css/effects.css', null, MODULA_LITE_VERSION );

		// Scripts necessary for some galleries
		wp_register_script( 'lightbox2_script', MODULA_URL . 'assets/js/lightbox.min.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'packery', MODULA_URL . 'assets/js/packery.min.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

		// @todo: minify all css & js for a better optimization.
		wp_register_script( 'modula', MODULA_URL . 'assets/js/jquery-modula.min.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

	}

	public function gallery_shortcode_handler( $atts ) {
		$default_atts = array(
			'id' => false,
			'align' => '',
		);

		$atts = wp_parse_args( $atts, $default_atts );

		if ( ! $atts['id'] ) {
			return esc_html__( 'Gallery not found.', 'modula-best-grid-gallery' );
		}

		/* Generate uniq id for this gallery */
		$rid = rand( 1, 1000 );
		$gallery_id = 'jtg-' . $atts['id'] . '-' . $rid;

		// Check if is an old Modula post or new.
		$gallery = get_post( $atts['id'] );
		if ( 'modula-gallery' != get_post_type( $gallery ) ) {
			$gallery_posts = get_posts( array(
				'post_type' => 'modula-gallery',
				'post_status' => 'publish',
				'meta_query' => array(
					array(
						'key'     => 'modula-id',
						'value'   => $atts['id'],
						'compare' => '=',
					),
				),
			) );

			if ( empty( $gallery_posts ) ) {
				return esc_html__( 'Gallery not found.', 'modula-best-grid-gallery' );
			}

			$atts['id'] = $gallery_posts[0]->ID;

		}

		/* Get gallery settings */
		$settings = get_post_meta( $atts['id'], 'modula-settings', true );
		$default = Modula_CPT_Fields_Helper::get_defaults();
		$settings = wp_parse_args( $settings, $default );

		$type = 'creative-gallery';
		if ( isset( $settings['type'] ) ) {
			$type = $settings['type'];
		}else{
			$settings['type'] = 'creative-gallery';
		}

		/* Get gallery images */
		$images = apply_filters( 'modula_gallery_before_shuffle_images', get_post_meta( $atts['id'], 'modula-images', true ), $settings );
		if ( isset( $settings['shuffle'] ) && '1' == $settings['shuffle'] && 'creative-gallery' == $type ) {
			shuffle( $images );
		}
		$images = apply_filters( 'modula_gallery_images', $images, $settings );

		if ( empty( $settings ) || empty( $images ) ) {
			return esc_html__( 'Gallery not found.', 'modula-best-grid-gallery' );
		}

		if ( 'custom-grid' == $type ) {
			wp_enqueue_script( 'packery' );
		}

		/* Enqueue lightbox related scripts & styles */
		switch ( $settings['lightbox'] ) {
			case "lightbox2":
				wp_enqueue_style( 'lightbox2_stylesheet' );
				wp_enqueue_script( 'lightbox2_script' );
				wp_add_inline_script( 'lightbox2_script', 'jQuery(document).ready(function(){lightbox.option({albumLabel: "' . esc_html__( 'Image %1 of %2', 'modula-best-grid-gallery' ) . '",wrapAround: true, showNavigation: ' . $settings['show_navigation'] . ', showNavigationOnMobile: ' . $settings['show_navigation_on_mobile'] . '});});' );
				break;
			default:
				do_action( 'modula_lighbox_shortcode', $settings['lightbox'] );
				break;
		}

		// Main CSS & JS
		$necessary_scripts = apply_filters( 'modula_necessary_scripts', array( 'modula' ) );
		$necessary_styles  = apply_filters( 'modula_necessary_styles', array( 'modula', 'modula-effects' ) );

		if ( ! empty( $necessary_scripts ) ) {
			foreach ( $necessary_scripts as $script ) {
				wp_enqueue_script( $script );
			}
		}

		if ( ! empty( $necessary_styles ) ) {
			foreach ( $necessary_styles as $style ) {
				wp_enqueue_style( $style );
			}
		}

		$settings['gallery_id'] = $gallery_id;
		$settings['align']      = $atts['align'];

		$template_data = array(
			'gallery_id' => $gallery_id,
			'settings'   => $settings,
			'images'     => $images,
			'loader'     => $this->loader,
		);

		ob_start();

		/* Config for gallery script */
		$js_config = array(
			"margin"          => absint( $settings['margin'] ),
			"enableTwitter"   => boolval( $settings['enableTwitter'] ),
			"enableFacebook"  => boolval( $settings['enableFacebook'] ),
			"enablePinterest" => boolval( $settings['enablePinterest'] ),
			"enableGplus"     => boolval( $settings['enableGplus'] ),
			"randomFactor"    => ( $settings['randomFactor'] / 100 ),
			'type'            => $type,
			'columns'         => 12,
			'gutter'          => isset( $settings['gutter'] ) ? absint($settings['gutter']) : 10,
			'enableResponsive' => isset( $settings['enable_responsive'] ) ? $settings['enable_responsive'] : 0,
			'tabletColumns'    => isset( $settings['tablet_columns'] ) ? $settings['tablet_columns'] : 2,
			'mobileColumns'    => isset( $settings['mobile_columns'] ) ? $settings['mobile_columns'] : 1,
		);

		$template_data['js_config'] = apply_filters( 'modula_gallery_settings', $js_config, $settings );

		echo $this->generate_gallery_css( $gallery_id, $settings );
		$this->loader->set_template_data( $template_data );
    	$this->loader->get_template_part( 'modula', 'gallery' );

    	$html = ob_get_clean();
    	return $html;

	}

	private function generate_gallery_css( $gallery_id, $settings ) {

			$css = "<style>";

			if ( $settings['borderSize'] ) {
				$css .= "#{$gallery_id} .item { border: " . absint($settings['borderSize']) . "px solid " . sanitize_hex_color($settings['borderColor']) . "; }";
			}

			if ( $settings['borderRadius'] ) {
				$css .= "#{$gallery_id} .item { border-radius: " . absint($settings['borderRadius']) . "px; }";
			}

			if ( $settings['shadowSize'] ) {
				$css .= "#{$gallery_id} .item { box-shadow: " . sanitize_hex_color($settings['shadowColor']) . " 0px 0px " . absint($settings['shadowSize']) . "px; }";
			}

			if ( $settings['socialIconColor'] ) {
				$css .= "#{$gallery_id} .item .jtg-social a { color: " . sanitize_hex_color($settings['socialIconColor']) . " }";
			}

			$css .= "#{$gallery_id} .item .caption { background-color: " . sanitize_hex_color($settings['captionColor']) . ";  }";
			if ( '' != $settings['captionColor'] || '' != $settings['captionFontSize'] ) {
				$css .= "#{$gallery_id} .item .figc {";
				if ( '' != $settings['captionColor'] ) {
					$css .= 'color:' . sanitize_hex_color($settings['captionColor']) . ';';
				}
				$css .= '}';
			}

			if ( '' != $settings['titleFontSize'] && 0 != $settings['titleFontSize'] ) {
				$css .= "#{$gallery_id} .item .figc h2.jtg-title {  font-size: " . absint($settings['titleFontSize']) . "px; }";
			}

			$css .= "#{$gallery_id} .item { transform: scale(" . absint( $settings['loadedScale'] ) / 100 . "); }";

			if ( 'custom-grid' != $settings['type'] ) {
				$css .= "#{$gallery_id} .items { width:" . esc_attr($settings['width']) . "; height:" . absint( $settings['height'] ) . "px; }";
			}

			$css .= "#{$gallery_id} .items .figc p.description { color:" . sanitize_hex_color($settings['captionColor']) . ";font-size:" . absint($settings['captionFontSize']) . "px; }";
			$css .= "#{$gallery_id} .items .figc h2.jtg-title { color:" . sanitize_hex_color($settings['captionColor']) . "; }";

			$css = apply_filters( 'modula_shortcode_css', $css, $gallery_id, $settings );


			if ( strlen( $settings['style'] ) ) {
				$css .= esc_html($settings['style']);
			}

			$css .= "</style>\n";

			return $css;

	}

}

new Modula_Shortcode();