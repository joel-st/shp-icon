<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Helper functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 * @since 1.0.0
 */
class Helpers
{
	/**
	 * Get the active admin color scheme to use within plugin admin area
	 *
	 * @since 1.0.0
	 */
	public function getAdminColors()
	{
		global $_wp_admin_css_colors;
		$admin_color = get_user_option('admin_color');
		return $_wp_admin_css_colors[$admin_color]->colors;
	}

	/**
	 * Converts and hex color to rgb
	 *
	 * @param string $hex hex color
	 * @param boolean|number flase if alpha is not used else input number for rgb alpha value
	 * @return array rgb(a) array
	 * @since 1.0.0
	 */
	public function hexToRgb($hex, $alpha = false)
	{
		$hex      = str_replace('#', '', $hex);
		$length   = strlen($hex);
		$rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
		$rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
		$rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
		if ($alpha) {
			$rgb['a'] = $alpha;
		}
		return $rgb;
	}

	/**
	 * Converts a filename to nice formatted icon name
	 *
	 * @param string $filname filename of an icon
	 * @return string formatted icon name
	 * @since 1.0.0
	 */
	public function getIconNameFromFileName($filename)
	{
		return ucwords(str_replace(str_split('\\/:*?"<>|+-_.'), ' ', str_replace('.svg', '', $filename)));
	}

	/**
	 * Check a filename, replace special chars and spaces to - and check if a file with the given filename already exists
	 * If exists, add a number to filename
	 *
	 * @param string $filname any filename
	 * @return string formatted file name
	 * @since 1.0.0
	 */
	public function createFileName($filename)
	{
		$new_name = strtolower(str_replace(str_split('\\/:*?"<>|+-_.'), '-', str_replace('.svg', '', $filename))) . '.svg';

		if (file_exists(shp_icon()->upload_dir . "/$new_name")) {
			$i = 1;
			while (file_exists(shp_icon()->upload_dir . "/$new_name-$i")) {
				$i++;
			}
		}

		return $new_name;
	}

	/**
	 * Adds and attribute [data-shp-icon="icon-name"] to svg
	 *
	 * @param string svg as string
	 * @return string svg as string with attribute
	 * @since 1.0.0
	 */
	public function addIconDataName($svg, $name)
	{
		if ($svg && $name) {
			$xml_svg = simplexml_load_string($svg);
			$data_name = $xml_svg->attributes()->{shp_icon()->prefix . '-data-name'};

			if (empty($data_name)) {
				$svg = str_replace('<svg ', '<svg data-' . shp_icon()->prefix . '="' . $name . '" ', $svg);
			} else {
				if ($data_name !== $name) {
					$svg = str_replace('data-' . shp_icon()->prefix . '="' . $data_name . '"', 'data-' . shp_icon()->prefix . '=="' . $name . '"', $svg);
				}
			}
		}
		return $svg;
	}

	/**
	 * Check if view is gutenberg editor
	 *
	 * @since 1.0.0
	 */
	public function isContextEdit()
	{
		return array_key_exists('context', $_GET) && $_GET['context'] === 'edit';
	}
}
