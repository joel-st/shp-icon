=== SVG Icons ===
Contributors: joelmelon
Tags: SVG, Icons
Requires at least: 6.1.7
Requires PHP: 8.1
Tested up to: 6.7.2
Stable tag: 1.2.1
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

This plugin allows you to use SVG icons within WordPress as shortcode and/or as Gutenberg Block and adds SVG support with the SVG-Sanitizer library.

== Installation ==

1. Upload the `svg-icons-for-wordpress` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Read the plugins help page how to prepare your icons the right way.

== Screenshots ==
1. A preview of the icon upload and the use of the SVG Icon gutenberg block

== Changelog ==

= 1.2.1 =
* Disable automatic deactivation if the requirements are not met.

= 1.2.0 =
* Compatibility check.
* Build process and dependency updates.
* Add store for gutenberg block.

= 1.1.3 =
* Compatibility check.
* Adapt internationalization improvements in 6.7 – load textdomain on `init` and fix `get_plugin_data`.
* Fix wordpress.org errors.

= 1.1.2 =
* Update vendors, update build process
* Enqueue frontend assets only if needed
* Compatibility check.

= 1.1.1 =
* Minor style fixes in Gutenberg block
* Compatibility check.

= 1.1.0 =
* Added the possibility to set class names and anchors
* Remove block align support => wrap it

= 1.0.9 =
* Compatibility check.

= 1.0.8 =
* Add `permission_callback` to rest route registration.

= 1.0.7 =
* Compatibility check.

= 1.0.6 =
* Fixes PHP error caused by incorrect use of "static" function declaration.

= 1.0.5 =
* PHP Compatibility check.

= 1.0.4 =
* Compatibility check.

= 1.0.3 =
* Update Plugin Initialization.

= 1.0.2 =
* Sanitize SVG on upload.

= 1.0.1 =
* Update Plugin i18n.

= 1.0.0 =
* Initial version.

== License ==
Use this code freely, widely and for free. Provision of this code provides and implies no guarantee.
Please respect the GPL v3 licence, which is available via http://www.gnu.org/licenses/gpl-3.0.html
