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

		wp_register_style( 'modula-fancybox', MODULA_URL . 'assets/css/jquery.fancybox.css', null, MODULA_LITE_VERSION );
		wp_register_style( 'modula', MODULA_URL . 'assets/css/modula.min.css', null, MODULA_LITE_VERSION );

		// Scripts necessary for some galleries
		wp_register_script( 'modula-fancybox', MODULA_URL . 'assets/js/jquery.fancybox.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_register_script( 'packery', MODULA_URL . 'assets/js/packery.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
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
			wp_enqueue_script( 'packery' );
		}

		if ( '1' == $settings['lazy_load'] ) {
			wp_enqueue_script( 'modula-lazysizes' );
		}

        /* Enqueue lightbox related scripts & styles */
        wp_enqueue_style('modula-fancybox');
        wp_enqueue_script('modula-fancybox');

        $arrows = (isset($settings['show_navigation']) && '1' == $settings['show_navigation']) ? true : false;
        $loop   = (isset($settings['loop_lightbox']) && '1' == $settings['loop_lightbox']) ? true : false;
        $fancybox_options = array(
            'loop'            => $loop,
            'arrows'          => $arrows,
            'toolbar'         => true,
            'keyboard'        => false,
            'wheel'           => false,
            'buttons'         => array(
                'zoom', 'fullScreen', 'close'
            ),
            'hash'            => false,
            'lang'            => 'en',
            'i18n'            => array(
                'en' => array(
                    'CLOSE'       => esc_html__('Close', 'modula-best-grid-gallery'),
                    'NEXT'        => esc_html__('Next', 'modula-best-grid-gallery'),
                    'PREV'        => esc_html__('Previous', 'modula-best-grid-gallery'),
                    'Error'       => esc_html__('The requested content cannot be loaded. Please try again later.', 'modula-best-grid-gallery'),
                    'PLAY_START'  => esc_html__('Start slideshow', 'modula_best-grid_gallery'),
                    'PLAY_STOP'   => esc_html__('Pause slideshow', 'modula-best-grid-gallery'),
                    'FULL_SCREEN' => esc_html__('Full screen', 'modula-best-grid-gallery'),
                    'THUMBS'      => esc_html__('Thumbnails', 'modula_best-grid_gallery'),
                    'DOWNLOAD'    => esc_html__('Download', 'modula_best-grid_gallery'),
                    'SHARE'       => esc_html__('Share', 'modula_best-grid_gallery'),
                    'ZOOM'        => esc_html__('Zoom', 'modula_best-grid_gallery'),
                )
            ),
            'clickSlide'      => false,
            'clickOutside'    => false,
            'dblclickContent' => false,
            'dblclickSlide'   => false,
            'dblclickOutside' => false,
        );
        /**
         * Hook: modula_fancybox_options.
         *
         */
        $fancybox_options = apply_filters('modula_fancybox_options',$fancybox_options,$settings);
        $fancybox_options = json_encode($fancybox_options);

        wp_add_inline_script('modula-fancybox', 'jQuery(document).ready(function(){jQuery("#jtg-' . $atts['id'] . '").find("a.tile-inner[data-fancybox]").fancybox('.$fancybox_options.')});');

        do_action('modula_extra_scripts', $settings);

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
				'class' => array( 'modula', 'modula-gallery' ),
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
				$css .= "#{$gallery_id} .modula-item .jtg-social svg { height: " . absint($settings['socialIconSize']) . "px; width: " . absint( $settings['socialIconSize' ] ) . "px }";
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

			// max-width is a fix for TwentyTwenty theme
	        $activeTheme = wp_get_theme(); // gets the current theme
	        $themeArray  = array ( 'Twenty Twenty' ); // Themes that have this problem
	        if ( in_array( $activeTheme->name , $themeArray ) || in_array( $activeTheme->parent_theme , $themeArray ) ) {
	           $css .= "#{$gallery_id}{max-width:" . esc_attr( $settings['width'] ) . "}";
	        }
				$css .= "#{$gallery_id} { width:" . esc_attr($settings['width']) . ";}";
				$css .= "#{$gallery_id} .modula-items{height:" . absint( $settings['height'] ) . "px;}";
			}

			$css .= "#{$gallery_id} .modula-items .figc p.description { color:" . Modula_Helper::sanitize_rgba_colour($settings['captionColor']) . ";font-size:" . absint($settings['captionFontSize']) . "px; }";
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