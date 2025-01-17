<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://revhunter.pl/
 * @since             1.0.0
 * @package           Revhuner_Wp
 *
 * @wordpress-plugin
 * Plugin Name:       Revhunter WP
 * Plugin URI:        https://revhunter.pl/integracje
 * Description:       Revhunter dostarcza ruch nowych użytkowników, angażuje do ponownych zakupów, inspiruje poprzez rekomendacje i sprzedaje.
 * Version:           1.0.0
 * Author:            Revhunter
 * Author URI:        https://revhunter.pl/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       revhunter-wp
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
define( 'REVHUNER_WP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-revhunter-wp-activator.php
 */
function activate_revhuner_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-revhunter-wp-activator.php';
	Revhuner_Wp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-revhunter-wp-deactivator.php
 */
function deactivate_revhuner_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-revhunter-wp-deactivator.php';
	Revhuner_Wp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_revhuner_wp' );
register_deactivation_hook( __FILE__, 'deactivate_revhuner_wp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-revhunter-wp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_revhuner_wp() {

	$plugin = new Revhuner_Wp();
	$plugin->run();

}

run_revhuner_wp();
