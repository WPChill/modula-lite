<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Modula_Notifications {

	public static $instance;

	private static $notification_prefix = 'modula_notification_';

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
		$options = apply_filters( 'modula_notifications', $options );

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
			);
		}
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

	public function clear_notifications() {
		$options = $this->_get_options_wildcard( self::$notification_prefix . '%' );

		foreach ( $options as $option ) {
			if ( isset( $option['option_name'] ) ) {
				delete_option( $option['option_name'] );
			}
		}
	}
}
