<?php
class Modula_Autoloader {
	private static $instance = null;
	private $namespace_root  = 'Modula\\';
	private $plugin_root     = MODULA_PATH;

	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		spl_autoload_register( array( $this, 'autoload' ) );
	}

	public function autoload( $class_name ) {
		// Only autoload classes from our namespace
		if ( strpos( $class_name, $this->namespace_root ) !== 0 ) {
			return;
		}

		$class_path = str_replace( $this->namespace_root, '', $class_name );
		$class_path = str_replace( '\\', DIRECTORY_SEPARATOR, $class_path );

		$file_path = $this->convert_class_to_file( $class_path );
		$file      = $this->plugin_root . 'includes/' . $file_path;

		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}

	private function convert_class_to_file( $class_path ) {
		// Convert Snake_Case to kebab-case and add class- prefix
		$file_name = 'class-' . str_replace( '_', '-', strtolower( basename( $class_path ) ) );
		$dir_path  = strtolower( dirname( $class_path ) );

		return ( '.' === $dir_path ? '' : $dir_path . DIRECTORY_SEPARATOR ) . $file_name . '.php';
	}
}
