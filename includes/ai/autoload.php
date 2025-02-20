<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

spl_autoload_register(
	function ( $class_name ) {
		$prefix = 'Modula\\Ai\\';
		$len    = strlen( $prefix );

		if ( strncmp( $prefix, $class_name, $len ) !== 0 ) {
			return;
		}

		$relative_class = substr( $class_name, $len );

		$file = MODULA_PATH . 'includes/ai/' . str_replace(
			array( '\\', '_' ),
			array( '/', '-' ),
			strtolower( $relative_class )
		);

		$prefixes = array(
			'class-',
			'trait-',
			'interface-',
			'',
		);

		foreach ( $prefixes as $prefix ) {
			$prefixed_file = dirname( $file ) . '/' . $prefix . basename( $file ) . '.php';
			if ( file_exists( $prefixed_file ) ) {
				require $prefixed_file;
				return;
			}
		}
	}
);
