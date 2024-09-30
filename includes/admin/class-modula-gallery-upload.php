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
 * @since 2.10.2
 */

class Modula_Gallery_Upload {

	/**
	 * Holds the class object.
	 *
	 * @var Modula_Gallery_Upload
	 *
	 * @since 2.10.2
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
	 * @since 2.10.2
	 */
	private function __construct() {
		add_action( 'admin_init', array( $this, 'set_default_browser_dir' ), 15 );
	}

	/**
	 * Create an instance of the class
	 *
	 * @return Modula_Gallery_Upload
	 *
	 * @since 2.10.2
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Modula_Gallery_Upload ) ) {
			self::$instance = new Modula_Gallery_Upload();
		}

		return self::$instance;
	}

	/**
	 * Check if the user has the rights to upload files
	 *
	 * @return bool
	 *
	 * @since 2.10.2
	 */
	public function check_user_upload_rights() {
		// Check if the user has the rights to upload files and edit posts.
		if ( ! current_user_can( 'upload_files' ) || ! current_user_can( 'edit_posts' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Set the default directory for the media browser. By default, it's the uploads directory.
	 *
	 * @return void
	 */
	public function set_default_browser_dir() {
		$uploads           = wp_upload_dir();
		$this->default_dir = apply_filters( 'modula_gallery_upload_default_dir', $uploads['basedir'] );
	}
}

Modula_Gallery_Upload::get_instance();
