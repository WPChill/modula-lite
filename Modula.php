<?php
/**
* Plugin Name: 				Modula
* Plugin URI: 				https://wp-modula.com/
* Description: 				Modula is the most powerful, user-friendly WordPress gallery plugin. Add galleries, masonry grids and more in a few clicks.
* Author: 					WPChill
* Version: 					2.7.4
* Author URI: 				https://www.wpchill.com/
* License: 					GPLv3 or later
* License URI:         		http://www.gnu.org/licenses/gpl-3.0.html
* Requires PHP: 	    	5.6
* Text Domain: 				modula-best-grid-gallery
* Domain Path: 				/languages
*
* Copyright 2015-2017 		GreenTreeLabs 		diego@greentreelabs.net
* Copyright 2017-2020 		MachoThemes 		hello@wp-modula.com
* Copyright 2020			WPchill  			hello@wp-modula.com
*
* Original Plugin URI: 		https://modula.greentreelabs.net/
* Original Author URI: 		https://greentreelabs.net
* Original Author: 			https://profiles.wordpress.org/greentreelabs/
*
* NOTE:
* GreenTreeLabs transferred ownership rights on: 03/29/2017 06:34:07 PM when ownership was handed over to MachoThemes
* The MachoThemes ownership period started on: 03/29/2017 06:34:08 PM
* SVN commit proof of ownership transferral: https://plugins.trac.wordpress.org/changeset/1607943/modula-best-grid-gallery
*
* MachoThemes has transferred ownership to WPChill on: 5th of November, 2020. WPChill is a rebrand & restructure of MachoThemes.
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 3, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Define Constants
 *
 * @since    2.0.2
 */

define( 'MODULA_LITE_VERSION' , '2.7.4' );
define( 'MODULA_PATH' , plugin_dir_path( __FILE__ ) );
define( 'MODULA_URL' , plugin_dir_url( __FILE__ ) );
defined( 'MODULA_PRO_STORE_URL' ) || define( 'MODULA_PRO_STORE_URL' , 'https://wp-modula.com' );
defined( 'MODULA_PRO_STORE_UPGRADE_URL' ) || define( 'MODULA_PRO_STORE_UPGRADE_URL' , 'https://wp-modula.com/pricing' );
define( 'MODULA_FILE' , plugin_basename( __FILE__ ) );

define ( 'MODULA_LITE_TRANSLATE', dirname( plugin_basename( __FILE__ ) ) . '/languages' );

if( ! class_exists( 'Modula_Plugin_Usage_Tracker') ) {
	require_once dirname( __FILE__ ) . '/includes/tracking/class-plugin-usage-tracker.php';
}
if( ! function_exists( 'modula_best_grid_gallery_start_plugin_tracking' ) ) {
	function modula_best_grid_gallery_start_plugin_tracking() {
		$wisdom = new Modula_Plugin_Usage_Tracker(
			__FILE__,
			'https://tracking.wp-modula.com/',
			array(),
			true,
			true,
			0
		);
	}
	modula_best_grid_gallery_start_plugin_tracking();
}

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
