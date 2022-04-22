<?php namespace WSUWP\Plugin\AZ_Index;

class Scripts {

	public static function register_block_editor_assets() {

		$editor_asset = include Plugin::get( 'dir' ) . 'assets/dist/az-index-editor.asset.php';

		wp_register_script(
			'wsuwp-plugin-az-index-editor-scripts',
			Plugin::get( 'url' ) . 'assets/dist/az-index-editor.js',
			$editor_asset['dependencies'],
			$editor_asset['version']
		);

		wp_register_style(
			'wsuwp-plugin-az-index-editor-styles',
			Plugin::get( 'url' ) . 'assets/dist/az-index-editor.css',
			array(),
			$editor_asset['version']
		);

	}

	public static function init() {

		add_action( 'init', __CLASS__ . '::register_block_editor_assets' );

	}
}

Scripts::init();
