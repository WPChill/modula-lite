<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Modula_Rest_Api {
	protected $namespace = 'modula-api/v1';

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
			'/clear-notifications',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'clear_notifications' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/clear-notification/(?P<id>[\w-]+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'clear_notification' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);
	}

	public function get_notifications() {
		$manager       = Modula_Notifications::get_instance();
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

		return rest_ensure_response( false );
	}

	public function clear_notification( $request ) {
		$post_id = $request->get_param( 'id' );
		$manager = Modula_Notifications::get_instance();
		$manager->clear_notification( $post_id );
		return rest_ensure_response( true );
	}

	public function clear_notifications() {
		$manager = Modula_Notifications::get_instance();
		$manager->clear_notifications();
		return rest_ensure_response( true );
	}


	public function _permissions_check() {
		// TODO: remove return true;
		return true;
		return current_user_can( 'manage_options' );
	}
}
