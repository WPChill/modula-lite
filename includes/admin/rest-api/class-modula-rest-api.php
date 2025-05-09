<?php

use Modula\Ai\Cloud_User;

class Modula_Rest_Api {

	private $namespace = 'modula-best-grid-gallery/v1';
	private $settings  = null;

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
		$this->settings = Modula_Settings::get_instance();
	}

	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/general-settings',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_settings' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);
		register_rest_route(
			$this->namespace,
			'/general-settings',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'update_settings' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);
		register_rest_route(
			$this->namespace,
			'/general-settings-tabs',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_tabs' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/video/youtube',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'youtube_action' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/video/vimeo',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'vimeo_action' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/license-data',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_license_data' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/ai-settings',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'ai_settings' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/ai-settings',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'update_ai_settings' ),
				'permission_callback' => array( $this, 'settings_permissions_check' ),
			)
		);
	}

	public function get_settings() {
		return new \WP_REST_Response( $this->settings->get_settings(), 200 );
	}

	public function update_settings( $request ) {
		$settings = $request->get_json_params();

		if ( empty( $settings ) || ! is_array( $settings ) ) {
			return new \WP_REST_Response( 'No settings to save.', 400 );
		}

		foreach ( $settings as $option => $value ) {
			update_option( $option, $value );

			do_action( 'modula_settings_api_update_' . $option, $value );
		}

		return new \WP_REST_Response( $settings, 200 );
	}

	public function get_tabs() {
		return new \WP_REST_Response( $this->settings->get_tabs(), 200 );
	}

	public function youtube_action( $request ) {
		$data = $request->get_json_params();

		if ( empty( $data ) || empty( $data['action'] ) ) {
			return new \WP_REST_Response( 'No action to take.', 400 );
		}

		if ( class_exists( 'Modula_Video' ) && ! class_exists( 'Modula_Video_Google_Auth' ) ) {
			require_once WP_PLUGIN_DIR . '/modula-video/includes/admin/class-modula-video-google-auth.php';
		}

		if ( class_exists( 'Modula_Video_Google_Auth' ) ) {
			$youtube_oauth = Modula_Video_Google_Auth::get_instance();
			if ( 'refresh' === $data['action'] ) {
				$youtube_oauth->refresh_token( false );
			} elseif ( 'disconnect' === $data['action'] ) {
				delete_option( Modula_Video_Google_Auth::$accessToken ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				delete_option( Modula_Video_Google_Auth::$refreshToken ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				delete_option( Modula_Video_Google_Auth::$expiryDate ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			}
		}

		return new \WP_REST_Response( true, 200 );
	}

	public function vimeo_action( $request ) {
		$data = $request->get_json_params();

		if ( empty( $data ) || empty( $data['action'] ) ) {
			return new \WP_REST_Response( 'No action to take.', 400 );
		}

		if ( class_exists( 'Modula_Video' ) && ! class_exists( 'Modula_Video_Vimeo_Auth' ) ) {
			require_once WP_PLUGIN_DIR . '/modula-video/includes/admin/class-modula-video-vimeo-auth.php';
		}

		if ( class_exists( 'Modula_Video_Vimeo_Auth' ) ) {
			$youtube_oauth = Modula_Video_Vimeo_Auth::get_instance();
			if ( 'disconnect' === $data['action'] ) {
				delete_option( Modula_Video_Vimeo_Auth::$accessToken ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			}
		}

		return new \WP_REST_Response( true, 200 );
	}

	public function get_license_data() {

		$license            = get_option( 'modula_pro_license_key', '' );
		$status             = get_option( 'modula_pro_license_status', false );
		$alternative_server = get_option( 'modula_pro_alernative_server', false );
		$messages           = array(
			'no-license'       => esc_html__( 'Enter your license key.', 'modula-best-grid-gallery' ),
			'activate-license' => esc_html__( 'Activate your license key.', 'modula-best-grid-gallery' ),
			// translators: %s is the expiration date of the license.
			'all-good'         => __( 'Your license is active until <strong>%s</strong>.', 'modula-best-grid-gallery' ),
			'lifetime'         => __( 'Your license is active <strong>forever</strong>.', 'modula-best-grid-gallery' ),
			'expired'          => esc_html__( 'Your license has expired.', 'modula-best-grid-gallery' ),
		);

		$license_message = '';

		if ( '' === $license ) {
			$license_message = $messages['no-license'];
		} elseif ( '' !== $license && false === $status ) {
			$license_message = $messages['activate-license'];
		} elseif ( 'expired' === $status->license ) {
			$license_message = $messages['expired'];
		} elseif ( '' !== $license && false !== $status && isset( $status->license ) && 'valid' === $status->license ) {
			$date_format = get_option( 'date_format' );

			if ( 'lifetime' === $status->expires ) {
				$license_message = $messages['lifetime'];
			} else {
				$license_expire = gmdate( $date_format, strtotime( $status->expires ) );
				$curr_time      = time();
				// weeks till expiration
				$weeks = (int) ( ( strtotime( $status->expires ) - $curr_time ) / ( 7 * 24 * 60 * 60 ) );

				// set license status based on colors
				if ( 4 >= $weeks ) {
					$l_stat = 'red';
				} else {
					$l_stat = 'green';
				}

				$license_message = sprintf( '<p class="%s">' . $messages['all-good'] . '</p>', $l_stat, $license_expire );

				if ( 'green' !== $l_stat ) {
					// translators: %s is the number of weeks untill the expiration date of the license.
					$license_message .= sprintf( __( 'You have %s week(s) untill your license will expire.', 'modula-best-grid-gallery' ), $weeks );
				}
			}
		}

		$data = array(
			'license'   => $license,
			'status'    => $status,
			'altServer' => false,
			'message'   => $license_message,
		);

		return new \WP_REST_Response( $data, 200 );
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

	public function settings_permissions_check() {

		// Check if the user has the capability to manage options
		return current_user_can( 'manage_options' );
	}
}
