<?php

namespace SayHello\Plugin\Icon\Plugin\Package;

/**
 * Handle Plugin Assets
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 * @since 1.0.0
 */
class Assets {


	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		add_action( 'init', array( $this, 'registerScripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'registerAssets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'registerAdminAssets' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'registerGutenbergAssets' ) );
	}

	/**
	 * Register scripts for the front end
	 * Register Gutenberg scripts here to be able to use i18n in Gutenberg JavaScript
	 * https://krautpress.de/2020/gutenberg-bloecke-uebersetzen/
	 *
	 * @since 1.0.0
	 */
	public function registerScripts() {
		if ( file_exists( shp_icon()->plugin_dir . '/assets/gutenberg/blocks.js' ) ) {
			$script_asset_path = shp_icon()->plugin_dir . '/assets/gutenberg/blocks.asset.php';
			$script_asset      = file_exists( $script_asset_path ) ? require( $script_asset_path ) : array(
				'dependencies' => array(),
				'version'      => shp_icon()->version,
			);
			wp_register_script(
				shp_icon()->prefix . '-gutenberg-script',
				shp_icon()->plugin_url . '/assets/gutenberg/blocks' . ( shp_icon()->debug ? '' : '.min' ) . '.js',
				$script_asset['dependencies'],
				$script_asset['version'],
				true
			);
		}

		wp_set_script_translations( shp_icon()->prefix . '-gutenberg-script', 'shp-icon', shp_icon()->plugin_dir . '/languages' );

		if ( file_exists( shp_icon()->plugin_dir . '/assets/scripts/admin.js' ) ) {
			wp_register_script(
				shp_icon()->prefix . '-admin-script',
				shp_icon()->plugin_url . '/assets/scripts/admin' . ( shp_icon()->debug ? '' : '.min' ) . '.js',
				array( 'jquery', 'wp-i18n' ),
				shp_icon()->version,
				true
			);
		}

		wp_set_script_translations( shp_icon()->prefix . '-admin-script', 'shp-icon', shp_icon()->plugin_dir . '/languages' );
	}

	/**
	 * Register assets for the front end
	 *
	 * @since 1.0.0
	 */
	public function registerAssets() {
		/**
		 * Javascript
		 */
		$deps = array();

		if ( file_exists( shp_icon()->plugin_dir . '/assets/scripts/ui.js' ) ) {
			wp_enqueue_script( shp_icon()->prefix . '-ui-script', shp_icon()->plugin_url . '/assets/scripts/ui' . ( shp_icon()->debug ? '' : '.min' ) . '.js', $deps, shp_icon()->version, true );
		}

		/**
		 * CSS
		 */
		if ( file_exists( shp_icon()->plugin_dir . '/assets/styles/ui.css' ) ) {
			wp_enqueue_style( shp_icon()->prefix . '-ui-style', shp_icon()->plugin_url . '/assets/styles/ui' . ( shp_icon()->debug ? '' : '.min' ) . '.css', array(), shp_icon()->version );
		}
	}

	/**
	 * Register assets for admin area
	 *
	 * @since 1.0.0
	 */
	public function registerAdminAssets( $hook_suffix ) {
		if ( 'appearance_page_' . shp_icon()->prefix === $hook_suffix ) {

			/**
			 * Javascript
			 */
			if ( file_exists( shp_icon()->plugin_dir . '/assets/scripts/admin.js' ) ) {
				wp_enqueue_script( shp_icon()->prefix . '-admin-script' );

				$data = array(
					'uploadUrl' => shp_icon()->upload_dir,
					'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
					'action'    => shp_icon()->Package->Upload->action,
					'ajaxNonce' => wp_create_nonce( shp_icon()->Package->Upload->upload_nonce_name ),
				);

				wp_localize_script( shp_icon()->prefix . '-admin-script', str_replace( '-', '_', shp_icon()->prefix . '-data' ), $data );
			}
		}

		/**
		 * CSS
		 */
		if ( file_exists( shp_icon()->plugin_dir . '/assets/styles/admin.css' ) ) {
			wp_enqueue_style( shp_icon()->prefix . '-admin-style', shp_icon()->plugin_url . '/assets/styles/admin' . ( shp_icon()->debug ? '' : '.min' ) . '.css', array(), shp_icon()->version );
		}
	}

	/**
	 * Register assets for gutenberg
	 *
	 * @since 1.0.0
	 */
	public function registerGutenbergAssets() {
		if ( file_exists( shp_icon()->plugin_dir . '/assets/gutenberg/blocks.js' ) ) {
			wp_enqueue_script( shp_icon()->prefix . '-gutenberg-script' );

			$data = array(
				'topShift'    => sanitize_text_field( get_option( shp_icon()->prefix . '-display-inline-top-shift' ) ),
				'scaleFactor' => sanitize_text_field( get_option( shp_icon()->prefix . '-display-inline-scale-factor' ) ),
			);

			wp_localize_script( shp_icon()->prefix . '-gutenberg-script', str_replace( '-', '_', shp_icon()->prefix . '-data' ), $data );
		}
	}
}
