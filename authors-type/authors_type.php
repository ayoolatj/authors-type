<?php
/**
 * @link              http://vedno.de
 * @since             1.0.0
 * @package           Authors_type
 *
 * @wordpress-plugin
 * Plugin Name:       Authors Post Type
 * Plugin URI:        http://vedno.de/tunji-ayoola
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Tunji Ayoola
 * Author URI:        http://vedno.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       authors_type
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-authors_type-activator.php
 */
function activate_authors_type() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-authors_type-activator.php';
	Authors_type_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-authors_type-deactivator.php
 */
function deactivate_authors_type() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-authors_type-deactivator.php';
	Authors_type_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_authors_type' );
register_deactivation_hook( __FILE__, 'deactivate_authors_type' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-authors_type.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_authors_type() {

	$plugin = new Authors_type();
	$plugin->run();

}
run_authors_type();
