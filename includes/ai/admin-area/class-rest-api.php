<?php
namespace Modula\Ai\Admin_Area;

use Modula\Ai\Cloud_User;
use Modula\Ai\Optimizer\Optimizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Rest_Api {
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
			'/ai-settings',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'ai_settings' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);
		register_rest_route(
			$this->namespace,
			'/ai-settings',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'update_ai_settings' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/generate-alt-text/',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'generate_alt_text' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/get-ai-user/',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_cloud_user' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/update-alts-from-image-array',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_update_alts_from_image_array' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/cleanup-galleries',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_cleanup_galleries' ),
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
	 * Handles the retrieval of AI settings.
	 *
	 * @return WP_REST_Response The response object.
	 */
	public function ai_settings() {
		$api_key  = get_option( 'modula_ai_api_key' );
		$language = get_option( 'modula_ai_language', get_locale() );
		$data     = $this->get_user();

		if ( ! $data['success'] ) {
			return rest_ensure_response(
				array(
					'api_key'  => $api_key,
					'language' => $language,
					'readonly' => array(
						'valid_key' => false,
					),
				)
			);
		}

		$credits = $data['data']['user']['plan']['limitImages'] +
			$data['data']['user']['bonusStockImages'] -
			$data['data']['user']['currentRequestImages'];

		$output = array(
			'api_key'  => $api_key,
			'language' => $language,
			'readonly' => array(
				'credits'    => $credits,
				'email'      => $data['data']['user']['email'],
				'first_name' => $data['data']['user']['firstName'] ?? '',
				'last_name'  => $data['data']['user']['lastName'] ?? '',
				'valid_key'  => true,
			),
		);

		return rest_ensure_response( $output );
	}

	public function update_ai_settings( $request ) {
		$body = $request->get_json_params();
		update_option( 'modula_ai_api_key', sanitize_text_field( $body['api_key'] ) );
		update_option( 'modula_ai_language', sanitize_text_field( $body['language'] ) );

		return $this->ai_settings();
	}

	/**
	 * Handles user registration with the AI service.
	 *
	 * @return WP_REST_Response The response object.
	 */
	public function register_user() {
		$user = Cloud_User::get_instance();
		return $user->register_user();
	}

	/**
	 * Retrieves a cloud user.
	 *
	 * @return array The cloud user.
	 */
	public function get_user() {
		$user = Cloud_User::get_instance();
		return $user->get_cloud_user( $user->get_api_key() );
	}

	/**
	 * Generates the alt text for the image.
	 *
	 * @param WP_REST_Request $request The request object.
	 * @return WP_REST_Response The response object.
	 */
	public function generate_alt_text( $request ) {
		$body          = $request->get_json_params();
		$optimizer     = Optimizer::get_instance( (string) $body['id'] );
		$action        = $body['action'];
		$attachment_id = $body['attachment_id'];
		$report        = get_post_meta( $attachment_id, Optimizer::REPORT, true );

		if ( $report && 'generate' === $action ) {
			return rest_ensure_response( $report );
		}

		$status = $optimizer->optimize_single( $body['attachment_id'] );

		return rest_ensure_response( $status );
	}

	/**
	 * Checks if the current user has the necessary permissions.
	 *
	 * @return bool True if the user has the necessary permissions, false otherwise.
	 */
	public function _permissions_check() {
		return current_user_can( 'manage_options' );
	}

	/**
	 * Handle the button action request to update all gallery images
	 *
	 * @return WP_REST_Response The response object
	 */
	public function handle_update_alts_from_image_array() {
		global $wpdb;

		// Get all Modula galleries
		$galleries = get_posts(
			array(
				'post_type'      => 'modula-gallery',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			)
		);

		$updated_count = 0;
		$total_images  = 0;

		foreach ( $galleries as $gallery ) {
			// Get gallery images
			$images = get_post_meta( $gallery->ID, 'modula-images', true );
			if ( ! empty( $images ) ) {
				$total_images += count( $images );
				// Use the helper class to update media library entries
				\Modula\Ai\Helpers\Image_Helper::batch_update_images( $images, $gallery->ID );

				$valid_images   = array_filter(
					$images,
					function ( $image ) {
						return isset( $image['id'] );
					}
				);
				$updated_count += count( $valid_images );
			}
		}

		$response = array(
			'success' => true,
			'message' => sprintf(
				/* translators: 1: number of images, 2: number of galleries */
				__( 'Successfully updated %1$d media library entries from %2$d galleries', 'modula-best-grid-gallery' ),
				$updated_count,
				count( $galleries )
			),
			'data'    => array(
				'total_galleries' => count( $galleries ),
				'total_images'    => $total_images,
				'updated_images'  => $updated_count,
			),
		);

		return rest_ensure_response( $response );
	}

	/**
	 * Handle the cleanup of galleries with empty titles
	 *
	 * @return WP_REST_Response The response object
	 */
	public function handle_cleanup_galleries() {
		global $wpdb;

		// First get the IDs of galleries with empty titles
		$gallery_ids = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts}
				WHERE post_type = %s
				AND (post_title = '' OR post_title IS NULL)",
				'modula-gallery'
			)
		);

		if ( empty( $gallery_ids ) ) {
			return rest_ensure_response(
				array(
					'success' => true,
					'message' => __( 'No galleries with empty titles found.', 'modula-best-grid-gallery' ),
					'data'    => array(
						'deleted_meta'  => 0,
						'deleted_posts' => 0,
					),
				)
			);
		}

		$ids_placeholders = implode( ',', array_fill( 0, count( $gallery_ids ), '%d' ) );

		// Delete postmeta entries for these galleries
		$deleted_meta = $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$wpdb->postmeta}
				WHERE post_id IN ($ids_placeholders)",
				$gallery_ids
			)
		);

		// Then delete the posts
		$deleted_posts = $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$wpdb->posts}
				WHERE ID IN ($ids_placeholders)",
				$gallery_ids
			)
		);

		$response = array(
			'success' => true,
			'message' => sprintf(
				/* translators: 1: number of meta entries deleted, 2: number of posts deleted */
				__( 'Successfully deleted %1$d meta entries and %2$d galleries with empty titles', 'modula-best-grid-gallery' ),
				$deleted_meta,
				$deleted_posts
			),
			'data'    => array(
				'deleted_meta'  => $deleted_meta,
				'deleted_posts' => $deleted_posts,
				'gallery_ids'   => $gallery_ids,
			),
		);

		return rest_ensure_response( $response );
	}
}
