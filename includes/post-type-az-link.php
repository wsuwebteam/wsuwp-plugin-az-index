<?php namespace WSUWP\Plugin\AZ_Index;

class PostTypeAZLink {

	private static $slug = 'az_link';

	private static $attributes = array(
		'labels'        => array(
			'name'               => 'A-Z Index',
			'singular_name'      => 'Link',
			'all_items'          => 'All Links',
			'view_item'          => 'View Link',
			'add_new_item'       => 'Add New Link',
			'add_new'            => 'Add New',
			'edit_item'          => 'Edit Link',
			'update_item'        => 'Update Link',
			'search_items'       => 'Search A-Z Index',
			'not_found'          => 'Not found',
			'not_found_in_trash' => 'Not found in Trash',
		),
		'description'   => 'A-Z Index links',
		'hierarchical'  => false,
		'show_ui'       => true,
		'show_in_rest'  => true,
		'menu_icon'     => 'dashicons-index-card',
		'supports'      => array(
			'title',
			'editor',
			'author',
			'revisions',
			'custom-fields',
		),
		'template'      => array(
			array(
				'wsuwp/az-link',
				array(),
			),
		),
		'template_lock' => 'all',
		'rewrite'       => 'az_link',
	);


	public static function get( $name ) {

		switch ( $name ) {

			case 'post_type':
				return self::$slug;
			default:
				return '';

		}

	}


	public static function register_post_type() {

		register_post_type( self::$slug, self::$attributes );

		// register meta fields
		$meta_fields = array(
			'wsuwp_az_link_url',
			'wsuwp_az_link_keywords',
		);

		foreach ( $meta_fields as $meta_field ) {
			register_post_meta(
				'az_link',
				$meta_field,
				array(
					'type'          => 'string',
					'show_in_rest'  => true,
					'single'        => true,
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}

	}


	public static function init() {

		add_action( 'init', __CLASS__ . '::register_post_type' );

	}
}

PostTypeAZLink::init();
