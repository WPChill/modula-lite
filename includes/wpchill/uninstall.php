<?php

// If uninstall not called from WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Clean up telemetry data
if ( class_exists( 'WPChill_Telemetry_Core' ) ) {
	WPChill_Telemetry_Core::cleanup();
}

// Clean up any remaining options
delete_option( 'modula_telemetry_registration_sent' );
delete_option( 'modula_telemetry_opted_out' );
delete_option( 'modula_telemetry_install_uuid' );
