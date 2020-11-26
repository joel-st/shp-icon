<?php

namespace SayHello\Plugin\Icon\Plugin\Block;

/**
 * Icon Block
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 * @since 1.0.0
 */
class Icon
{

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 1.0.0
	 */
	public function run()
	{
		add_action('init', [ $this, 'registerBlock' ]);
	}

	/**
	 * Register block to use server side rendering
	 *
	 * @since 1.0.0
	 */
	public function registerBlock()
	{
		register_block_type(
			shp_icon()->prefix . '/icon',
			[
				'attributes'      => [
					'icon'            => [
						'type'    => 'string',
						'default' => false,
					],
					'boxModel'        => [
						'type'    => 'string',
						'default' => 'block',
					],
					'scaleFactor'     => [
						'type'    => 'number',
						'default' => get_option(shp_icon()->prefix . '-display-inline-scale-factor'),
					],
					'topShift'        => [
						'type'    => 'number',
						'default' => get_option(shp_icon()->prefix . '-display-inline-top-shift'),
					],
					'color'           => [
						'type'    => 'string',
						'default' => 'inherit',
					],
					'backgroundColor' => [
						'type'    => 'string',
						'default' => 'transparent',
					],
					'align'           => [
						'type'    => 'string',
						'default' => 'normal',
					],
				],
				'render_callback' => function ($attributes, $content) {
					return $this->renderBock($attributes, $content);
				},
			]
		);
	}

	/**
	 * Render callback
	 *
	 * @since 1.0.0
	 */
	public function renderBock($a, $content = '')
	{
		//var_dump($a);
		if ($a['icon'] && file_exists(shp_icon()->upload_dir . '/' . $a['icon'])) {
			return do_shortcode('[' . shp_icon()->prefix . ' icon="' . str_replace('.svg', '', $a['icon']) . '" ' . $a['boxModel'] . ' scale-factor="' . $a['scaleFactor'] . '" top-shift="' . $a['topShift'] . '" color="' . $a['color'] . '" background-color="' . $a['backgroundColor'] . '" align="' . $a['align'] . '" gutenberg block]');
		} else {
			if (shp_icon()->Package->Helpers->isContextEdit()) {
				return '<div class="shp-icon shp-icon--block"><div class="shp-icon__notice">' . _x('Choose Icon', 'Block rendering notice', 'shp-icon') . '</div></div>';
			}
		}
	}
}
