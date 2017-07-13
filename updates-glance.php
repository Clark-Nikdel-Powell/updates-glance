<?php

/**
 * @link              http://cnpagency.com/people/glenn
 * @since             1.0.0
 * @package           Updates_Glance
 *
 * @wordpress-plugin
 * Plugin Name:       Updates Glance
 * Plugin URI:        http://cnpagency.com
 * Description:       Shows the number of installed themes and plugins and a count of pending updates for each.
 * Version:           1.0.0
 * Author:            Glenn Welser
 * Author URI:        http://cnpagency.com/people/glenn
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       updates-glance
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-updates-glance-activator.php
 */
function activate_updates_glance() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-updates-glance-activator.php';
	Updates_Glance_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-updates-glance-deactivator.php
 */
function deactivate_updates_glance() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-updates-glance-deactivator.php';
	Updates_Glance_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_updates_glance' );
register_deactivation_hook( __FILE__, 'deactivate_updates_glance' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-updates-glance.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_updates_glance() {

	$plugin = new Updates_Glance();
	$plugin->run();

}
run_updates_glance();
