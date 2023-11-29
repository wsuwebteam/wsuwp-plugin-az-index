<?php namespace WSUWP\Plugin\AZ_Index;

class BlockAZLink {

	public static function register_block() {

		register_block_type(
			'wsuwp/az-link',
			array(
				'api_version'   => 2,
				'editor_script' => 'wsuwp-plugin-az-index-editor-scripts',
				'editor_style'  => 'wsuwp-plugin-az-index-editor-styles',
			)
		);

	}


	public static function init() {

		add_action( 'init', __CLASS__ . '::register_block' );

	}

}

BlockAZLink::init();
