<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

use enshrined\svgSanitize\Sanitizer;

/**
 * Upload functions
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 * @since 1.0.0
 */
class Upload {

	public string $upload_element_id   = '';
	public string $upload_input_id     = '';
	public string $upload_nonce_action = '';
	public string $upload_nonce_name   = '';
	public string $action              = '';

	public function __construct() {
		$this->upload_element_id   = shp_icon()->prefix . '-upload';
		$this->upload_input_id     = shp_icon()->prefix . '-upload-input';
		$this->upload_nonce_action = shp_icon()->prefix . '-upload';
		$this->upload_nonce_name   = shp_icon()->prefix . '-upload-nonce';
		$this->action              = str_replace( '-', '_', shp_icon()->prefix . '-upload' );
	}

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		add_action( 'wp_ajax_' . $this->action, array( $this, 'upload' ) );
		add_action( 'wp_ajax_nopriv_' . $this->action, array( $this, 'upload' ) );
		add_action( 'wp_ajax_shp_icon_push_icon', array( $this, 'pushIcon' ) );
		add_action( 'wp_ajax_nopriv_shp_icon_push_icon', array( $this, 'pushIcon' ) );
	}

	/**
	 * Render the upload input amd the nonce field
	 *
	 * @since 1.0.0
	 */
	public function renderUpload() {
		echo '<div id="' . esc_attr($this->upload_element_id) . '" class="' . esc_attr($this->upload_element_id) . '">';
		//echo '<form class="' . $this->upload_element_id . '__form" action="' . admin_url('admin-ajax.php') . '" method="post" enctype="multipart/form-data">';
		wp_nonce_field( $this->upload_nonce_action, $this->upload_nonce_name );
		echo '<input id="' . esc_attr($this->upload_input_id) . '" type="file" accept=".svg" multiple class="' . esc_attr($this->upload_element_id) . '__upload-input" style="visibility:hidden" />';
		//echo '</form>';
		echo '<div class="' . esc_attr($this->upload_element_id) . '__status">';
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Upload handler called by ajax on icon upload
	 *
	 * @since 1.0.0
	 */
	public function upload() {
		$upload_id = isset( $_POST['id'] ) ? sanitize_key( $_POST['id'] ) : false;

		if ( ! $upload_id ) {
			header( 'HTTP/1.1 400 Bad Request' );
			header( 'Content-type: application/json' );
			die(
				wp_json_encode(
					array(
						'message' => _x( 'No upload ID specified', 'Upload without id', 'shp-icon' ),
						'id'      => $upload_id,
					)
				)
			);
		}

		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], $this->upload_nonce_name ) ) {
			header( 'HTTP/1.1 406 Not Acceptable' );
			header( 'Content-type: application/json' );
			die(
				wp_json_encode(
					array(
						'message' => _x( 'No _wpnonce provided', 'Upload without nonce', 'shp-icon' ),
						'id'      => $upload_id,
					)
				)
			);
		}

		if ( ! isset( $_FILES ) || empty( $_FILES ) ) {
			header( 'HTTP/1.1 400 Bad Request' );
			header( 'Content-type: application/json' );
			die(
				wp_json_encode(
					array(
						'message' => _x( 'No files provided', 'Upload without files', 'shp-icon' ),
						'id'      => $upload_id,
					)
				)
			);
		}

		if ( sizeof( $_FILES ) !== 1 ) {
			header( 'HTTP/1.1 400 Bad Request' );
			header( 'Content-type: application/json' );
			die(
				wp_json_encode(
					array(
						'message' => _x( 'Invalid amount of files', 'Upload false amount of files', 'shp-icon' ),
						'id'      => $upload_id,
					)
				)
			);
		}

		$file = $_FILES['file'] ?? false;

		if ($file && is_array($file)) {
			$file_name     = !empty($file['name']) ? sanitize_file_name($file['name']) : false;
			$file_type     = !empty($file['type']) ? sanitize_mime_type($file['type']) : false;
			$file_tmp_name = !empty($file['tmp_name']) ? $file['tmp_name'] : false;
		} else {
			$file_name = $file_type = $file_tmp_name = false;
		}

		if (! $file || ! $file_name || ! $file_type || ! $file_tmp_name) {
			header('HTTP/1.1 400 Bad Request');
			header('Content-type: application/json');
			die(wp_json_encode(
				array(
					'message' => _x('Invalid file', 'Upload fals amount of files', 'shp-icon'),
					'id'      => $upload_id,
				)
			));
		}

		if ( strpos( $file_type, 'svg' ) === false ) {
			header( 'HTTP/1.1 400 Bad Request' );
			header( 'Content-type: application/json' );
			die(
				wp_json_encode(
					array(
						'message' => _x( 'Invalid file type', 'Upload fals amount of files', 'shp-icon' ),
						'id'      => $upload_id,
					)
				)
			);
		}

		$sanitised_svg = $this->sanitiseSvg( $file );

		if ( ! $sanitised_svg ) {
			header( 'HTTP/1.1 500 Internal Server Error' );
			header( 'Content-type: application/json' );
			die(
				wp_json_encode(
					array(
						'message' => _x( 'Sanitation failed', 'Upload sanitation failed', 'shp-icon' ),
						'id'      => $upload_id,
					)
				)
			);
		}

		$file_name = shp_icon()->Package->Helpers->createFileName( $file_name );

		add_filter( 'upload_dir', array( $this, 'uploadDirFilter' ) );    // disables the filter
		$upload = wp_upload_bits( $file_name, null, $sanitised_svg );
		remove_filter( 'upload_dir', array( $this, 'uploadDirFilter' ) ); // enables the filter

		header( 'HTTP/1.1 201 Created' );
		header( 'Content-type: application/json' );
		exit(
			wp_json_encode(
				array(
					'upload'   => $upload,
					'id'       => $upload_id,
					'name'     => shp_icon()->Package->Helpers->getIconNameFromFileName( basename( $upload['file'] ) ),
					'fileName' => basename( $upload['file'] ),
				)
			)
		);
	}

	/**
	 * Sanitizes a SVG file before it's saved to the server storage.
	 * This removes unallowed tags and scripts.
	 *
	 * @see enshrined\svgSanitize\Sanitizer
	 * @param array $file Uploaded file.
	 * @return array Cleaned file if type is SVG.
	 * @since 1.0.0
	 */
	public function sanitiseSvg( $file ) {
		if ( 'image/svg+xml' === $file['type'] ) {
			$sanitiser = new Sanitizer();
			$sanitiser->minify( true );

			$dirty_svg     = file_get_contents( $file['tmp_name'] );
			$sanitized_svg = $sanitiser->sanitize( $dirty_svg );

			global $wp_filesystem;
			$credentials = request_filesystem_credentials( esc_url( site_url() ) . '/wp-admin/', '', false, false, array() );
			if ( ! WP_Filesystem( $credentials ) ) {
				request_filesystem_credentials( esc_url( site_url() ) . '/wp-admin/', '', true, false, null );
			}

			return $sanitized_svg;
		} else {
			return false;
		}
	}

	/**
	 * Filter function to change upload directory to upload_dir of plugin
	 *
	 * @since 1.0.0
	 */
	public function uploadDirFilter( $args ) {
		$args['path']   = shp_icon()->upload_dir;
		$args['url']    = shp_icon()->upload_url;
		$args['subdir'] = '';

		return $args;
	}

	/**
	 * Function to add icon to admin icon list on icon upload called by ajax
	 *
	 * @since 1.0.0
	 */
	public function pushIcon() {
		shp_icon()->Package->OptionsPage->renderIcon( sanitize_text_field( $_POST['icon'] ), shp_icon()->prefix . '-list' );
		exit();
	}
}
