<?php

namespace SayHello\Plugin\Icon\Plugin\Block;

use WP_Block;

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
		add_action('init', [$this, 'registerBlock']);
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
					'anchor'           => [
						'type'    => 'string',
						'default' => '',
					],
				],
				'render_callback' => function (array $attributes, string $content, WP_Block $block) {
					$classNameBase = wp_get_block_default_classname($block->name);
					$additionalClasses = '';
					$anchor = '';

					if (!empty($block->parsed_block['attrs']['className'])) {
						$additionalClasses = $block->parsed_block['attrs']['className'];
					}

					if (!empty($block->parsed_block['attrs']['anchor'])) {
						$anchor = $block->parsed_block['attrs']['anchor'];
					}

					return $this->renderBock($attributes, $classNameBase, $additionalClasses, $anchor, $content);
				},
			]
		);
	}

	/**
	 * Render callback
	 *
	 * @since 1.0.0
	 */
	public function renderBock($a, $classNameBase, $additionalClasses = '', $anchor = '', $content = '')
	{
		if ($a['icon'] && file_exists(shp_icon()->upload_dir . '/' . $a['icon'])) {
			return do_shortcode('[' . shp_icon()->prefix . ' icon="' . str_replace('.svg', '', $a['icon']) . '" color="' . $a['color'] . '" background-color="' . $a['backgroundColor'] . '" align="' . $a['align'] . '" gutenberg anchor="' . $anchor . '" classes="' . $additionalClasses . '"]');
		} else {
			if (shp_icon()->Package->Helpers->isContextEdit()) {
				return '<div class="' . $classNameBase . ' ' . $additionalClasses . ' shp-icon shp-icon--block"><div class="shp-icon__notice">' . _x('Choose Icon', 'Block rendering notice', 'shp-icon') . '</div></div>';
			}
		}
	}
}
