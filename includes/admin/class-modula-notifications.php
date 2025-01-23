<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Modula_Notifications {

	public static function add_notification( $key, $notification ) {

		if ( ! isset( $notification['source'] ) ) {
			$notification['source'] = array(
				'slug' => 'modula',
				'name' => 'Modula',
			);
		}

		WPChill_Notifications::add_notification( $key, $notification );
	}
}
