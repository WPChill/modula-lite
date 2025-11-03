<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound
class WPChill_Rest_Api {
	protected $namespace = 'wpchill/v1';

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		register_rest_route(
			$this->namespace,
			'/notifications',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_notifications' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/notifications',
			array(
				'methods'             => 'DELETE',
				'callback'            => array( $this, 'delete_notifications' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/notifications/(?P<id>[\w-]+)',
			array(
				'methods'             => 'DELETE',
				'callback'            => array( $this, 'delete_notification' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/activate-plugin',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'plugin_activation' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/onboarding/data',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_onboarding_data' ),
				'permission_callback' => array( $this, '_permissions_check' ),
				'args'                => array(
					'source' => array(
						'type' => 'string',
						'required' => false,
					),
				),
			)
		);

		register_rest_route(
			$this->namespace,
			'/onboarding/recommended',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_onboarding_recommended' ),
				'permission_callback' => array( $this, '_permissions_check' ),
				'args'                => array(
					'source' => array(
						'type' => 'string',
						'required' => false,
					),
				),
			)
		);

		register_rest_route(
			$this->namespace,
			'/onboarding/save-step',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'save_onboarding_step' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/onboarding/install-plugins',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'install_plugins' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		do_action( 'modula_rest_api_register_routes', $this );
	}

	public function process_request( $request ) {
		$manager = WPChill_Notifications::get_instance();
		if ( 'DELETE' === $request->get_method() ) {
			$body    = $request->get_json_params();
			$post_id = isset( $body['id'] ) ? $body['id'] : false;
			if ( $post_id ) {
				$permanent = isset( $body['permanent'] ) ? $body['permanent'] : false;
				$manager->clear_notification( $post_id, $permanent );
				return rest_ensure_response( true );
			}
			$manager->clear_notifications();
			return rest_ensure_response( true );
		}

		$notifications = $manager->get_notifications();

		$is_empty = array_reduce(
			$notifications,
			function ( $carry, $item ) {
				return $carry && empty( $item );
			},
			true
		);

		if ( ! $is_empty ) {
			return rest_ensure_response( $notifications );
		}

		return rest_ensure_response( array() );
	}

	public function delete_notifications() {
		$manager = WPChill_Notifications::get_instance();
		$manager->clear_notifications();
		return rest_ensure_response( true );
	}

	public function delete_notification( $request ) {
		$manager         = WPChill_Notifications::get_instance();
		$body            = $request->get_json_params();
		$notification_id = $request->get_param( 'id' );

		if ( ! $notification_id ) {
			return rest_ensure_response( false );
		}

		$permanent = isset( $body['permanent'] ) ? $body['permanent'] : false;
		$manager->clear_notification( $notification_id, $permanent );
		return rest_ensure_response( true );
	}

	public function get_notifications() {
		$manager       = WPChill_Notifications::get_instance();
		$notifications = $manager->get_notifications();

		$is_empty = array_reduce(
			$notifications,
			function ( $carry, $item ) {
				return $carry && empty( $item );
			},
			true
		);

		return rest_ensure_response( $is_empty ? array() : $notifications );
	}

	public function plugin_activation( $request ) {
		$plugin_slug = $request->get_param( 'plugin' );

		return rest_ensure_response( WPChill_About_Us::activate_plugin( $plugin_slug ) );
	}

	public function get_onboarding_data( $request ) {
		$source = $request->get_param( 'source' );

		if ( ! $source ) {
			return rest_ensure_response( false );
		}

		return rest_ensure_response( WPChill_Onboarding::get_onboarding_data( $source ) );
	}

	public function get_onboarding_recommended( $request ) {
		$source = $request->get_param( 'source' );

		if ( ! $source ) {
			return rest_ensure_response( false );
		}

		return rest_ensure_response( WPChill_Onboarding::get_onboarding_recommended( $source ) );
	}

	public function save_onboarding_step( $request ) {
		$key = $request->get_param( 'key' );
		$source = $request->get_param( 'source' );
		$data = $request->get_param( 'data' );

		return rest_ensure_response( WPChill_Onboarding::save_onboarding_step( $source, $key, $data ) );
	}

	public function install_plugins( $request ) {
		$plugins = $request->get_param( 'plugins' );

		return rest_ensure_response( WPChill_Onboarding::install_plugins( $plugins ) );
	}

	public function _permissions_check() {
		return current_user_can( 'manage_options' );
	}
}
