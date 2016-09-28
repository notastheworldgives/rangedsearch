<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.freelancer.com/u/picaro3535.html
 * @since      1.0.0
 *
 * @package    Mes_um_rangesearch
 * @subpackage Mes_um_rangesearch/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mes_um_rangesearch
 * @subpackage Mes_um_rangesearch/includes
 * @author     picaro3535 <picaro3535@gmail.com>
 */
class Mes_um_rangesearch_Activator {


    /**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        global $wp_version;
        $php_ver = "5.3.0";
        $wp_ver = "4.0";
        $um_version = "1.3.71";

        if ( version_compare( PHP_VERSION, $php_ver, '<' ) )
            $msg = "PHP version $php_ver or greater";
        else if( version_compare( $wp_version, $wp_ver, '<' ) )
            $msg = "Wordpress version $wp_ver or greater";
        else if( !class_exists('UM_API') ) {
            $msg = "Ultimate Member plugin to be activated to work properly";
        }
        else if( !version_compare( ultimatemember_version, $um_version, '>=' )){
            $msg = "$um_version version of Ultimate Member plugin to work properly";
        }
        if (isset($msg)) {
            deactivate_plugins(basename(__FILE__));
            wp_die('<p>The <strong>Ultimate Member - Range Search</strong> plugin requires ' . $msg . ' .</p>', 'Plugin Activation Error', array('response' => 200, 'back_link' => TRUE));
        }
	}
}
