<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           WC_APIs
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce APIs
 * Plugin URI:        https://github.com/Furqankhanzada/WooCommerce-APIs
 * Description:       Its provide user based apis. Like user orders, payment history etc ...
 * Version:           1.0.0
 * Author:            Muhammad Furqan
 * Author URI:        https://www.upwork.com/fl/muhammadfurqan
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-apis
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WC_APIS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-apis-activator.php
 */
function activate_wc_apis() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-apis-activator.php';
	WC_APIs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-apis-deactivator.php
 */
function deactivate_wc_apis() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-apis-deactivator.php';
	WC_APIs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_apis' );
register_deactivation_hook( __FILE__, 'deactivate_wc_apis' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-apis.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_apis() {

	$plugin = new WC_APIs();
	$plugin->run();

}
run_wc_apis();
