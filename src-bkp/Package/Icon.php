<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Icon functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Icon
{

	public $upload_url = '';
	public $upload_dir = '';
	public $icons = '';

	public function __construct()
	{
		$this->upload_url = shp_icon()->upload_url;
		$this->upload_dir = shp_icon()->upload_dir;

		$this->icons = scandir($this->upload_dir);
		$this->icons = array_filter($this->icons, function ($icon) {
			return (strpos($icon, '.svg') !== false);
		});
	}

	public function run()
	{
	}

	public function getIconNameFromFileName($filename)
	{
		return str_replace(str_split('\\/:*?"<>|+-_.'), ' ', str_replace('.svg', '', $filename));
	}

	public function createFileName($filename)
	{
		$new_name = strtolower(str_replace(str_split('\\/:*?"<>|+-_.'), '-', str_replace('.svg', '', $filename))) . '.svg';

		if (file_exists("$this->upload_dir/$new_name")) {
			$i = 1;
			while (file_exists("$this->upload_dir/$new_name-$i")) {
				$i++;
			}
		}

		return $new_name;
	}

	public function dataNameTest($svg, $name)
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
}
