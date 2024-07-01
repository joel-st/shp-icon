<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Shortcode functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Shortcode
{

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 1.0.0
	 */
	public function run()
	{
		add_shortcode(shp_icon()->prefix, [ $this, 'shortcode' ]);
		// add_filter('wp_nav_menu_items', 'do_shortcode');
		// add_filter('widget_text', 'do_shortcode');
		// add_filter('widget_title', 'do_shortcode');
	}

	/**
	 * The shortcode to render an icon in front-end
	 *
	 * @param array $atts shortcode attributes ['icon', 'inline', 'top-shift', 'scale-factor', 'color', 'background-color']
	 * @return array rgb(a) array
	 * @since 1.0.0
	 */
	public function shortcode($attr)
	{
		$attr = shortcode_atts(
			[
				'icon'             => false,
				'box-model'        => ( in_array('block', $attr, true) ) ? true : false,
				'top-shift'        => sanitize_option(shp_icon()->prefix . '-display-inline-top-shift', get_option(shp_icon()->prefix . '-display-inline-top-shift')),
				'scale-factor'     => sanitize_option(shp_icon()->prefix . '-display-inline-scale-factor', get_option(shp_icon()->prefix . '-display-inline-scale-factor')),
				'color'            => 'inherit',
				'background-color' => 'transparent',
				'align'            => 'normal', // used in icon block
				'gutenberg'        => ( in_array('gutenberg', $attr, true) ) ? true : false, // used in icon block
				'classes'          => ( in_array('classes', $attr, true) ) ? true : false, // used in icon block
				'anchor'           => ( in_array('anchor', $attr, true) ) ? true : false, // used in icon block
			],
			$attr,
			shp_icon()->prefix
		);

		if (file_exists(shp_icon()->upload_dir . '/' . $attr['icon'] . '.svg')) {
		    // enqueue css and js
			if( !is_admin() ) {
			    shp_icon()->Package->Assets->registerAssets();
			}

			$icon_name = shp_icon()->Package->Helpers->getIconNameFromFileName($attr['icon']);

			$svg = wp_remote_get(shp_icon()->upload_url . '/' . $attr['icon'] . '.svg')['body'];
			$svg = simplexml_load_string($svg);

			$width         = intval($svg->attributes()['width']);
			$height        = intval($svg->attributes()['height']);
			$viewbox       = $svg->attributes()['viewBox'];
			$viewbox_array = false;

			if ($viewbox) {
				$viewbox_array = array_map('intval', explode(' ', $viewbox));
			} else {
				if ($width && $height) {
					$viewbox_array = [ 0, 0, $width, $height ];
				}
			}

			unset($svg->attributes()['width']);
			unset($svg->attributes()['height']);
			unset($svg->attributes()['viewBox']);

			if ($viewbox_array) {
				$svg->addAttribute('viewBox', implode(' ', $viewbox_array));
				$width  = $viewbox_array[2];
				$height = $viewbox_array[3];
			}

			$svg_style = ( ! empty($svg->attributes()['style']) ) ? $svg->attributes()['style'] : false;
			if ($svg_style) {
				$svg_style                = preg_replace('%((width: ?[^;]+;)+)(.*?)%', '', $svg_style);
				$svg_style                = preg_replace('%((height: ?[^;]+;)+)(.*?)%', '', $svg_style);
				$svg_style                = preg_replace('%((display: ?[^;]+;)+)(.*?)%', '', $svg_style);
				$svg_style                = preg_replace('%((max-width: ?[^;]+;)+)(.*?)%', '', $svg_style);
				$svg_style                = preg_replace('%((max-height: ?[^;]+;)+)(.*?)%', '', $svg_style);
				$svg_style                = preg_replace('%((min-width: ?[^;]+;)+)(.*?)%', '', $svg_style);
				$svg_style                = preg_replace('%((min-height: ?[^;]+;)+)(.*?)%', '', $svg_style);
				$svg_style                = ( substr($svg_style, -1) === ';' ) ? $svg_style : $svg_style . ';';
				$svg->attributes()->style = $svg_style;
			}

			if (! $attr['box-model'] && $height && $width) {
				$style_width  = ( 1 * $width / $height ) * $attr['scale-factor'];
				$style_height = 1 * $attr['scale-factor'];
				$style        = 'width:' . esc_attr($style_width) . 'em;height:' . esc_attr($style_height) . 'em;';
				$style       .= 'top:' . esc_attr($attr['top-shift']) . 'em;';
				if ($svg_style) {
					$style                    = $svg_style . $style;
					$svg->attributes()->style = $style;
				} else {
					$svg->addAttribute('style', $style);
				}
			}

			$color_style = '';
			if ('inherit' !== $attr['color']) {
				$color_style = 'color:' . esc_attr($attr['color']) . ';';
			}

			$shift_style = '';
			if ('transparent' !== $attr['background-color']) {
				$shift_style = 'background-color:' . esc_attr($attr['background-color']) . ';';
			}

			$parent_style = '';
			if (! empty($color_style)) {
				$parent_style .= $color_style;
			}
			if (! empty($shift_style)) {
				$parent_style .= $shift_style;
			}

			$svg = $svg->asXml();
			$svg = shp_icon()->Package->Helpers->addIconDataName($svg, $attr['icon']);
			$svg = preg_replace('/<\\?xml.*\\?>/', '', $svg, 1);

			$el         = $attr['gutenberg'] ? 'div' : 'i';
			$class_list = ( ! $attr['box-model'] ) ? shp_icon()->prefix . ' ' . shp_icon()->prefix . '--inline' : shp_icon()->prefix;
			if ($attr['gutenberg']) {
				$class_list .= ' ' . shp_icon()->prefix . '--block align' . esc_attr($attr['align']);
			}
			$classNameBase = wp_get_block_default_classname(shp_icon()->prefix . '/icon');
			if (!empty($attr['classes'])) {
				$class_list = $attr['classes'] . ' ' . $class_list;
			}
			if (!empty($classNameBase)) {
				$class_list = $classNameBase . ' ' . $class_list;
			}
			$id = '';
			if ('string' == gettype($attr['anchor'])) {
				$id = 'id="' . $attr['anchor'] . '"';
			}

			if (! empty($color_style) || ! empty($shift_style)) {
				return '<' . esc_attr($el) . ' ' . $id . ' class="' . esc_attr($class_list) . '" style="' . esc_attr($parent_style) . '">' . $svg . '</' . esc_attr($el) . '>';
			} else {
				return '<' . esc_attr($el) . ' class="' . esc_attr($class_list) . '">' . $svg . '</' . esc_attr($el) . '>';
			}
		}
	}
}
