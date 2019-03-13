<?php
/**
* Plugin Name: 				Modula
* Plugin URI: 				https://wp-modula.com/
* Description: 				Modula is the most powerful, user-friendly WordPress gallery plugin. Add galleries, masonry grids and more in a few clicks.
* Author: 					MachoThemes
* Version: 					2.0.6
* Author URI: 				https://www.machothemes.com/
* License: 					GPLv3 or later
* License URI:         		http://www.gnu.org/licenses/gpl-3.0.html
* Requires PHP: 	    	5.6
* Text Domain: 				modula-best-grid-gallery
* Domain Path: 				/languages
*
* Copyright 2015-2017 		GreenTreeLabs 		diego@greentreelabs.net
* Copyright 2017-2019 		MachoThemes 		office@machothemes.com
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
define( 'MODULA_LITE_VERSION', '2.0.6' );
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