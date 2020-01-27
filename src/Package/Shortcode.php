<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Shortcode functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Shortcode {

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		add_shortcode( shp_icon()->prefix, array( $this, 'shortcode' ) );
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
	public function shortcode( $attr ) {
		$attr = shortcode_atts(
			array(
				'icon'             => false,
				'box-model'        => ( in_array( 'block', $attr, true ) ) ? true : false,
				'top-shift'        => get_option( shp_icon()->prefix . '-display-inline-top-shift' ),
				'scale-factor'     => get_option( shp_icon()->prefix . '-display-inline-scale-factor' ),
				'color'            => 'inherit',
				'background-color' => 'transparent',
				'align'            => 'normal', // used in icon block
				'gutenberg'        => ( in_array( 'gutenberg', $attr, true ) ) ? true : false, // used in icon block
			),
			$attr,
			shp_icon()->prefix
		);

		if ( file_exists( shp_icon()->upload_dir . '/' . $attr['icon'] . '.svg' ) ) {
			$icon_name = shp_icon()->Package->Helpers->getIconNameFromFileName( $attr['icon'] );

			$svg = file_get_contents( shp_icon()->upload_dir . '/' . $attr['icon'] . '.svg' );
			$svg = simplexml_load_string( $svg );

			$width         = intval( $svg->attributes()['width'] );
			$height        = intval( $svg->attributes()['height'] );
			$viewbox       = $svg->attributes()['viewBox'];
			$viewbox_array = false;

			if ( $viewbox ) {
				$viewbox_array = array_map( 'intval', explode( ' ', $viewbox ) );
			} else {
				if ( $width && $height ) {
					$viewbox_array = array( 0, 0, $width, $height );
				}
			}

			unset( $svg->attributes()['width'] );
			unset( $svg->attributes()['height'] );
			unset( $svg->attributes()['viewBox'] );

			if ( $viewbox_array ) {
				$svg->addAttribute( 'viewBox', implode( ' ', $viewbox_array ) );
				$width  = $viewbox_array[2];
				$height = $viewbox_array[3];
			}

			$svg_style = ( ! empty( $svg->attributes()['style'] ) ) ? $svg->attributes()['style'] : false;
			if ( $svg_style ) {
				$svg_style                = preg_replace( '%((width: ?[^;]+;)+)(.*?)%', '', $svg_style );
				$svg_style                = preg_replace( '%((height: ?[^;]+;)+)(.*?)%', '', $svg_style );
				$svg_style                = preg_replace( '%((display: ?[^;]+;)+)(.*?)%', '', $svg_style );
				$svg_style                = preg_replace( '%((max-width: ?[^;]+;)+)(.*?)%', '', $svg_style );
				$svg_style                = preg_replace( '%((max-height: ?[^;]+;)+)(.*?)%', '', $svg_style );
				$svg_style                = preg_replace( '%((min-width: ?[^;]+;)+)(.*?)%', '', $svg_style );
				$svg_style                = preg_replace( '%((min-height: ?[^;]+;)+)(.*?)%', '', $svg_style );
				$svg_style                = ( substr( $svg_style, -1 ) === ';' ) ? $svg_style : $svg_style . ';';
				$svg->attributes()->style = $svg_style;
			}

			if ( ! $attr['box-model'] && $height && $width ) {
				$style_width  = ( 1 * $width / $height ) * $attr['scale-factor'];
				$style_height = 1 * $attr['scale-factor'];
				$style        = 'width:' . $style_width . 'em;height:' . $style_height . 'em;';
				$style       .= 'top:' . $attr['top-shift'] . 'em;';
				if ( $svg_style ) {
					$style                    = $svg_style . $style;
					$svg->attributes()->style = $style;
				} else {
					$svg->addAttribute( 'style', $style );
				}
			}

			$color_style = '';
			if ( 'inherit' !== $attr['color'] ) {
				$color_style = 'color:' . $attr['color'] . ';';
			}

			$shift_style = '';
			if ( 'transparent' !== $attr['background-color'] ) {
				$shift_style = 'background-color:' . $attr['background-color'] . ';';
			}

			$parent_style = '';
			if ( ! empty( $color_style ) ) {
				$parent_style .= $color_style;
			}
			if ( ! empty( $shift_style ) ) {
				$parent_style .= $shift_style;
			}

			$svg = $svg->asXml();
			$svg = shp_icon()->Package->Helpers->addIconDataName( $svg, $attr['icon'] );
			$svg = preg_replace( '/<\\?xml.*\\?>/', '', $svg, 1 );

			$el         = $attr['gutenberg'] ? 'div' : 'i';
			$class_list = ( ! $attr['box-model'] ) ? shp_icon()->prefix . ' ' . shp_icon()->prefix . '--inline' : shp_icon()->prefix;
			if ( $attr['gutenberg'] ) {
				$class_list .= ' ' . shp_icon()->prefix . '--block align' . $attr['align'];
			}

			if ( ! empty( $color_style ) || ! empty( $shift_style ) ) {
				return '<' . $el . ' class="' . $class_list . '" style="' . $parent_style . '">' . $svg . '</' . $el . '>';
			} else {
				return '<' . $el . ' class="' . $class_list . '">' . $svg . '</' . $el . '>';
			}
		}
	}

	// /**
	//  * Apply the plugins shortcode to specific areas.
	//  *
	//  * @link http://wordpress.stackexchange.com/q/137725/1685
	//  *
	//  * @param string $text
	//  * @return string
	//  */
	// public function doShortcode($text)
	// {
	// 	$whitelist = [ shp_icon()->prefix ];
	//
	// 	global $shortcode_tags;
	//
	// 	// Store original copy of registered tags.
	// 	$_shortcode_tags = $shortcode_tags;
	//
	// 	// Remove any tags not in whitelist.
	// 	foreach ($shortcode_tags as $tag => $function) {
	// 		if (! in_array($tag, $whitelist)) {
	// 			unset($shortcode_tags[ $tag ]);
	// 		}
	// 	}
	//
	// 	// Apply shortcode.
	// 	$text = shortcode_unautop($text);
	// 	$text = do_shortcode($text);
	//
	// 	// Restore tags.
	// 	$shortcode_tags = $_shortcode_tags;
	//
	// 	return $text;
	// }
}
