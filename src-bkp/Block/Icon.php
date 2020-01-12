<?php

namespace SayHello\Plugin\Icon\Plugin\Block;

/**
 * Icon Block
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Icon
{
	public function run()
	{
		add_action('init', [$this, 'registerBlock']);
	}

	public function registerBlock()
	{
		register_block_type(shp_icon()->prefix . '/icon', [
			'attributes' => [
				'icon' => [
					'type'    => 'string',
					'default' => false,
				],
				'boxModel' => [
					'type'    => 'string',
					'default' => 'inline',
				],
			],
			'render_callback' => function ($attributes, $content) {
				return $this->renderBock($attributes, $content);
			},
		]);
	}

	public function renderBock($attributes, $content = '')
	{
		if ($attributes['icon'] && file_exists(shp_icon()->upload_dir . '/' . $attributes['icon'])) {
			return do_shortcode('['.shp_icon()->prefix.' icon="'. str_replace('.svg', '', $attributes['icon']) .'" '.$attributes['boxModel'].']');
		} else {
			return 'Choose Icon';
		}
	}
}
