<?php
/*
Plugin Name: SVG Icons
Plugin URI: https://github.com/joel-st/shp-icon
Description: This plugin allows you to use SVG icons within WordPress as shortcodes and/or as Gutenberg block.
Author: Joel Stüdle (joel@sayhello.ch)
Version: 1.0.5
Author URI: https://joelstuedle.ch
Text Domain: shp-icon
Domain Path: /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Use the global $wp_version Variable to make the Compatibility-Check on Plugin-Activation
global $wp_version;

// Get the File-Data from this File to reuse it in the Compatibility-Check on Plugin-Activation
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$shp_icon_headers = (object) get_plugin_data( __FILE__, true, true );

// Compatibility-Check Variables
$min_wp_version    = '5';
$min_php_version   = '7.1';
$wp_compatibility  = version_compare( $wp_version, $min_wp_version, '<' );
$php_compatibility = version_compare( PHP_VERSION, $min_php_version, '<' );

// Do the Compatibility-Check
if ( $wp_compatibility || $php_compatibility ) {

	function shp_icon_compatibility_check() {
		global $shp_icon_headers;
		global $wp_version;
		global $min_wp_version;
		global $min_php_version;

		echo '<div class="error"><p>';
		echo sprintf(
			// translators: Compatibility-Check failed Warning
			_x(
				'%1$s requires PHP %2$s (or newer) and WordPress %3$s (or newer) to function properly. Your Site is using PHP %4$s and WordPress %5$s. Please upgrade. The Plugin has been deactivated automatically. Don’t hesitate to ask for Help @%6$s.',
				'Compatibility-Check failed Warning',
				'shp-icon'
			),
			'<strong>' . $shp_icon_headers->Name . '</strong>',
			$min_php_version,
			$min_wp_version,
			PHP_VERSION,
			$wp_version,
			'<a href="' . $shp_icon_headers->PluginURI . '" target="_blank" title="">' . $shp_icon_headers->Author . '</a>'
		);
		echo '</p></div>';

		// remove the 'Plugin activated message'
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}

	add_action( 'admin_notices', 'shp_icon_compatibility_check' );
	deactivate_plugins( plugin_basename( __FILE__ ) );

	return;
}

/**
 * Load the core plugin class
 *
 * @since    1.0.0
 */

require_once 'vendor/autoload.php';

/*
* This lot auto-loads a class or trait just when you need it. You don't need to
* use require, include or anything to get the class/trait files, as long
* as they are stored in the correct folder and use the correct namespaces.
*
* See http://www.php-fig.org/psr/psr-4/ for an explanation of the file structure
* and https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md for usage examples.
*/

spl_autoload_register(
	function ( $class ) {

		// project-specific namespace prefix
		$prefix = 'SayHello\\Plugin\\Icon\\Plugin\\';

		// base directory for the namespace prefix
		$base_dir = __DIR__ . '/src/';

		// does the class use the namespace prefix?
		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			// no, move to the next registered autoloader
			return;
		}

		// get the relative class name
		$relative_class = substr( $class, $len );

		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

		// if the file exists, require it
		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

require_once 'src/Plugin.php';

function shp_icon()
{
	return SayHello\Plugin\Icon\Plugin::getInstance(__FILE__);
}
shp_icon();
