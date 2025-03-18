<?php
namespace Modula;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Scripts {
	/**
	 * Class instance.
	 *
	 * @var Scripts
	 */
	private static $instance;

	/**
	 * Gets the singleton instance of the Scripts class.
	 *
	 * @return Scripts The single instance of the Scripts class
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) || ! ( self::$instance instanceof Scripts ) ) {
			self::$instance = new Scripts();
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue a JavaScript asset
	 *
	 * @param string $handle The script handle
	 * @param string $src Path to the script file without extension
	 * @param array $deps Additional dependencies
	 * @param bool $in_footer Whether to enqueue in footer
	 * @return void
	 */
	public function load_js_asset( $handle, $src, $deps = array(), $entry = 'index', $in_footer = true ) {
		$asset_path = MODULA_PATH . $src . '/' . $entry . '.asset.php';

		if ( ! file_exists( $asset_path ) ) {
			return;
		}

		$asset        = require $asset_path;
		$dependencies = array_merge( $asset['dependencies'], $deps );

		wp_enqueue_script(
			$handle,
			MODULA_URL . $src . '/' . $entry . '.js',
			$dependencies,
			$asset['version'],
			$in_footer
		);
	}

	/**
	 * Register and enqueue a CSS asset
	 *
	 * @param string $handle The style handle
	 * @param string $src Path to the CSS file
	 * @param array $deps Dependencies
	 * @return void
	 */
	public function load_css_asset( $handle, $src, $deps = array(), $entry = 'index' ) {
		wp_enqueue_style(
			$handle,
			MODULA_URL . $src . '/' . $entry . '.css',
			$deps,
			MODULA_LITE_VERSION
		);
	}
}
