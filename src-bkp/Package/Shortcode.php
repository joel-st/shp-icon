<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Shortcode functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Shortcode
{
	public function run()
	{
		add_shortcode(shp_icon()->prefix, [$this, 'shortcode']);
		//add_filter('wp_nav_menu_items', 'do_shortcode');
	}

	public function shortcode($attr)
	{
		$attr = shortcode_atts([
			'icon' => false,
			'inline' => (in_array('inline', $attr)) ? true : false,
			'top-shift' => get_option(shp_icon()->prefix . '-display-inline-shift'),
		], $attr, shp_icon()->prefix);

		if (file_exists(shp_icon()->upload_dir . '/' . $attr['icon'] . '.svg')) {
			$class_list = ($attr['inline']) ? shp_icon()->prefix . ' ' . shp_icon()->prefix . '--inline' : shp_icon()->prefix;
			$icon_shift = ($attr['inline']) ? 'style="top:'.$attr['top-shift'].'em;" ' : '';
			return '<i '.$icon_shift.'class="'.$class_list.'">'.file_get_contents(shp_icon()->upload_dir . '/' . $attr['icon'] . '.svg').'</i>';
		}
	}
}
