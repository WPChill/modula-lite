<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPChill Telemetry Public API
 *
 * Simple functions for plugins to use the telemetry system.
 *
 * @package WPChill
 * @since 1.0.0
 */

/**
 * Get the installation UUID
 *
 * @return string
 */
function wpchill_telemetry_get_install_uuid() {
	$core = WPChill_Telemetry_Core::get_instance();
	return $core->get_install_uuid();
}

/**
 * Register installation with telemetry service
 *
 * @param bool $blocking Whether to block on response
 * @return array|WP_Error
 */
function wpchill_telemetry_register_now( $blocking = false ) {
	$core = WPChill_Telemetry_Core::get_instance();
	return $core->send_registration( $blocking );
}

/**
 * Send state snapshot
 *
 * @param bool $full Whether this is a full state update
 * @param bool $blocking Whether to block on response
 * @return array|WP_Error
 */
function wpchill_telemetry_send_state( $full = false, $blocking = false ) {
	$core = WPChill_Telemetry_Core::get_instance();
	return $core->send_state( $full, $blocking );
}

/**
 * Send settings
 *
 * @param string $product_slug Product slug
 * @param array $settings Settings array
 * @param bool $blocking Whether to block on response
 * @return array|WP_Error
 */
function wpchill_telemetry_send_settings( $product_slug, $settings, $blocking = false ) {
	$core = WPChill_Telemetry_Core::get_instance();
	return $core->send_settings( $product_slug, $settings, $blocking );
}

/**
 * Send event
 *
 * @param string $name Event name
 * @param array $props Event properties
 * @param bool $blocking Whether to block on response
 * @return array|WP_Error
 */
function wpchill_telemetry_send_event( $name, $props = array(), $blocking = false ) {
	$core = WPChill_Telemetry_Core::get_instance();
	return $core->send_event( $name, $props, $blocking );
}

/**
 * Send batch events
 *
 * @param array $events Array of events
 * @param bool $blocking Whether to block on response
 * @return array|WP_Error
 */
function wpchill_telemetry_send_events_batch( $events, $blocking = false ) {
	$core = WPChill_Telemetry_Core::get_instance();
	return $core->send_events_batch( $events, $blocking );
}

/**
 * Opt in to telemetry
 */
function wpchill_telemetry_opt_in() {
	$core = WPChill_Telemetry_Core::get_instance();
	$core->opt_in();
}

/**
 * Opt out of telemetry
 */
function wpchill_telemetry_opt_out() {
	$core = WPChill_Telemetry_Core::get_instance();
	$core->opt_out();
}

/**
 * Check if telemetry is enabled
 *
 * @return bool
 */
function wpchill_telemetry_is_enabled() {
	$core = WPChill_Telemetry_Core::get_instance();
	return $core->is_enabled();
}

/**
 * Get telemetry status
 *
 * @return array
 */
function wpchill_telemetry_get_status() {
	$core = WPChill_Telemetry_Core::get_instance();
	return $core->get_queue_status();
}

/**
 * Legacy function aliases for backward compatibility
 */

/**
 * @deprecated Use wpchill_telemetry_get_install_uuid() instead
 */
function modula_telemetry_get_install_uuid() {
	return wpchill_telemetry_get_install_uuid();
}

/**
 * @deprecated Use wpchill_telemetry_send_event() instead
 */
function modula_telemetry_send_event( $name, $props = array() ) {
	return wpchill_telemetry_send_event( $name, $props );
}

/**
 * @deprecated Use wpchill_telemetry_send_settings() instead
 */
function modula_telemetry_send_settings( $product_slug, $settings ) {
	return wpchill_telemetry_send_settings( $product_slug, $settings );
}
