<?php

class Modula_Gutenberg {

	function __construct() {

		// Return early if this function does not exist.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'register_block_type' ) );
		add_action( 'init', array( $this, 'generate_js_vars' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_block_assets'), 1);
		add_action( 'wp_ajax_modula_get_gallery_meta', array( $this, 'get_gallery_meta' ) );
		add_action( 'wp_ajax_modula_get_jsconfig', array( $this, 'get_jsconfig' ) );
		add_action( 'wp_ajax_modula_check_hover_effect', array( $this, 'check_hover_effect' ) );
	}

	/**
	 * Register block type
	 * 
	 * @since 2.5.0
	 */
	public function register_block_type() {

		wp_register_script( 'modula-gutenberg', MODULA_URL . 'assets/js/admin/wp-modula-gutenberg.js', array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-data' ) );
		wp_register_style( 'modula-gutenberg', MODULA_URL . 'assets/css/admin/modula-gutenberg.css', array(), true );

		register_block_type(
			'modula/gallery',
			array(
				'render_callback' => array( $this, 'render_modula_gallery' ),
				'editor_script'   => 'modula-gutenberg',
				'editor_style'    => 'modula-gutenberg',
			)
		);

	}

	/**
	 * Enqueue block assets
	 * 
	 * @since 2.5.0
	 */
	public function enqueue_block_assets() {
		$screen = get_current_screen();
		if ('post' == $screen->post_type  || 'page' == $screen->post_type ) { 
			wp_enqueue_style( 'modula', MODULA_URL . 'assets/css/front.css', null, MODULA_LITE_VERSION );

			do_action( 'modula_block_style' );

			wp_enqueue_script( 'modula-isotope', MODULA_URL . 'assets/js/front/isotope.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-isotope-packery', MODULA_URL . 'assets/js/front/isotope-packery.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
			wp_enqueue_script( 'modula-grid-justified-gallery', MODULA_URL . 'assets/js/front/justifiedGallery.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

			do_action( 'modula_block_scripts' );
			
			wp_enqueue_script( 'modula', MODULA_URL . 'assets/js/front/jquery-modula.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		}
	}

	/**
	 * modulaVars generator
	 * 
	 * @since 2.5.0
	 */
	public function generate_js_vars() {

		wp_localize_script(
			'modula-gutenberg',
			'modulaVars',
			apply_filters( 'modula_gutenberg_vars', array(
				'adminURL'       => admin_url(),
				'ajaxURL'        => admin_url( 'admin-ajax.php' ),
				'nonce'          => wp_create_nonce( 'modula_nonce' ),
				'gutenbergTitle' => esc_html__( 'Modula Gallery', 'modula-best-grid-gallery'),
				'restURL'        => get_rest_url(),
			) )
		);

	}

	/**
	 * Render modula gallery callback function for block
	 * 
	 * @param array $atts
	 * 
	 * @return mixed
	 */
	public function render_modula_gallery( $atts ) {
		if ( ! isset( $atts['id'] ) ) {
			return;
		}

		if ( ! isset( $atts['align'] ) ) {
			$atts['align'] = '';
		}
		
		if( isset($atts['galleryType'] ) && $atts['galleryType'] != 'gallery' ) {
			
			$html = apply_filters( 'modula_render_defaults_block', 'An error occured', $atts );

			return $html;
		} else {
			
			return '[modula id=' . absint($atts['id']) . ' align=' . esc_attr($atts['align']) . ']';
			
		}

		
	}

	/**
	 * Gallery meta ajax callback
	 * 
	 * @since 2.5.0
	 * 
	 * @return object $images
	 */
	public function get_gallery_meta() {

		$id    = $_POST['id'];
		$nonce = $_POST['nonce'];

	 	if ( ! wp_verify_nonce( $nonce, 'modula_nonce' ) ) {
			wp_send_json_error();
			die();
		}

		$images = get_post_meta( $id, 'modula-images', true );

		if ( ! is_array( $images ) || empty($images) ) {
			wp_send_json_error();
			die();
		}

		foreach ( $images as $key => $value ) :
			$image_obj                = wp_get_attachment_image_src( $images[ $key ]['id'], 'large' );
			$images[ $key ]['src']         = $image_obj[0];
			$images[ $key ]['data-width']  = $images[ $key ]['width'];
			$images[ $key ]['data-height'] = $images[ $key ]['height'];
			$images[ $key ]['width']       = $image_obj[1];
			$images[ $key ]['height']      = $image_obj[2];
		endforeach;

		echo json_encode( $images );

		die();

	}

	/**
	 * Get js config ajax callback
	 * 
	 * @since 2.5.0
	 * 
	 * @return object $js_config
 	 */
    public function get_jsconfig() {
		$nonce = $_POST['nonce'];
		$settings = $_POST['settings'] ;
		

        if( !wp_verify_nonce( $nonce, 'modula_nonce' ) ) {
            wp_send_json_error();
            die();
		}
		
		$type = 'creative-gallery';
		if ( isset( $settings['type'] ) ) {
			$type = $settings['type'];
		}else{
			$settings['type'] = 'creative-gallery';
		}

		$inView = false;
		$inview_permitted = apply_filters( 'modula_loading_inview_grids', array( 'custom-grid', 'creative-gallery', 'grid' ), $settings );
		if ( isset( $settings['inView'] ) && '1' == $settings['inView'] && in_array($type,$inview_permitted) ) {
			$inView = true;
        }

        
        $js_config = Modula_Shortcode::get_jsconfig( $settings, $type, $inView );
        echo json_encode( $js_config );
        

        die();
	}

	/**
	 * Check hover effects ajax callback
	 * 
	 * @param string $effect
	 * 
	 * @return array $effect_check
	 */
	public function check_hover_effect( $effect ) {
		
		$nonce = $_POST['nonce'];
		$effect = $_POST['effect'];

		if( !wp_verify_nonce( $nonce, 'modula_nonce' ) ) {
            wp_send_json_error();
            die();
		}
		
		$effect_check = Modula_Helper::hover_effects_elements( $effect );
		
		echo json_encode( $effect_check );

		die();

	}

}

new Modula_Gutenberg();


