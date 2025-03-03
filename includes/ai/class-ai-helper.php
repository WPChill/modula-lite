<?php
namespace Modula\Ai;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ai_Helper {
	/** @var string */
	const REPORT = '_modula_ai_report';

	/**
	 * Class Ai_Helper
	 *
	 * Helper class for AI-related functionality in Modula.
	 * Handles API key management, image object creation, and batch processing.
	 *
	 * @package Modula\Ai
	 */
	private static $instance;

	/**
	 * The base URL of the API.
	 *
	 * @var string
	 */
	protected $api_base = MODULA_AI_ENDPOINT;

	/**
	 * Gets the singleton instance of the Ai_Helper class.
	 *
	 * Ensures only one instance of Ai_Helper exists at a time by implementing
	 * the singleton pattern.
	 *
	 * @return Ai_Helper The single instance of the Ai_Helper class
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) || ! ( self::$instance instanceof Ai_Helper ) ) {
			self::$instance = new Ai_Helper();
		}

		return self::$instance;
	}

	/**
	 * Retrieves AI Api KEY
	 *
	 * @return void
	 */
	public function get_api_key() {
		$user = Cloud_User::get_instance();
		return $user->get_api_key();
	}

	/**
	* Creates an API image object.
	*
	* @param int $id The internal ID of the image.
	* @return array The API image object.
	*/
	public function create_api_image( $id ) {
		$attachment_url = wp_get_attachment_url( $id );
		return array(
			'internalId' => $id,
			'url'        => $attachment_url,
			'requestUrl' => get_site_url(),
		);
	}

	/**
	 * Retrieves items by batch ID from the API.
	 *
	 * @param string $api_base The API base URL.
	 * @param int $batchId The ID of the batch.
	 */
	public function get_items_by_batch_id( $batch_id ) {
		try {
			$response = wp_remote_get(
				$this->api_base . '/projects/v2/images/' . $batch_id,
				array(
					'headers' => array(
						'Content-Type'  => 'application/json',
						'Authorization' => 'Bearer ' . $this->get_api_key(),
					),
				)
			);

			if ( is_wp_error( $response ) ) {
				throw new \Exception( $response->get_error_message() );
			}

			$result = wp_remote_retrieve_body( $response );
			return json_decode( $result, true );
		} catch ( \Exception $e ) {
			return $e;
		}
	}


	/**
	 * Sends a request to the API with image data.
	 *
	 * @param string $api_base The base URL of the API.
	 * @param array  $images   Array of image data to send to the API.
	 * @param bool   $single   Whether this is a single image request. Default false.
	 * @return array|Exception The API response as an array on success, Exception on failure.
	 */
	public function send_request_to_api( $images, $single = false ) {
		$locale = get_option( 'modula_ai_language', get_locale() );
		if ( empty( $locale ) ) {
			$locale = 'en_US';
		}

		$data_obj = array(
			'images' => $images,
			'lang'   => $locale,
		);

		try {
			$response = wp_remote_post(
				$this->api_base . '/projects/v2/' . ( $single ? 'image' : 'images' ) . '/',
				array(
					'headers' => array(
						'Content-Type'  => 'application/json',
						'Authorization' => 'Bearer ' . $this->get_api_key(),
					),
					'body'    => wp_json_encode( $data_obj ),
					'timeout' => $single ? 45 : 10,
				)
			);

			if ( is_wp_error( $response ) ) {
				throw new \Exception( $response->get_error_message() );
			}

			$result = wp_remote_retrieve_body( $response );
			return json_decode( $result, true );
		} catch ( \Exception $e ) {
			return $e;
		}
	}

	/**
	 * Checks if the API limits have been reached.
	 *
	 * @return bool True if the limits have been reached, false otherwise.
	 */
	public function check_api_limits() {
		return false;
	}

	/**
	 * Converts an array to camel case.
	 *
	 * @param array $options The array to convert.
	 * @return array The converted array.
	 */
	public function convert_to_camel_case( $options ) {
		$camel_cased = array();

		foreach ( $options as $key => $value ) {
			if ( strpos( $key, '_' ) === -1 ) {
				$camel_cased[ $key ] = $value;
				continue;
			}

			$camel_case_key = lcfirst( str_replace( '_', '', ucwords( $key, '_' ) ) );

			$camel_cased[ $camel_case_key ] = $value;
		}

		return $camel_cased;
	}

	public static function add_notice( $id, $notice ) {
		if ( ! class_exists( '\Modula_Notifications' ) ) {
			return;
		}
		\Modula_Notifications::add_notification( $id, $notice );
	}

	public static function reset_notices() {
		if ( ! class_exists( '\Modula_Notifications' ) ) {
			return;
		}
		$modula_notifications = \Modula_Notifications::get_instance();
		$modula_notifications->clear_notifications(
			$modula_notifications::$notification_prefix . 'imageseo'
		);
	}

	public function error_translation( $err ) {
		if ( strpos( $err, 'ECONNREFUSED' ) !== false ) {
			return array(
				'error' => __( 'Connection refused', 'modula-best-grid-gallery' ),
				'code'  => 'ECONNREFUSED',
			);
		}

		if ( strpos( $err, 'ETIMEDOUT' ) !== false ) {
			return array(
				'error' => __( 'Connection timed out', 'modula-best-grid-gallery' ),
				'code'  => 'ETIMEDOUT',
			);
		}

		if ( 'You have reached the limit of images to optimize' === $err ) {
			return array(
				'error' => __( 'You have reached the limit of images to optimize', 'modula-best-grid-gallery' ),
				'code'  => 'limit_reached',
			);
		}

		return array(
			'error' => $err,
			'code'  => 'unknown',
		);
	}

	public function get_all_errors() {
		$options = $this->_get_options_wildcard( 'modula_ai_optimizer_report_%' );
		$errors  = array();

		foreach ( $options as $option ) {
			$id = explode( '_', $option['option_name'] );
			$id = end( $id );

			if ( ! isset( $option['option_value'] ) ) {
				continue;
			}

			$current_errors = maybe_unserialize( $option['option_value'] );

			if ( ! is_array( $errors ) ) {
				continue;
			}

			if ( empty( $current_errors['errors'] ) ) {
				continue;
			}

			$errors[] = array(
				'id'     => $id,
				'title'  => get_the_title( $id ),
				'errors' => array_map(
					array( $this, 'error_translation' ),
					$current_errors['errors']
				),
			);
		}

		return $errors;
	}

	private function _get_options_wildcard( $option_pattern ) {
		global $wpdb;

		$options = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE %s",
				$option_pattern
			),
			ARRAY_A
		);

		return $options;
	}

	/**
	 * Checks if the image has been optimized.
	 *
	 * @param int $id The ID of the image.
	 * @return bool True if the image has been optimized, false otherwise.
	 */
	public function check_if_optimized( $id ) {
		$optimized = get_post_meta( $id, self::REPORT, true );

		return $optimized;
	}
}
