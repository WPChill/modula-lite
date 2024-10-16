<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Modula_Notifications {

	public static $instance;

	public static $notification_prefix = 'modula_notification_';
	private $hook_name                 = 'modula_notifications_remote';

	public function __construct() {

		if ( ! wp_next_scheduled( $this->hook_name ) ) {
			wp_schedule_event( time(), 'daily', $this->hook_name );
		}

		add_action( $this->hook_name, array( $this, 'get_remote_notices' ) );
	}

	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Modula_Notifications ) ) {
			self::$instance = new Modula_Notifications();
		}

		return self::$instance;
	}

	public static function add_notification( $key, $notification ) {
		update_option( self::$notification_prefix . $key, $notification );
	}

	public function get_notifications() {
		$notifications = array(
			'error'   => array(),
			'warning' => array(),
			'success' => array(),
			'info'    => array(),
		);

		$options = $this->_get_options_wildcard( self::$notification_prefix . '%' );

		foreach ( $options as $option ) {
			$id = explode( '_', $option['option_name'] );
			$id = end( $id );

			if ( ! isset( $option['option_value'] ) ) {
				continue;
			}

			$current_notifications = maybe_unserialize( $option['option_value'] );

			if ( empty( $current_notifications ) || empty( $current_notifications['message'] ) ) {
				continue;
			}

			$status = isset( $current_notifications['status'] ) ? $current_notifications['status'] : 'info';

			$notifications[ $status ][] = array(
				'id'          => $id,
				'title'       => isset( $current_notifications['title'] ) ? $current_notifications['title'] : __( 'Notification', 'modula-best-grid-gallery' ),
				'status'      => $status,
				'message'     => $current_notifications['message'],
				'dismissible' => isset( $current_notifications['dismissible'] ) ? $current_notifications['dismissible'] : true,
				'actions'     => isset( $current_notifications['actions'] ) ? $current_notifications['actions'] : array(),
				'timed'       => isset( $current_notifications['timed'] ) ? $current_notifications['timed'] : false,
			);
		}

		$notifications = apply_filters( 'modula_notifications', $notifications );

		return $notifications;
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

	public function clear_notification( $key ) {
		delete_option( self::$notification_prefix . $key );
	}

	public function clear_notifications( $prefix = false ) {
		$slug    = $prefix ? $prefix : self::$notification_prefix;
		$options = $this->_get_options_wildcard( $slug . '%' );

		foreach ( $options as $option ) {
			if ( isset( $option['option_name'] ) ) {
				delete_option( $option['option_name'] );
			}
		}
	}

	public function get_remote_notices() {
		$response = wp_remote_get( MODULA_REMOTE_NOTIFICATIONS_URL );

		if ( is_wp_error( $response ) ) {
			return;
		}

		$status_code = wp_remote_retrieve_response_code( $response );
		if ( 200 !== $status_code ) {
			return;
		}

		$body          = wp_remote_retrieve_body( $response );
		$notifications = json_decode( $body, true );

		if ( json_last_error() !== JSON_ERROR_NONE ) {
			return;
		}

		foreach ( $notifications as $key => $notification ) {
			$this->add_notification( $key, $notification );
		}
	}
}
