<?php
var_dump(class_exists( 'ET_Builder_Element' ));die();
if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}

$module_files = glob( MODULA_PATH . '/includes/divi-builder/*/*.php' );


// Load custom Divi Builder modules
foreach ( (array) $module_files as $module_file ) {
	if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file ) ) {
		require_once $module_file;
	}
}
