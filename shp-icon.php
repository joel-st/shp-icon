<?php
/**
 * Plugin Name: SVG Icons
 * Plugin URI: https://github.com/joel-st/shp-icon
 * Description: This plugin allows you to use SVG icons within WordPress as shortcodes and/or as Gutenberg block.
 * Author: joelmelon
 * Version: 1.2.2
 * Requires at least: 6.1.7
 * Requires PHP: 8.1
 * Author URI: https://profiles.wordpress.org/joelmelon/
 * Text Domain: shp-icon
 * Domain Path: /languages
 *
 * @package           shp-icon
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

// Require the core plugin class.
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

/*
* This lot auto-loads a class or trait just when you need it. You don't need to
* use require, include or anything to get the class/trait files, as long
* as they are stored in the correct folder and use the correct namespaces.
*
* See http://www.php-fig.org/psr/psr-4/ for an explanation of the file structure
* and https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md for usage examples.
*/

spl_autoload_register(
	function ($class) {

		// project-specific namespace prefix
		$prefix = 'SayHello\\Plugin\\Icon\\Plugin\\';

		// base directory for the namespace prefix
		$base_dir = __DIR__ . '/src/';

		// does the class use the namespace prefix?
		$len = strlen($prefix);
		if (strncmp($prefix, $class, $len) !== 0) {
			// no, move to the next registered autoloader
			return;
		}

		// get the relative class name
		$relative_class = substr($class, $len);

		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

		// if the file exists, require it
		if (file_exists($file)) {
			require $file;
		}
	}
);

// Require the main plugin class.
require_once plugin_dir_path(__FILE__) . 'src/Plugin.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function shp_icon() {
	return SayHello\Plugin\Icon\Plugin::getInstance(__FILE__);
}

// Initialize the plugin after all plugins are loaded
add_action('plugins_loaded', 'shp_icon', 20);
