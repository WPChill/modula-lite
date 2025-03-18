<?php
namespace Modula;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ai_Compatibility {
	public function __construct() {
		// Check for ImageSEO plugin on every page load
		add_action( 'admin_init', array( $this, 'check_imageseo_plugin' ) );
	}

	/**
	 * Check if Modula ImageSEO plugin is active and deactivate it
	 *
	 * @return void
	 */
	public function check_imageseo_plugin() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( ! class_exists( '\Modula_Notifications' ) ) {
			require_once MODULA_PATH . 'includes/admin/class-modula-notifications.php';
		}

		if ( ! is_plugin_active( 'modula-imageseo/modula-imageseo.php' ) ) {
			return;
		}

		deactivate_plugins( 'modula-imageseo/modula-imageseo.php' );

		$key = get_option( 'imageseo_api_key', null );

		if ( ! empty( $key ) ) {
			update_option( 'modula_ai_api_key', $key );
		}

		$notice = array(
			'title'   => __( 'Modula ImageSEO Deactivated', 'modula-best-grid-gallery' ),
			'message' => __( 'Modula ImageSEO plugin has been automatically deactivated as its functionality is now included in Modula. You can safely delete the Modula ImageSEO plugin.', 'modula-best-grid-gallery' ),
			'status'  => 'warning',
		);

		\Modula_Notifications::add_notification( 'modula-imageseo-deactivated', $notice );
	}
}
