<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Helper functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Settings
{

	public $display_settings = [];
	public $upload_settings = [];
	public $settings_group = '';

	public function __construct()
	{
		$this->settings_group = shp_icon()->prefix . '-settings-group';
		$this->upload_settings = [
			shp_icon()->prefix . '-upload-remove-xml' => [
				'legend' => _x('Remove XML Declaration', 'Options page setting label', 'shp-icon'),
				'label' => _x('XML Tag', 'Options page setting label', 'shp-icon'),
				'type' => 'boolean',
				'default' => true
			],
			shp_icon()->prefix . '-upload-remove-title' => [
				'legend' => _x('Remove Title Tag', 'Options page setting label', 'shp-icon'),
				'label' => _x('Title Tag', 'Options page setting label', 'shp-icon'),
				'type' => 'boolean',
				'default' => true
			],
			shp_icon()->prefix . '-upload-remove-desc' => [
				'legend' => _x('Remove Description Tag', 'Options page setting label', 'shp-icon'),
				'label' => _x('Description Tag', 'Options page setting label', 'shp-icon'),
				'type' => 'boolean',
				'default' => true
			],
			shp_icon()->prefix . '-upload-remove-comments' => [
				'legend' => _x('Remove Comments', 'Options page setting label', 'shp-icon'),
				'label' => _x('Comments', 'Options page setting label', 'shp-icon'),
				'type' => 'boolean',
				'default' => true
			],
			shp_icon()->prefix . '-upload-remove-id' => [
				'legend' => _x('Remove IDs', 'Options page setting label', 'shp-icon'),
				'label' => _x('IDs', 'Options page setting label', 'shp-icon'),
				'type' => 'boolean',
				'default' => true
			],
			shp_icon()->prefix . '-upload-remove-viewbox' => [
				'legend' => _x('Remove ViewBox', 'Options page setting label', 'shp-icon'),
				'label' => _x('ViewBox', 'Options page setting label', 'shp-icon'),
				'type' => 'boolean',
				'default' => false
			],
			shp_icon()->prefix . '-upload-remove-width' => [
				'legend' => _x('Remove Width', 'Options page setting label', 'shp-icon'),
				'label' => _x('Width', 'Options page setting label', 'shp-icon'),
				'type' => 'boolean',
				'default' => true
			],
			shp_icon()->prefix . '-upload-remove-height' => [
				'legend' => _x('Remove Height', 'Options page setting label', 'shp-icon'),
				'label' => _x('Height', 'Options page setting label', 'shp-icon'),
				'type' => 'boolean',
				'default' => true
			],
		];

		$this->display_settings = [
			shp_icon()->prefix . '-display-inline-shift' => [
				'legend' => _x('em (default top-shift of inline icons)', 'Options page setting label', 'shp-icon'),
				'label' => _x('Inline Top Shift', 'Options page setting label', 'shp-icon'),
				'type' => 'number',
				'default' => .15
			],
		];
	}

	public function run()
	{
		add_action('admin_init', [$this, 'registerSettings']);
	}

	public function registerSettings()
	{
		$settings = array_merge($this->upload_settings, $this->display_settings);
		foreach ($settings as $name => $data) {
			add_option($name, $data['default']);

			$args = [
				'type' => $data['type'],
				'default' => $data['default'],
			];

			if ('boolean' == $data['type']) {
				$args['sanitize_callback'] = [$this, 'sanitizeCheckbox'];
			}

			if ('number' == $data['type']) {
				$args['sanitize_callback'] = [$this, 'sanitizeNumber'];
			}

			register_setting($this->settings_group, $name, $args);
		}
	}

	public function sanitizeCheckbox($value)
	{
		if ('on' == $value) {
			$value = 1;
		} else {
			$value = 0;
		}

		return $value;
	}

	public function sanitizeNumber($value)
	{
		$value = floatval($value);
		return $value;
	}
}
