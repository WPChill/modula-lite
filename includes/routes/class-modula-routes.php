<?php
/**
 * Gutenberg class
 *
 * @package modula-best-grid-gallery
 */

/**
 * Register custom endpoint routes.
 *
 * @since 2.7.5
 * 
 * @package modula-best-grid-gallery
 */
class Modula_Routes {

	/**
	 * Main construct function.
	 * 
	 * @since 2.7.5
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register plugin routes.
	 */
	public function register_routes() {
		// Route to get gallery post meta.
		register_rest_route(
			'modula/v1',
			'/gallery-images/(?P<post_id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_post_meta' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		// Route to get jsConfig.
		register_rest_route(
			'modula/v1',
			'/gallery-js-config',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'get_js_config' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);
	}

	public function get_js_config(WP_REST_Request $request) {
		$data = $request->get_params();
    	$param_names = array_keys($data);
		$settings = $data['settings'];

		if ( !isset( $settings ) ) {
			return new WP_Error('invalid_parameters', 'No settings object detected');
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

		return new \WP_REST_Response(
			array(
				'js_config'   => $js_config,
				'response' => 'success',
				'settings_type' => $settings['type'],
				'type' => $type,
			)
		);
	}
	
	public function get_post_meta(WP_REST_Request $request) {
		// Get the post ID, and meta key from the request.
		$post_id = $request->get_param('post_id');

		if (!is_string($post_id)) {
 			return new WP_Error('invalid_parameters', 'The post_id parameter must be a string');
		}

		// Get the gallery images, post ID, and meta key.
		$images = get_post_meta($post_id, 'modula-images', true);

		if ( ! is_array( $images ) || empty( $images ) ) {
 			return new WP_Error('no_images', 'No images found for that gallery post_id');
		}

		foreach ( $images as $key => $value ) :
			$image_obj                     = wp_get_attachment_image_src( $images[ $key ]['id'], 'large' );
			$images[ $key ]['src']         = $image_obj[0];
			$images[ $key ]['data-width']  = $images[ $key ]['width'];
			$images[ $key ]['data-height'] = $images[ $key ]['height'];
			$images[ $key ]['width']       = $image_obj[1];
			$images[ $key ]['height']      = $image_obj[2];
		endforeach;

		// Return the meta value.
		return new \WP_REST_Response(
			array(
				'images'   => $images,
				'response' => 'success',
			)
		);
	}

	/**
	 * Check if user has permissions to access the routes.
	 *
	 * @return bool
	 */
	public function check_permissions() {
		if ( isset( $_SERVER['HTTP_X_WP_NONCE'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_WP_NONCE'] ) ), 'wp_rest' ) ) {
			return true;
		}
		return false;
	}
}

new Modula_Routes();
