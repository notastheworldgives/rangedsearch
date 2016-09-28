<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.freelancer.com/u/picaro3535.html
 * @since             1.0.0
 * @package           Mes_um_rangesearch
 * @wordpress-plugin
 * Plugin Name:       Ultimate Member - Range Search
 * Description:       Adds range search functionality to directory page of Ultimate Member plugin.
 * Version:           1.0.0
 * License:           GPLv3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain:       mes_um_rangesearch
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('MES_UM_RS_FIELDS', 'search_fields_mes_rs');
define('MES_UM_RS_FIELD_NAME_POSTFIX', '_mes_1');
define('MES_UM_RS_FORM_KEY', 'mes-rs-fid');
define('MES_UM_RS_PREFIX_MIN', 'mes_rs_prefix_min');
define('MES_UM_RS_PREFIX_MAX', 'mes_rs_prefix_max');
define('MES_UM_RS_META_KEY_PREFIX', '_um_');




/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mes_um_rangesearch-activator.php
 */
function activate_mes_um_rangesearch() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-mes_um_rangesearch-activator.php';
	Mes_um_rangesearch_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mes_um_rangesearch-deactivator.php
 */
function deactivate_mes_um_rangesearch() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mes_um_rangesearch-deactivator.php';
	Mes_um_rangesearch_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mes_um_rangesearch' );
register_deactivation_hook( __FILE__, 'deactivate_mes_um_rangesearch' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mes_um_rangesearch.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mes_um_rangesearch() {

	$plugin = new Mes_um_rangesearch();
	$plugin->run();

}
run_mes_um_rangesearch();
