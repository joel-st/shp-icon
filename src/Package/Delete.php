<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Delete functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 * @since 1.0.0
 */
class Delete {

	public $delete_nonce_action = '';
	public $delete_nonce_name   = '';
	public $action              = '';

	public function __construct() {
		$this->delete_nonce_action = shp_icon()->prefix . '-delete';
		$this->delete_nonce_name   = shp_icon()->prefix . '-delete-nonce';
		$this->action              = str_replace( '-', '_', shp_icon()->prefix . '-delete' );
	}

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		add_action( 'wp_ajax_' . $this->action, array( $this, 'delete' ) );
		add_action( 'wp_ajax_nopriv_' . $this->action, array( $this, 'delete' ) );
	}

	/**
	 * Delete icon function called by ajax
	 *
	 * @since 1.0.0
	 */
	public function delete() {

		if ( ! isset( $_POST['file_name'] ) && ! sanitize_file_name( $file_name ) ) {
			header( 'HTTP/1.1 404 Bad Request' );
			header( 'Content-type: application/json' );
			die( json_encode( array( 'message' => _x( 'No filename provided', 'Delete without filename', 'shp-icon' ) ) ) );
		}

		$file_name = sanitize_file_name( $_POST['file_name'] );

		if ( ! file_exists( shp_icon()->upload_dir . '/' . $file_name ) ) {
			header( 'HTTP/1.1 404 Icon not found' );
			header( 'Content-type: application/json' );
			die( json_encode( array( 'message' => _x( 'Icon not found', 'Delete no icon found', 'shp-icon' ) ) ) );
		}

		if ( unlink( shp_icon()->upload_dir . '/' . $file_name ) ) {
			header( 'HTTP/1.1 200 Deleted' );
			header( 'Content-type: application/json' );
			exit(
				json_encode(
					array(
						'deleted'  => true,
						'name'     => shp_icon()->Package->Helpers->getIconNameFromFileName( $file_name ),
						'fileName' => $file_name,
					)
				)
			);
		} else {
			header( 'HTTP/1.1 500 Internal Server Error' );
			header( 'Content-type: application/json' );
			die( json_encode( array( 'message' => _x( 'Deletion failed', 'Delete icon failed', 'shp-icon' ) ) ) );
		}
	}
}
