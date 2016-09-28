<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.freelancer.com/u/picaro3535.html
 * @since      1.0.0
 *
 * @package    Mes_um_rangesearch
 * @subpackage Mes_um_rangesearch/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mes_um_rangesearch
 * @subpackage Mes_um_rangesearch/includes
 * @author     picaro3535 <picaro3535@gmail.com>
 */
class Mes_um_rangesearch_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mes_um_rangesearch',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
