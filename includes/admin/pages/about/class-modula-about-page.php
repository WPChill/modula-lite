<?php

class Modula_About_Page {

	/**
	 * Holds the class object.
	 *
	 * @since 2.6.5
	 *
	 * @var object
	 */
	public static $instance;


	/**
	 * Primary class constructor.
	 *
	 * @since 2.6.5
	 */
	public function __construct() {

		add_filter( 'modula_admin_page_link', array( $this, 'modula_about_menu' ), 25, 1 );
		add_filter( 'submenu_file', array( $this, 'remove_about_submenu_item' ) );
		register_activation_hook( MODULA_FILE, array( $this, 'modula_about_redirect' ) );
	}


	/**
	 * Add the About submenu
	 *
	 * @param $links
	 *
	 * @return mixed
	 * @since 2.6.5
	 */
	function modula_about_menu( $links ) {

		// Register the hidden submenu.
		$links[] = array(
			'page_title' => esc_html__( 'About', 'modula-best-grid-gallery' ),
			'menu_title' => esc_html__( 'About', 'modula-best-grid-gallery' ),
			'capability' => 'manage_options',
			'menu_slug'  => 'modula-about-page',
			'function'   => array( $this, 'about_page' ),
			'priority'   => 45,
		);

		return $links;
	}

	/**
	 * @param $submenu_file
	 * @return mixed
	 *
	 * Remove the About submenu
	 */
	public function remove_about_submenu_item( $submenu_file ) {

		remove_submenu_page( 'edit.php?post_type=modula-gallery', 'modula-about-page' );

		return $submenu_file;
	}


	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_About_Page object.
	 * @since 2.6.5
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Modula_About_Page ) ) {
			self::$instance = new Modula_About_Page();
		}
		return self::$instance;
	}


	/**
	 * Redirect to About page when activated
	 *
	 * @param $plugin
	 * @since 2.6.5
	 */
	public function modula_about_redirect( $plugin ) {

		if ( ! get_option( 'modula_version' ) ) {

			wp_safe_redirect( admin_url( 'edit.php?post_type=modula-gallery&page=modula-about-page' ) );
			exit;
		}
	}


	/**
	 * @since 2.6.5
	 * Display About page
	 */
	public function about_page() {
		include __DIR__ . '/page.php';
	}

}

$modula_about_page = Modula_About_Page::get_instance();
