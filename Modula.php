<?php
/**
 * Plugin Name: Modula
 * Plugin URI: https://wp-modula.com/
 * Description: Modula is the most powerful, user-friendly WordPress gallery plugin. Add galleries, masonry grids and more in a few clicks.
 * Author: Macho Themes
 * Version: 2.0.2
 * Author URI: https://www.machothemes.com/
 */

/**
 * Define Constants
 *
 * @since    2.0.2
 */
define( 'MODULA_LITE_VERSION', '2.0.2' );
define( 'MODULA_PATH', plugin_dir_path( __FILE__ ) );
define( 'MODULA_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-modula-activator.php
 */
function modula_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-modula-upgrades.php';
	$upgrades = Modula_Upgrades::get_instance();
	$upgrades->check_on_activate();
}

register_activation_hook( __FILE__, 'modula_activate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-modula.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function modula_run() {

	// Our core class
	$plugin = new Modula();

}

modula_run();