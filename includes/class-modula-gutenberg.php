<?php
/**
 * Gutenberg class
 *
 * @package modula-best-grid-gallery
 */

/**
 * Gutenberg class that handles ajax and output for Gutenberg block.
 *
 * @package modula-best-grid-gallery
 */
class Modula_Gutenberg {

	/**
	 * Main construct function
	 */
	function __construct() {

		// Return early if this function does not exist.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'register_block_type' ) );
		add_action( 'init', array( $this, 'generate_js_vars' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_block_assets' ), 1 );
		add_action( 'wp_ajax_modula_get_gallery', array( $this, 'get_gallery' ) );
		add_action( 'wp_ajax_modula_get_jsconfig', array( $this, 'get_jsconfig' ) );
		add_action( 'wp_ajax_modula_check_hover_effect', array( $this, 'check_hover_effect' ) );
		// Filter the gallery data for the REST API. Used for the Gutenberg editor, to remove the
		// image data-width and data-height attributes.
		add_filter( 'rest_prepare_modula-gallery', array( $this, 'rest_api_filter_data' ), 15, 3 );
	}

	/**
	 * Register block type
	 *
	 * @since 2.5.0
	 */
	public function register_block_type() {

		wp_register_script( 'modula-gutenberg', MODULA_URL . 'assets/js/admin/wp-modula-gutenberg.js', array( 'wp-blocks', 'wp-element', 'wp-data', 'jquery-ui-autocomplete', 'wp-api-fetch' ), MODULA_LITE_VERSION, true );

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
		global $pagenow;
		$screen = get_current_screen();

		//Early return to avoid loading Gutenberg assets on non-Gutenberg pages.

		if ( function_exists( 'is_gutenberg_page' ) && ! is_gutenberg_page() ) {
			return;
		}

		if ( method_exists( $screen, 'is_block_editor' ) && ! $screen->is_block_editor() ) {
			return;
		}

		// If we end up here it means that the block is enabled, so let's enqueue our scripts
		wp_enqueue_style( 'modula', MODULA_URL . 'assets/css/front.css', null, MODULA_LITE_VERSION );

		do_action( 'modula_block_style' );

		wp_enqueue_script( 'modula-selectize', MODULA_URL . 'assets/js/admin/selectize.js', null, MODULA_LITE_VERSION, true );
		wp_enqueue_style( 'modula-selectize', MODULA_URL . 'assets/css/admin/selectize.default.css', array(), MODULA_LITE_VERSION );
		wp_enqueue_script( 'modula-isotope', MODULA_URL . 'assets/js/front/isotope.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_enqueue_script( 'modula-isotope-packery', MODULA_URL . 'assets/js/front/isotope-packery.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
		wp_enqueue_script( 'modula-grid-justified-gallery', MODULA_URL . 'assets/js/front/justifiedGallery.js', array( 'jquery' ), MODULA_LITE_VERSION, true );

		do_action( 'modula_block_scripts' );

		wp_enqueue_script( 'modula', MODULA_URL . 'assets/js/front/jquery-modula.js', array( 'jquery' ), MODULA_LITE_VERSION, true );
	}

	/**
	 * Modula global variables
	 *
	 * @since 2.5.0
	 */
	public function generate_js_vars() {
		// Initialize WPChill upsell class
		$args           = apply_filters(
			'modula_upsells_args',
			array(
				'shop_url' => 'https://wp-modula.com',
				'slug'     => 'modula',
			)
		);
		$wpchill_upsell = WPChill_Upsells::get_instance( $args );

		wp_localize_script(
			'modula-gutenberg',
			'modulaVars',
			apply_filters(
				'modula_gutenberg_vars',
				array(
					'adminURL'       => admin_url(),
					'ajaxURL'        => admin_url( 'admin-ajax.php' ),
					'nonce'          => wp_create_nonce( 'modula_nonce' ),
					'gutenbergTitle' => esc_html__( 'Modula Gallery', 'modula-best-grid-gallery' ),
					'restURL'        => get_rest_url(),
					'proInstalled'   => $wpchill_upsell && $wpchill_upsell->is_upgradable_addon( 'modula-defaults' ) ? 'false' : 'true',
				)
			)
		);
	}

	/**
	 * Render modula gallery callback function for block
	 *
	 * @param array $atts Array of attributes from block.
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

		if ( isset( $atts['galleryType'] ) && 'gallery' !== $atts['galleryType'] ) {
			$html = apply_filters( 'modula_render_defaults_block', 'An error occurred', $atts );

			return $html;
		} else {
			return '[modula id=' . absint( $atts['id'] ) . ' align=' . esc_attr( $atts['align'] ) . ']';
		}
	}

	/**
	 * Get js config ajax callback
	 *
	 * @since 2.5.0
	 */
	public function get_jsconfig() {
		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json_error( 'no nonce' );
			die();
		}

		if ( ! wp_verify_nonce( $_POST['nonce'], 'modula_nonce' ) ) {//phpcs:ignore
			wp_send_json_error();
			die();
		}

		if ( isset( $_POST['settings'] ) ) {
			$settings = $_POST['settings']; //phpcs:ignore
		}

		$type = 'creative-gallery';
		if ( isset( $settings['type'] ) ) {
			$type = $settings['type'];
		} else {
			$settings['type'] = 'creative-gallery';
		}

		$in_view          = false;
		$inview_permitted = apply_filters( 'modula_loading_inview_grids', array( 'custom-grid', 'creative-gallery', 'grid' ), $settings );
		if ( isset( $settings['inView'] ) && '1' == $settings['inView'] && in_array( $type, $inview_permitted, true ) ) {
			$in_view = true;
		}

		$js_config = Modula_Shortcode::get_jsconfig( $settings, $type, $in_view ); //phpcs:ignore
		wp_send_json( $js_config );

		die();
	}

	/**
	 * Check hover effects ajax callback
	 *
	 * @param string $effect Selected effect so we can check if we add title and caption to it.
	 */
	public function check_hover_effect( $effect ) {
		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json_error( 'no nonce' );
			die();
		}

		if ( ! wp_verify_nonce( $_POST['nonce'], 'modula_nonce' ) ) {//phpcs:ignore
			wp_send_json_error();
			die();
		}

		if ( isset( $_POST['effect'] ) ) {
			$effect = $_POST['effect']; //phpcs:ignore
		}

		$effect_check = Modula_Helper::hover_effects_elements( $effect );

		wp_send_json( $effect_check );

		die();
	}

	public function get_gallery() {

		$nonce = '';
		if ( isset( $_GET['nonce'] ) ) {
			$nonce = $_GET['nonce'];
		}

		if ( ! wp_verify_nonce( $nonce, 'modula_nonce' ) ) {
			die();
		}

		$suggestions = array();
		$term        = isset( $_GET['term'] ) ? sanitize_text_field( wp_unslash( $_GET['term'] ) ) : '';

		$loop = new WP_Query(
			array(
				'p'              => $term,
				'post_type'      => 'modula-gallery',
				'posts_per_page' => -1,
			)
		);
		while ( $loop->have_posts() ) {
			$loop->the_post();
			$suggestion['label'] = get_the_title();
			$suggestion['value'] = get_the_ID();
			$suggestions[]       = $suggestion;
		}

		wp_send_json( $suggestions );
	}

	/**
	 * Filter the REST API response
	 *
	 * @param $settings
	 *
	 * @return array
	 * @since 2.11.3
	*/
	public function rest_api_filter_data( $response, $post, $request ) {
		$data = $response->get_data();
		$images = $data['modulaImages'];

		foreach ( $images as $key => $image ) {
			if ( ! isset( $image['video_template'] ) || '1' !== $image['video_template'] ) {
				$image_obj = wp_get_attachment_image_src( $images[ $key ]['id'], 'large' );

				if ( ! $image_obj ) {
					continue;
				}

				$data['modulaImages'][ $key ]['src']    = $image_obj[0];
				$data['modulaImages'][ $key ]['width']  = isset( $image['width'] ) ? $image['width'] : $image_obj[1];
				$data['modulaImages'][ $key ]['height'] = isset( $image['height'] ) ? $image['height'] : $image_obj[2];

			} else {
				$data['modulaImages'][ $key ]['src']        = $image['video_thumbnail'];
				$data['modulaImages'][ $key ]['video_type'] = false;
				if ( class_exists( 'Modula_Video' ) ) {
					$data['modulaImages'][ $key ]['src'] = Modula_Video::video_link_formatter( $image['video_url'] );
					if ( strpos( $image['video_url'], 'youtu' ) !== false || strpos( $image['video_url'], 'vimeo' ) !== false ) {
						$data['modulaImages'][ $key ]['video_type'] = 'iframe';
					} else {
						$data['modulaImages'][ $key ]['video_type'] = 'hosted';
					}
				}

				$data['modulaImages'][ $key ]['data-width']  = $image['video_width'];
				$data['modulaImages'][ $key ]['data-height'] = $image['video_height'];
				$data['modulaImages'][ $key ]['width']       = $image['video_width'];
				$data['modulaImages'][ $key ]['height']      = $image['video_height'];
			}
		}
		// Set the new data
		$response->set_data( $data );
		return $response;
	}
}

new Modula_Gutenberg();
