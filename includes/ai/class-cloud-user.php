<?php
namespace Modula\Ai;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Cloud_User {
	/** @var Cloud_User */
	private static $instance;

	/**
	 * Retrieves the singleton instance of the Cloud_User class.
	 *
	 * @return Cloud_User The singleton instance.
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) || ! ( self::$instance instanceof Cloud_User ) ) {
			self::$instance = new Cloud_User();
		}

		return self::$instance;
	}

	/**
	 * Retrieves the API key from the options table.
	 *
	 * @return string The API key.
	 */
	public function get_api_key() {
		$api_key = get_option( 'modula_ai_api_key' );
		if ( empty( $api_key ) ) {
			$this->update_api_key( $api_key );
		}
		return get_option( 'modula_ai_api_key' );
	}

	/**
	 * Updates the API key in the options table.
	 *
	 * @param string $api_key The new API key.
	 */
	public function update_api_key( $api_key ) {
		update_option( 'modula_ai_api_key', $api_key );
	}

	/**
	 * Deletes the API key from the options table.
	 */
	public function delete_api_key() {
		delete_option( 'modula_ai_api_key' );
	}

	/**
	 * Registers a user with the AI service.
	 *
	 * @return array The registration result.
	 */
	public function register_user() {
		$current_user = wp_get_current_user();

		if ( ! $current_user || ! $current_user->exists() ) {
			return array(
				'message' => __( 'No authenticated user found', 'modula-best-grid-gallery' ),
				'success' => false,
			);
		}

		$response = wp_remote_post(
			MODULA_AI_ENDPOINT . '/auth/register-from-plugin',
			array(
				'headers' => array(
					'Content-Type' => 'application/json',
				),
				'body'    => wp_json_encode(
					array(
						'firstname'   => $current_user->first_name ?? '',
						'lastname'    => $current_user->last_name ?? '',
						'newsletters' => false,
						'email'       => $current_user->user_email,
						'password'    => wp_generate_password( 12, true ),
						'wp_url'      => site_url(),
						'withProject' => true,
						'name'        => get_bloginfo( 'name' ),
						'optins'      => 'terms',
					)
				),
				'timeout' => 50,
			)
		);

		if ( is_wp_error( $response ) ) {
			return array(
				'message' => $response->get_error_message(),
				'success' => false,
			);
		}

		$body          = json_decode( wp_remote_retrieve_body( $response ), true );
		$response_code = wp_remote_retrieve_response_code( $response );

		if ( 201 !== $response_code ) {
			return array(
				'message' => isset( $body['message'] ) ? $body['message'] : __( 'Registration failed', 'modula-best-grid-gallery' ),
				'success' => false,
			);
		}

		$user = $body;

		$this->update_api_key( $user['projects'][0]['apiKey'] );

		return array(
			'success' => true,
			'data'    => $user,
		);
	}

	/**
	 * Retrieves a cloud user.
	 *
	 * @param string $api_key The API key to validate.
	 * @return array The cloud user.
	 */
	public function get_cloud_user( $api_key ) {
		try {
			$headers = array(
				'Content-Type'  => 'application/json',
				'Authorization' => $api_key,
			);

			$response = wp_remote_get(
				MODULA_AI_ENDPOINT . '/projects/owner',
				array(
					'headers' => $headers,
					'timeout' => 50,
				)
			);
			$body     = json_decode( wp_remote_retrieve_body( $response ), true );
		} catch ( \Exception $e ) {
			return array(
				'success' => false,
				'data'    => array(
					'message' => __( 'Invalid API key', 'modula-best-grid-gallery' ),
				),
			);
		}

		if ( ! isset( $body['user'] ) || ! isset( $body['project'] ) ) {
			return array(
				'success' => false,
				'data'    => array(
					'message' => __( 'Invalid API key', 'modula-best-grid-gallery' ),
				),
			);
		}

		return array(
			'success' => true,
			'data'    => $body,
		);
	}
}
