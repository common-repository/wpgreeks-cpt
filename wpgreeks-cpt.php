<?php
/**
 * @package WPGreeksCPT
 * @author Prashant Agarwal
 * @license GPL-2.0-or-later
 */

/*
Plugin Name: WPGreeks CPT
Plugin URI: https://wordpress.org/plugins/wpgreeks-cpt/
Description: WPGreeks CPT Plugin offers an intuitive interface for registering and managing custom post types and taxonomies, now enhanced with official widgets for dynamic content display.
Version: 2.0.0
Requires at least: 6.0
Requires PHP: 7.4
Author: Prashant Agarwal
Author URI: https://dev-wpgreeks-cpt.pantheonsite.io/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: wpgreeks-cpt
*/

/*
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

define( 'WPGREEKS_PLUGIN', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation
 */
function wpgreeks_activate_plugin() {
	Wpgreekscpt\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'wpgreeks_activate_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function wpgreeks_deactivate_plugin() {
	Wpgreekscpt\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'wpgreeks_deactivate_plugin' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Wpgreekscpt\\WpgreeksInit' ) ) {
	Wpgreekscpt\WpgreeksInit::wpgreeks_register_services();
}