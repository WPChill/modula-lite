<?php

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

		if ( class_exists( 'Modula_Pro\Extensions\Video\Admin\Google_Auth' ) ) {
			$youtube_oauth = Modula_Pro\Extensions\Video\Admin\Google_Auth::get_instance();
			if ( 'refresh' === $data['action'] ) {
				$youtube_oauth->refresh_token( false );
			} elseif ( 'disconnect' === $data['action'] ) {
				delete_option( Modula_Pro\Extensions\Video\Admin\Google_Auth::$access_token );
				delete_option( Modula_Pro\Extensions\Video\Admin\Google_Auth::$refresh_token );
				delete_option( Modula_Pro\Extensions\Video\Admin\Google_Auth::$expiry_date );
			}
		}

		return new \WP_REST_Response( true, 200 );
	}

	public function vimeo_action( $request ) {
		$data = $request->get_json_params();

		if ( empty( $data ) || empty( $data['action'] ) ) {
			return new \WP_REST_Response( 'No action to take.', 400 );
		}

		if ( class_exists( 'Modula_Pro\Extensions\Video\Admin\Vimeo_Auth' ) ) {
			Modula_Pro\Extensions\Video\Admin\Vimeo_Auth::get_instance();
			if ( 'disconnect' === $data['action'] ) {
				delete_option( Modula_Pro\Extensions\Video\Admin\Vimeo_Auth::$access_token );
			}
		}

		return new \WP_REST_Response( true, 200 );
	}

	public function settings_permissions_check() {

		// Check if the user has the capability to manage options
		return current_user_can( 'manage_options' );
	}
}
