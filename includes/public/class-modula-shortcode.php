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
		add_filter( 'modula_shortcode_item_data', 'modula_enable_lazy_load', 30, 3 );
		add_filter( 'modula_gallery_template_data', 'modula_add_align_classes', 99 );
		add_action( 'modula_shortcode_after_items', 'modula_show_schemaorg', 90 );

	}

	public function add_gallery_scripts() {

		wp_register_style( 'modula-lightbox2', MODULA_URL . 'assets/css/lightbox.min.css', null, MODULA_LITE_VERSION );
		wp_register_style( 'modula', MODULA_URL . 'assets/css/modula.min.css', null, MODULA_LITE_VERSION );

		// Scripts necessary for some galleries
		wp_register_script( 'modula-lightbox2', MODULA_URL . 'assets/js/lightbox.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-packery', MODULA_URL . 'assets/js/packery.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'modula-lazysizes', MODULA_URL . 'assets/js/lazysizes.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

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
		$gallery_id = 'jtg-' . $atts['id'];

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
		$default  = Modula_CPT_Fields_Helper::get_defaults();
		$settings = wp_parse_args( $settings, $default );

		$type = 'creative-gallery';
		if ( isset( $settings['type'] ) ) {
			$type = $settings['type'];
		}else{
			$settings['type'] = 'creative-gallery';
		}
		
		$pre_gallery_html = apply_filters( 'modula_pre_output_filter_check', false, $settings, $gallery );

		if ( false !== $pre_gallery_html ) {

			// If there is HTML, then we stop trying to display the gallery and return THAT HTML.
			$pre_output =  apply_filters( 'modula_pre_output_filter','', $settings, $gallery );
			return $pre_output;

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
			wp_enqueue_script( 'modula-packery' );
		}

		if ( '1' == $settings['lazy_load'] ) {
			wp_enqueue_script( 'modula-lazysizes' );
		}

		/* Enqueue lightbox related scripts & styles */
		switch ( $settings['lightbox'] ) {
			case "lightbox2":
				wp_enqueue_style( 'modula-lightbox2' );
				wp_enqueue_script( 'modula-lightbox2' );
				wp_add_inline_script( 'modula-lightbox2', 'jQuery(document).ready(function(){lightbox.option({albumLabel: "' . esc_html__( 'Image %1 of %2', 'modula-best-grid-gallery' ) . '",wrapAround: true, showNavigation: ' . $settings['show_navigation'] . ', showNavigationOnMobile: ' . $settings['show_navigation_on_mobile'] . '});});' );
				break;
			default:
				do_action( 'modula_lighbox_shortcode', $settings['lightbox'] );
				break;
		}

		do_action('modula_extra_scripts',$settings);

		// Main CSS & JS
		$necessary_scripts = apply_filters( 'modula_necessary_scripts', array( 'modula' ),$settings );
		$necessary_styles  = apply_filters( 'modula_necessary_styles', array( 'modula' ), $settings );

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

			// Gallery container attributes
			'gallery_container' => array(
				'id' => $gallery_id,
				'class' => apply_filters( 'modula_gallery_extra_classes', 'modula modula-gallery', $settings ),
			),

			// Items container attributes
			'items_container' => array(
				'class' => array( 'modula-items' ),
			),
		);

		ob_start();

		/* Config for gallery script */
		$js_config = apply_filters( 'modula_gallery_settings', array(
			"margin"          => absint( $settings['margin'] ),
			"enableTwitter"   => boolval( $settings['enableTwitter'] ),
			"enableWhatsapp"  => boolval( $settings['enableWhatsapp']),
			"enableFacebook"  => boolval( $settings['enableFacebook'] ),
			"enablePinterest" => boolval( $settings['enablePinterest'] ),
			"enableLinkedin"  => boolval( $settings['enableLinkedin'] ),
			"randomFactor"    => ( $settings['randomFactor'] / 100 ),
			'type'            => $type,
			'columns'         => 12,
			'gutter'          => isset( $settings['gutter'] ) ? absint($settings['gutter']) : 10,
			'enableResponsive' => isset( $settings['enable_responsive'] ) ? $settings['enable_responsive'] : 0,
			'tabletColumns'    => isset( $settings['tablet_columns'] ) ? $settings['tablet_columns'] : 2,
			'mobileColumns'    => isset( $settings['mobile_columns'] ) ? $settings['mobile_columns'] : 1,
			'lazyLoad'        => isset( $settings['lazy_load'] ) ? $settings['lazy_load'] : 1,
		), $settings );

		$template_data['gallery_container']['data-config'] = json_encode( $js_config );
		/**
		 * Hook: modula_gallery_template_data.
		 *
		 * @hooked modula_add_align_classes - 99
		 */
		$template_data = apply_filters( 'modula_gallery_template_data', $template_data );

		echo $this->generate_gallery_css( $gallery_id, $settings );
		$this->loader->set_template_data( $template_data );
    	$this->loader->get_template_part( 'modula', 'gallery' );
    	echo '<!-- This gallery was built with Modula Gallery -->';
    	$html = ob_get_clean();
    	return $html;

	}

	private function generate_gallery_css( $gallery_id, $settings ) {

			$css = "<style>";

			if ( $settings['borderSize'] ) {
				$css .= "#{$gallery_id} .modula-item { border: " . absint($settings['borderSize']) . "px solid " . Modula_Helper::sanitize_rgba_colour($settings['borderColor']) . "; }";
			}

			if ( $settings['borderRadius'] ) {
				$css .= "#{$gallery_id} .modula-item { border-radius: " . absint($settings['borderRadius']) . "px; }";
			}

			if ( $settings['shadowSize'] ) {
				$css .= "#{$gallery_id} .modula-item { box-shadow: " . Modula_Helper::sanitize_rgba_colour($settings['shadowColor']) . " 0px 0px " . absint($settings['shadowSize']) . "px; }";
			}

			if ( $settings['socialIconColor'] ) {
				$css .= "#{$gallery_id} .modula-item .jtg-social a { color: " . Modula_Helper::sanitize_rgba_colour($settings['socialIconColor']) . " }";
			}

			if ( $settings['socialIconSize'] ) {
				$css .= "#{$gallery_id} .modula-item .jtg-social svg { height: " . absint($settings['socialIconSize']) . "px; width: " . absint( $settings['socialIconSize' ] ) . "px; }";
			}

			if ( $settings['socialIconPadding'] ) {
				$css .= "#{$gallery_id} .modula-item .jtg-social a { margin-right: " . absint($settings['socialIconPadding']) . 'px' . " }";
			}

			$css .= "#{$gallery_id} .modula-item .caption { background-color: " . sanitize_hex_color($settings['captionColor']) . ";  }";

			if ( '' != $settings['captionColor'] || '' != $settings['captionFontSize'] ) {
				$css .= "#{$gallery_id} .modula-item .figc {";
				if ( '' != $settings['captionColor'] ) {
					$css .= 'color:' . Modula_Helper::sanitize_rgba_colour($settings['captionColor']) . ';';
				}
				$css .= '}';
			}

			if ( '' != $settings['titleFontSize'] && 0 != $settings['titleFontSize'] ) {
				$css .= "#{$gallery_id} .modula-item .figc .jtg-title {  font-size: " . absint($settings['titleFontSize']) . "px; }";
			}

			$css .= "#{$gallery_id} .modula-item { transform: scale(" . absint( $settings['loadedScale'] ) / 100 . "); }";

			if ( 'custom-grid' != $settings['type'] ) {

			// max-width is a fix for Twentytwenty theme
	        $activeTheme = wp_get_theme(); // gets the current theme
	        $themeArray  = array ( 'Twenty Twenty' ); // Themes that have this problem
	        if ( in_array( $activeTheme->name , $themeArray ) || in_array( $activeTheme->parent_theme , $themeArray ) ) {
	           $css .= "#{$gallery_id}{max-width:" . esc_attr( $settings['width'] ) . "}";
	        }
				$css .= "#{$gallery_id} { width:" . esc_attr($settings['width']) . ";}";
				$css .= "#{$gallery_id} .modula-items{height:" . absint( $settings['height'] ) . "px;}";
			}

        if ( '' != $settings['captionFontSize'] && 0 != $settings['captionFontSize'] ) {
            $css .= "#{$gallery_id} .modula-items .figc p.description { font-size:" . absint($settings['captionFontSize']) . "px; }";
        }

			$css .= "#{$gallery_id} .modula-items .figc p.description { color:" . Modula_Helper::sanitize_rgba_colour($settings['captionColor']) . ";}";
			if ( '' != $settings['titleColor'] ) {
				$css .= "#{$gallery_id} .modula-items .figc .jtg-title { color:" . Modula_Helper::sanitize_rgba_colour($settings['titleColor']) . "; }";
			}else{
				$css .= "#{$gallery_id} .modula-items .figc .jtg-title { color:" . Modula_Helper::sanitize_rgba_colour($settings['captionColor']) . "; }";
			}

			$css .= "#{$gallery_id} .modula-item>a { cursor:" . esc_attr($settings['cursor'])."; } ";

			$css = apply_filters( 'modula_shortcode_css', $css, $gallery_id, $settings );


			if ( strlen( $settings['style'] ) ) {
				$css .= esc_html($settings['style']);
			}

			// Responsive fixes
            $css .= '@media screen and (max-width:480px){';

            if ('' != $settings['mobileTitleFontSize'] && 0 != $settings['mobileTitleFontSize']) {

                $css .= "#{$gallery_id} .modula-item .figc .jtg-title {  font-size: " . absint($settings['mobileTitleFontSize']) . "px; }";
            }

            $css .= "#{$gallery_id} .modula-items .figc p.description { color:" . Modula_Helper::sanitize_rgba_colour($settings['captionColor']) . ";font-size:" . absint($settings['mobileCaptionFontSize']) . "px; }";

            $css .= '}';


			$css .= "</style>\n";

			return $css;

	}

}

new Modula_Shortcode();