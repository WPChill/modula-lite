<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Class Modula_Gallery_Upload
 *
 * Handles the fast gallery creation from uploaded .zip file
 * or from a choosen folder with images that reside on the server
 *
 * @since 2.10.3
 */

class Modula_Gallery_Upload {

	/**
	 * Holds the class object.
	 *
	 * @var Modula_Gallery_Upload
	 *
	 * @since 2.10.3
	 */
	public static $instance = null;

	/**
	 * Defines the default directory for the media browser
	 *
	 * @var string
	 */
	public $default_dir = null;

	/**
	 * Class constructor
	 *
	 * @since 2.10.3
	 */
	private function __construct() {
	}

	/**
	 * Create an instance of the class
	 *
	 * @return Modula_Gallery_Upload
	 *
	 * @since 2.10.3
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Modula_Gallery_Upload ) ) {
			self::$instance = new Modula_Gallery_Upload();
		}

		return self::$instance;
	}
}

Modula_Gallery_Upload::get_instance();
