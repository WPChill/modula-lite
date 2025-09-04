<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WPChill Telemetry Loader
 *
 * Simple loader to initialize the telemetry system.
 * Include this file in your plugin to enable telemetry.
 *
 * @package WPChill
 * @since 1.0.0
 */

// Load the core telemetry system
if ( ! class_exists( 'WPChill_Telemetry_Core' ) ) {
	require_once __DIR__ . '/class-wpchill-telemetry-core.php';
}

// Load the public API functions
if ( ! function_exists( 'wpchill_telemetry_send_event' ) ) {
	require_once __DIR__ . '/wpchill-telemetry-functions.php';
}

// Initialize the core (singleton)
WPChill_Telemetry_Core::get_instance();
