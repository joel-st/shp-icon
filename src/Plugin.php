<?php

namespace SayHello\Plugin\Icon;

use enshrined\svgSanitize\Sanitizer;
use stdClass;

/**
 * Plugin Class
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 * @since 1.0.0
 */
class Plugin
{

	private static ?Plugin $instance = null;
	public array $plugin_header = [];
	public string $domain_path   = '';
	public string $name          = '';
	public string $prefix        = 'shp-icon';
	public string $version       = '';
	public string $file          = '';
	public string $plugin_url    = '';
	public string $plugin_dir    = '';
	public string $plugin_path   = '';
	public string $base_path     = '';
	public string $upload_dir    = '';
	public string $upload_url    = '';
	public array $icons          = [];
	public bool $debug           = false;
	public array $containers     = [];

	/**
	 * Magic method for setting dynamic properties.
	 */
	public function __get(string $name): mixed
	{
		if (!isset($this->containers[$name])) {
			// Ensure the parent container exists as an empty array.
			$this->containers[$name] = new stdClass();
		}

		return $this->containers[$name];
	}

	/**
	 * Magic method for setting dynamic properties.
	 */
	public function __set(string $name, mixed $value): void
	{
		$this->containers[$name] = $value;
	}

	/**
	 * Creates an instance if one isn't already available,
	 * then return the current instance.
	 *
	 * @param string $file The file from which the class is being instantiated.
	 * @return object The class instance.
	 * @since 1.0.0
	 */
	public static function getInstance(string $file): Plugin
	{
		if (!isset(self::$instance) && !(self::$instance instanceof Plugin)) {
			self::$instance = new Plugin;

			if (! function_exists('get_plugin_data')) {
				include_once(ABSPATH . 'wp-admin/includes/plugin.php');
			}

			if (!empty($file)) {
				self::$instance->file          = $file;
			}

			self::$instance->plugin_header = get_plugin_data($file, false, /* $translate */ false);
			self::$instance->name          = self::$instance->plugin_header['Name'];
			self::$instance->domain_path   = basename(dirname(__DIR__)) . self::$instance->plugin_header['DomainPath'];
			self::$instance->version       = self::$instance->plugin_header['Version'];
			self::$instance->plugin_url    = plugins_url('', dirname(__FILE__));
			self::$instance->plugin_dir    = dirname(__DIR__);
			self::$instance->base_path     = self::$instance->prefix;
			self::$instance->upload_dir    = untrailingslashit(wp_upload_dir()['basedir']) . '/' . self::$instance->base_path;
			self::$instance->upload_url    = untrailingslashit(wp_upload_dir()['baseurl']) . '/' . self::$instance->base_path;

			if (! isset($_SERVER['HTTP_HOST']) || strpos($_SERVER['HTTP_HOST'], '.site') === false && ! in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'], true)) {
				self::$instance->debug = false;
			}

			self::$instance->run();
		}

		return self::$instance;
	}

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 1.0.0
	 */
	public function run()
	{

		// Recursive directory creation based on full path.
		wp_mkdir_p($this->upload_dir);

		$this->icons = scandir($this->upload_dir);
		$this->icons = array_filter(
			$this->icons,
			function ($icon) {
				return (strpos($icon, '.svg') !== false);
			}
		);

		// Create default icon on plugin activation
		register_activation_hook(plugin_dir_path(__DIR__) . $this->prefix . '.php', [$this, 'generateDefaultIcons']);

		// load classes
		$this->loadClasses(
			[
				Plugin\Block\Icon::class,
				Plugin\Package\Assets::class,
				Plugin\Package\Delete::class,
				Plugin\Package\Helpers::class,
				Plugin\Package\OptionsPage::class,
				Plugin\Package\Shortcode::class,
				Plugin\Package\Upload::class,
			]
		);

		// Allow svg upload
		add_filter('upload_mimes', [$this, 'allowSvgUpload']);
		add_filter('wp_handle_upload_prefilter', [$this, 'sanitizeSvg']);

		// Create rest route
		add_action('rest_api_init', [$this, 'registerRoute']);

		// Load the textdomain
		add_action('init', [$this, 'loadTextdomain']);

		// Add the settings link to the plugin list
		add_filter('plugin_action_links_' . basename($this->base_path) . '/' . basename($this->file), [$this, 'addSettingsLink']);
	}

	/**
	 * Loads and initializes the provided classes.
	 *
	 * @param array of classes
	 * @since 1.0.0
	 */
	private function loadClasses(array $classes): void
	{
		$instance = self::getInstance('');

		foreach ($classes as $class) {
			$class_parts = explode('\\', $class);
			$class_short = end($class_parts);
			$class_set = $class_parts[count($class_parts) - 2] ?? 'Global';

			// Ensure the parent container exists as an array.
			if (!isset($instance->containers[$class_set])) {
				$instance->containers[$class_set] = new stdClass();
			}

			// Prevent duplicate class assignments.
			if (property_exists($instance->containers[$class_set], $class_short)) {
				wp_die(esc_html(sprintf(_x('There was a problem with the Plugin. Only one class with name “%1$s” can be use used in “%2$s”.', 'Theme instance loadClasses() error message', 'shp-icon'), $class_short, $class_set)), 500);
			}

			// Instantiate and store the class.
			$instance->containers[$class_set]->{$class_short} = new $class();

			// Run the class if it has a `run()` method.
			if (method_exists($instance->containers[$class_set]->{$class_short}, 'run')) {
				$instance->containers[$class_set]->{$class_short}->run();
			}
		}
	}

	/**
	 * Load the plugins textdomain
	 *
	 * @since 1.0.0
	 */
	public function loadTextdomain()
	{
		load_plugin_textdomain(shp_icon()->prefix, false, $this->domain_path);
	}

	/**
	 * Adds the 'image/svg+xml' mime type to the list of allowed upload filetypes.
	 *
	 * @param  array $mimeTypes Allowed mime types.
	 * @return array Allowed mime types with SVGs.
	 * @since 1.0.0
	 */
	public function allowSvgUpload($mime_types)
	{
		$mime_types['svg'] = 'image/svg+xml';
		return $mime_types;
	}

	/**
	 * Registers an API route to get a lit of icons in the $upload_dir folder
	 *
	 * @return array of icons with keys 'name', 'filename', 'svg'
	 * @since 1.0.0
	 */
	public function registerRoute()
	{
		register_rest_route(
			shp_icon()->prefix . '/v1',
			'/icons/',
			[
				'methods'  => 'GET',
				'callback' => function ($data) {
					$icon_list = [];
					$icons     = $this->icons;

					foreach ($icons as $key => $icon) {

						$icon_path = shp_icon()->upload_dir . '/' . $icon;
						if (!file_exists($icon_path)) {
							continue;
						}

						array_push(
							$icon_list,
							[
								'name'     => ucwords(shp_icon()->Package->Helpers->getIconNameFromFileName($icon)),
								'filename' => $icon,
								'svg'      => file_get_contents($icon_path),
							]
						);
					}

					return $icon_list;
				},
				'permission_callback' => '__return_true',
			]
		);
	}

	/**
	 * Generates default icon on plugin activation if no icons in $upload_dir folder
	 *
	 * @since 1.0.0
	 */
	public function generateDefaultIcons()
	{
		global $wp_filesystem;
		$credentials = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, []);
		if (! WP_Filesystem($credentials)) {
			request_filesystem_credentials(site_url() . '/wp-admin/', '', true, false, null);
		}

		if (empty(shp_icon()->icons)) {
			$wp_filesystem->put_contents(shp_icon()->upload_dir . '/' . 'heart.svg', '<svg viewBox="0 0 33 30" data-shp-icon="heart" xmlns="http://www.w3.org/2000/svg"><path d="M16.5 30l-2.393-2.158C5.61 20.207 0 15.172 0 8.992 0 3.956 3.993 0 9.075 0c2.871 0 5.627 1.324 7.425 3.417C18.299 1.324 21.054 0 23.925 0 29.007 0 33 3.956 33 8.992c0 6.18-5.61 11.215-14.108 18.866L16.5 30z" fill="currentColor" fill-rule="evenodd"/></svg>', FS_CHMOD_FILE);
		}
	}

	/**
	 * Add a Link to Plugin Settings Page in The WordPress Plugin List
	 *
	 * @since 1.0.0
	 */
	public function addSettingsLink($links)
	{
		// Build and escape the URL.
		$url = esc_url(
			add_query_arg(
				'page',
				$this->prefix,
				get_admin_url() . 'themes.php'
			)
		);
		// Create the link.
		$settings_link = "<a href='$url'>" . _x('Settings', 'Settings link in WordPress plugin list', 'shp-icon') . '</a>';
		// Adds the link to the end of the array.
		array_push(
			$links,
			$settings_link
		);
		return $links;
	}

	/**
	 * Sanitizes a SVG file before it's saved to the server storage.
	 * This removes unallowed tags and scripts.
	 *
	 * @see    enshrined\svgSanitize\Sanitizer
	 *
	 * @param  Array $file Uploaded file.
	 *
	 * @return Array        Cleaned file if type is SVG.
	 *
	 * @since    1.0.2
	 */
	public function sanitizeSvg($file)
	{
		if ('image/svg+xml' === $file['type']) {
			$sanitizer    = new Sanitizer();
			$dirty_svg    = file_get_contents($file['tmp_name']);
			$santized_svg = $sanitizer->sanitize($dirty_svg);

			global $wp_filesystem;
			$credentials = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, []);
			if (! WP_Filesystem($credentials)) {
				request_filesystem_credentials(site_url() . '/wp-admin/', '', true, false, null);
			}

			// Using the filesystem API provided by WordPress, we replace the contents of the temporary file and then let the process continue as normal.
			$wp_filesystem->put_contents($file['tmp_name'], $santized_svg, FS_CHMOD_FILE);
		}

		return $file;
	}
}
