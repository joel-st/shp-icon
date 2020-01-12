<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Delete functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Delete
{

	public $delete_nonce_action = '';
	public $delete_nonce_name = '';
	public $action = '';

	public function __construct()
	{
		$this->delete_nonce_action = shp_icon()->prefix . '-delete';
		$this->delete_nonce_name = shp_icon()->prefix . '-delete-nonce';
		$this->action = str_replace('-', '_', shp_icon()->prefix . '-delete');
	}

	public function run()
	{
		add_action('wp_ajax_' . $this->action, [$this, 'delete']);
		add_action('wp_ajax_nopriv_' . $this->action, [$this, 'delete']);
	}

	public function delete()
	{

		if (!isset($_POST['file_name'])) {
			header('HTTP/1.1 404 Bad Request');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('No filename provided', 'Delete without filename', 'shp-icon')]));
		}

		if (!file_exists(shp_icon()->upload_dir . '/' . $_POST['file_name'])) {
			header('HTTP/1.1 404 Icon not found');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('Icon not found', 'Delete no icon found', 'shp-icon')]));
		}

		if (unlink(shp_icon()->upload_dir . '/' . $_POST['file_name'])) {
			header('HTTP/1.1 200 Deleted');
			header('Content-type: application/json');
			exit(json_encode([
				'deleted' => true,
				'name' => ucwords(shp_icon()->Package->Icon->getIconNameFromFileName($_POST['file_name'])),
				'fileName' => $_POST['file_name'],
			]));
		} else {
			header('HTTP/1.1 500 Internal Server Error');
			header('Content-type: application/json');
			die(json_encode(['message' => _x('Deletion failed', 'Delete icon failed', 'shp-icon')]));
		}
	}
}
