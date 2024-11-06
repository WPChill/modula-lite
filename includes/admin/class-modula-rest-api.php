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
				'callback'            => array( $this, 'process_request' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/notifications',
			array(
				'methods'             => 'DELETE',
				'callback'            => array( $this, 'process_request' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);

		register_rest_route(
			$this->namespace,
			'/notifications/(?P<id>[\w-]+)',
			array(
				'methods'             => 'DELETE',
				'callback'            => array( $this, 'process_request' ),
				'permission_callback' => array( $this, '_permissions_check' ),
			)
		);
	}

	public function process_request( $request ) {
		$manager = Modula_Notifications::get_instance();
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

	public function _permissions_check() {
		return current_user_can( 'manage_options' );
	}
}
