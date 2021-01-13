<?php


class Modula_Admin_Helpers {

	/**
	 * Holds the class object.
	 *
	 * @since 2.4.2
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * Modula_Admin_Helpers constructor.
	 *
	 * @since 2.4.2
	 */
	function __construct() {

	}


	/**
	 * Returns the singleton instance of the class.
	 *
	 * @return object The Modula_Admin_Helpers object.
	 * @since 2.4.2
	 */
	public static function get_instance() {

		if ( !isset( self::$instance ) && !( self::$instance instanceof Modula_Admin_Helpers ) ) {
			self::$instance = new Modula_Admin_Helpers();
		}

		return self::$instance;

	}

	/**
	 * Display the Modula Admin Page Header
	 */
	public static function modula_page_header() {
		?>
		<div class="modula-page-header">
			<div class="modula-header-logo">
				<img src="<?php echo MODULA_URL . 'assets/images/logo-dark.webp'; ?>" class="modula-logo">
			</div>
			<div class="modula-header-links">
				<a href="https://modula.helpscoutdocs.com/" target="_blank" id="get-help"
				   class="button button-secondary"><span
							class="dashicons dashicons-external"></span><?php esc_html_e( 'Help', 'modula-best-grid-gallery' ); ?>
				</a>
				<a class="button button-primary"
				   href="https://wp-modula.com/contact-us/"><span
							class="dashicons dashicons-external"></span><?php echo esc_html__( 'Contact us for support!', 'modula-best-grid-gallery' ); ?>
				</a>
			</div>
		</div>
		<?php
	}
}

$modula_admin_helpers = Modula_Admin_Helpers::get_instance();