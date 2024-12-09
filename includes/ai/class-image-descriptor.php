<?php
namespace Modula\Ai;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Image_Descriptor {
	/**
	 * Base URL for the API.
	 *
	 * @var string
	 */
	public $api_base = MODULA_AI_ENDPOINT;

	/**
	 * Namespace for the REST API routes.
	 *
	 * @var string
	 */
	protected $namespace = 'modula-ai-image-descriptor/v1';

	/**
	 * Constructor for the Image_Descriptor class.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Registers the REST API routes.
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/gallery-status/(?P<id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_gallery_status' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);
		register_rest_route(
			$this->namespace,
			'/gallery-debug/(?P<id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_gallery_debug' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);
		register_rest_route(
			$this->namespace,
			'/optimize-gallery/',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'optimize_gallery' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);
		register_rest_route(
			$this->namespace,
			'/stop-optimizing-gallery/',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'stop_optimizing_gallery' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);
		register_rest_route(
			$this->namespace,
			'/imageseo-query/',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'imageseo_query' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);
	}

	/**
	 * Retrieves debug information for a gallery.
	 *
	 * @param WP_REST_Request $request The request object.
	 * @return WP_REST_Response The response object.
	 */
	public function get_gallery_debug( $request ) {
		$post_id   = $request->get_param( 'id' );
		$optimizer = Optimizer::get_instance( (string) $post_id );
		$debug     = $optimizer->get_debug();

		return rest_ensure_response( $debug );
	}

	/**
	 * Retrieves the status of an optimizer for a gallery.
	 *
	 * @param WP_REST_Request $request The request object.
	 * @return WP_REST_Response The response object.
	 */
	public function get_gallery_status( $request ) {
		$post_id   = $request->get_param( 'id' );
		$optimizer = Optimizer::get_instance( (string) $post_id );
		$status    = $optimizer->status();

		return rest_ensure_response( $status );
	}

	/**
	 * Starts the optimization process for a gallery.
	 *
	 * @param WP_REST_Request $request The request object.
	 * @return WP_REST_Response The response object.
	 */
	public function optimize_gallery( $request ) {
		$body      = $request->get_json_params();
		$optimizer = Optimizer::get_instance( (string) $body['id'] );
		$status    = $optimizer->start( $body['action'] );

		return rest_ensure_response( $status );
	}

	/**
	 * Stops the optimization process for a gallery.
	 *
	 * @param WP_REST_Request $request The request object.
	 * @return WP_REST_Response The response object.
	 */
	public function stop_optimizing_gallery( $request ) {
		$post_id   = $request->get_param( 'id' );
		$optimizer = Optimizer::get_instance( (string) $post_id );
		$status    = $optimizer->stop();

		return rest_ensure_response( $status );
	}

	/**
	 * Handles the Imageseo query.
	 *
	 * @return WP_REST_Response The response object.
	 */
	public function imageseo_query() {
		$helper = Imageseo_Helper::get_instance();
		return rest_ensure_response( $helper->get_api_user() );
	}

	/**
	 * Checks if the current user has the necessary permissions.
	 *
	 * @return bool True if the user has the necessary permissions, false otherwise.
	 */
	public function _permissions_check() {
		return current_user_can( 'manage_options' );
	}
}
