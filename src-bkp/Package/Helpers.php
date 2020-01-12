<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Helper functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Helpers
{
	public function getAdminColors()
	{
		global $_wp_admin_css_colors;
		$admin_color = get_user_option('admin_color');
		return $_wp_admin_css_colors[$admin_color]->colors;
	}

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
}
