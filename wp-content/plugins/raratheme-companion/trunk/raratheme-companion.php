<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://raratheme.com/
 * @since             1.0.0
 * @package           RaraTheme_Companion
 *
 * @wordpress-plugin
 * Plugin Name:       RaraTheme Companion
 * Plugin URI:        https://wordpress.org/plugins/raratheme-companion
 * Description:       23 extremely useful custom widgets to create an engaging website.
 * Version:           1.4.3
 * Author:            Rara Theme
 * Author URI:        https://raratheme.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       raratheme-companion
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'RARATC_PLUGIN_VERSION', '1.4.3' );
define( 'RARATC_BASE_PATH', dirname( __FILE__ ) );
define( 'RARATC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RARATC_FILE_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
add_image_size( 'post-slider-thumb-size', 330, 190, true );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-raratheme-companion-activator.php
 */
function activate_raratheme_companion() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-raratheme-companion-activator.php';
	Raratheme_Companion_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-raratheme-companion-deactivator.php
 */
function deactivate_raratheme_companion() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-raratheme-companion-deactivator.php';
	Raratheme_Companion_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_raratheme_companion' );
register_deactivation_hook( __FILE__, 'deactivate_raratheme_companion' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-raratheme-companion.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_raratheme_companion() {

	$plugin = new Raratheme_Companion();
	$plugin->run();

}
run_raratheme_companion();
