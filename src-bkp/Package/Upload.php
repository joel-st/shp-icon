<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

use enshrined\svgSanitize\Sanitizer;

/**
 * Upload functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Upload
{

	public $upload_element_id = '';
	public $upload_input_id = '';
	public $upload_nonce_action = '';
	public $upload_nonce_name = '';
	public $action = '';

	public function __construct()
	{
		$this->upload_element_id = shp_icon()->prefix . '-upload';
		$this->upload_input_id = shp_icon()->prefix . '-upload-input';
		$this->upload_nonce_action = shp_icon()->prefix . '-upload';
		$this->upload_nonce_name = shp_icon()->prefix . '-upload-nonce';
		$this->action = str_replace('-', '_', shp_icon()->prefix . '-upload');
	}

	public function run()
	{
		add_action('wp_ajax_' . $this->action, [$this, 'upload']);
		add_action('wp_ajax_nopriv_' . $this->action, [$this, 'upload']);
		add_action('wp_ajax_shp_icon_push_icon', [$this, 'pushIcon']);
		add_action('wp_ajax_nopriv_shp_icon_push_icon', [$this, 'pushIcon']);
	}

	public function renderUpload()
	{
		echo '<div id="' . $this->upload_element_id . '" class="' . $this->upload_element_id . '">';
		//echo '<form class="' . $this->upload_element_id . '__form" action="' . admin_url('admin-ajax.php') . '" method="post" enctype="multipart/form-data">';
		wp_nonce_field($this->upload_nonce_action, $this->upload_nonce_name);
		echo '<input id="'.$this->upload_input_id.'" type="file" accept=".svg" multiple class="' . $this->upload_element_id . '__upload-input" style="visibility:hidden" />';
		//echo '</form>';
		echo '<div class="' . $this->upload_element_id . '__status">';
		echo '</div>';
		echo '</div>';
	}

	public function upload()
	{

		$upload_id = isset($_POST['id']) ? $_POST['id'] : false;

		if (!$upload_id) {
			header('HTTP/1.1 400 Bad Request');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('No Upload ID specified', 'Upload without id', 'shp-icon'), 'id' => $upload_id]));
		}

		if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], $this->upload_nonce_name)) {
			header('HTTP/1.1 406 Not Acceptable');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('No _wpnonce provided', 'Upload without nonce', 'shp-icon'), 'id' => $upload_id]));
		}

		if (!isset($_FILES) || empty($_FILES)) {
			header('HTTP/1.1 400 Bad Request');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('No files provided', 'Upload without files', 'shp-icon'), 'id' => $upload_id]));
		}

		if (sizeof($_FILES) !== 1) {
			header('HTTP/1.1 400 Bad Request');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('Invalid amount of files', 'Upload false amount of files', 'shp-icon'), 'id' => $upload_id]));
		}

		$file          = (isset($_FILES['file'])) ? $_FILES['file'] : false;
		$file_name     = $file ? (isset($file['name'])) ? $file['name'] : false : false;
		$file_type     = $file ? (isset($file['type'])) ? $file['type'] : false : false;
		$file_tmp_name = $file ? (isset($file['tmp_name'])) ? $file['tmp_name'] : false : false;

		if (!$file || !$file_name || !$file_type || !$file_tmp_name) {
			header('HTTP/1.1 400 Bad Request');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('Invalid file', 'Upload fals amount of files', 'shp-icon'), 'id' => $upload_id]));
		}

		if (strpos($file_type, 'svg') === false) {
			header('HTTP/1.1 400 Bad Request');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('Invalid file type', 'Upload fals amount of files', 'shp-icon'), 'id' => $upload_id]));
		}

		$sanitised_svg = $this->sanitiseSvg($file);

		if (!$sanitised_svg) {
			header('HTTP/1.1 500 Internal Server Error');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('Sanitation failed', 'Upload sanitation failed', 'shp-icon'), 'id' => $upload_id]));
		}

		$file_name = shp_icon()->Package->Icon->createFileName($file_name);
		$sanitised_svg = shp_icon()->Package->Icon->dataNameTest($sanitised_svg, str_replace('.svg', '', $file_name));
		$sanitised_svg = $this->svgo($sanitised_svg);

		add_filter('upload_dir', [$this, 'uploadDirFilter']);    // disables the filter
		$upload = wp_upload_bits($file_name, null, $sanitised_svg);
		remove_filter('upload_dir', [$this, 'uploadDirFilter']); // enables the filter

		header('HTTP/1.1 201 Created');
		header('Content-type: application/json');
		exit(json_encode([
			'upload' => $upload,
			'id' => $upload_id,
			'name' => ucwords(shp_icon()->Package->Icon->getIconNameFromFileName(basename($upload['file']))),
			'fileName' => basename($upload['file']),
		]));
	}

	/**
	 * Sanitizes a SVG file before it's saved to the server storage.
	 * This removes unallowed tags and scripts.
	 *
	 * @see    enshrined\svgSanitize\Sanitizer
	 *
	 * @param  Array $file Uploaded file.
	 *
	 * @return Array        Cleaned file if type is SVG.
	 */
	public function sanitiseSvg($file)
	{
		if ($file[ 'type' ] == 'image/svg+xml') {
			$sanitiser    = new Sanitizer();
			$sanitiser->minify(true);

			$dirtySVG     = file_get_contents($file[ 'tmp_name' ]);
			$sanitizedSvg = $sanitiser->sanitize($dirtySVG);

			global $wp_filesystem;
			$credentials = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, array());
			if (! WP_Filesystem($credentials)) {
				request_filesystem_credentials(site_url() . '/wp-admin/', '', true, false, null);
			}

			return $sanitizedSvg;
		} else {
			return false;
		}
	}

	public function uploadDirFilter($args)
	{
		$args['path'] = shp_icon()->upload_dir;
		$args['url'] = shp_icon()->upload_url;
		$args['subdir'] = '';

		return $args;
	}

	public function pushIcon()
	{
		shp_icon()->Package->OptionsPage->renderIcon($_POST['icon'], shp_icon()->prefix . '-list');
		exit();
	}

	public function svgo($svg)
	{
		$svg = simplexml_load_string($svg);

		if (get_option(shp_icon()->prefix . '-upload-remove-id')) {
			foreach ($svg as $key => $child) {
				$child = $this->removeXmlAttribute($child, 'id');
			}
		}

		if (get_option(shp_icon()->prefix . '-upload-remove-comments')) {
			unset($svg->{'comment'});

			foreach ($svg as $key => $child) {
				unset($child->{'comment'});
			}
		}

		if (get_option(shp_icon()->prefix . '-upload-remove-title')) {
			unset($svg->{'title'});
		}

		if (get_option(shp_icon()->prefix . '-upload-remove-desc')) {
			unset($svg->{'desc'});
		}

		if (get_option(shp_icon()->prefix . '-upload-remove-width')) {
			$search = $svg->attributes()['width'];
			if ($search) {
				unset($svg->attributes()['width']);
			}
		}

		if (get_option(shp_icon()->prefix . '-upload-remove-height')) {
			$search = $svg->attributes()['height'];
			if ($search) {
				unset($svg->attributes()['height']);
			}
		}

		$search = $svg->attributes()['viewBox'];
		if ($search) {
			if (get_option(shp_icon()->prefix . '-upload-remove-viewbox')) {
				unset($svg->attributes()['viewBox']);
			}
		} else {
			if (!get_option(shp_icon()->prefix . '-upload-remove-viewbox')) {
				if ($svg->attributes()['width'] && $svg->attributes()['height']) {
					$viewBox = '0 0 ' . str_replace('px', '', $svg->attributes()['width']) . ' ' . str_replace('px', '', $svg->attributes()['height']);
					$svg->addAttribute('viewBox', $viewBox);
				}
			}
		}

		$svg = $svg->asXml();
		if (get_option(shp_icon()->prefix . '-upload-remove-xml')) {
			$svg = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $svg);
		}
		return $svg;
	}

	public function removeXmlAttribute($xml, $attr)
	{
		if (!empty($attr)) {
			$search = $xml->attributes()[$attr];
			if ($search) {
				unset($xml->attributes()[$attr]);
			}

			foreach ($xml as $key => $child) {
				$child = $this->removeXmlAttribute($child, 'id');
			}

			return $xml;
		} else {
			return $xml;
		}
	}
}
