<?php
if (!defined('ABSPATH'))
	exit; // Exit if accessed directly

final class Modula_Elementor_Check {

	/**
	 * Plugin Version
	 *
	 * @since 1.2.0
	 * @var string The plugin version.
	 */
	const VERSION = '2.1.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var string Minimum Elementor version required to run the elementor block.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.4.5';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.2.0
	 * @var string Minimum PHP version required to run the elementor block.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {

		// Init Plugin
		add_action('plugins_loaded', array($this, 'init'));
	}

	public function init() {

		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		// Check for required Elementor version
		if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
			add_action('admin_notices', array($this, 'admin_notice_minimum_elementor_version'));
			return;
		}

		// Check for required PHP version
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', array($this, 'admin_notice_minimum_php_version'));
			return;
		}
		// Once we get here, We have passed all validation checks so we can safely include our elementor block activation
		require_once(MODULA_PATH.'includes/elementor/class-modula-elementor-widget-activation.php');
	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'modula-best-grid-gallery'),
			'<strong>' . esc_html__('Modula Elementor widget', 'modula-best-grid-gallery') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'modula-best-grid-gallery') . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'modula-best-grid-gallery'),
			'<strong>' . esc_html__('Modula Elementor widget', 'modula-best-grid-gallery') . '</strong>',
			'<strong>' . esc_html__('PHP', 'modula-best-grid-gallery') . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}
}

new Modula_Elementor_Check();
