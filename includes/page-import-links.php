<?php namespace WSUWP\Plugin\AZ_Index;

class Page_Import_Links {

	private static $links_to_import = array();
	private static $column_headers  = array(
		'linkTitle',
		'linkURL',
		'keywords',
		'creatorName',
		'creatorUsername',
		'creatorEmail',
		'altContactName',
		'altContactEmail',
		'dateCreated',
		'dateModified',
	);


	public static function add_tools_page() {

		if ( is_super_admin() ) {
			add_management_page(
				'Import A-Z Index Links',
				'Import A-Z Index Links',
				'manage_options',
				'import-az-index-links',
				__CLASS__ . '::page_content'
			);
		}

	}


	private static function get_links_from_csv( $file ) {

		$links = array();

		$name     = $file['name'];
		$ext      = strtolower( end( explode( '.', $file['name'] ) ) );
		$type     = $file['type'];
		$tmp_name = $file['tmp_name'];

		// check the file is a csv
		if ( 'csv' === $ext ) {
			$data           = array();
			$column_headers = self::$column_headers;

			// read file
			$fp = fopen( $tmp_name, 'rb' );
			while ( ! feof( $fp ) ) {
				$data[] = fgetcsv( $fp );
			}
			fclose( $fp );

			// map column labels to keys
			if ( isset( $_POST['has_headers'] ) ) {
				array_shift( $data );
			}
			array_walk(
				$data,
				function ( &$row, $key, $column_headers ) {
					if ( $row ) {
						$row = array_combine( $column_headers, $row );
					}
				},
				$column_headers
			);

			$links = $data;
		}

		return $links;

	}


	private static function import_links( $links ) {

		$fallback_user    = get_user_by( 'slug', 'wsu.support' );
		$fallback_user_id = isset( $fallback_user->ID ) ? $fallback_user->ID : 0;

		foreach ( $links as $link ) {
			if ( ! $link ) {
				continue;
			}

			$user = get_user_by( 'slug', trim( $link['creatorUsername'] ) );

			$post_data = array(
				'ID'            => 0,
				'post_title'    => $link['linkTitle'],
				'post_status'   => 'publish',
				'post_author'   => isset( $user->ID ) ? $user->ID : $fallback_user_id,
				'post_type'     => 'az_link',
				'post_date'     => gmdate( 'Y-m-d H:i:s', strtotime( $link['dateCreated'] ) ),
				'post_modified' => gmdate( 'Y-m-d H:i:s', strtotime( $link['dateModified'] ) ),
				'post_content'  => '<!-- wp:wsuwp/az-link {"alt_contact_name":"' . $link['altContactName'] . '","alt_contact_email":"' . $link['altContactEmail'] . '"} /-->',
				'meta_input'    => array(
					'wsuwp_az_link_url'      => $link['linkURL'],
					'wsuwp_az_link_keywords' => $link['keywords'],
				),
			);

			wp_insert_post( $post_data );
		}

	}


	private static function handle_form_submission() {

		if ( isset( $_FILES['csvFile'] ) && isset( $_FILES['csvFile']['error'] ) && $_FILES['csvFile']['error'] == 0 ) {
			$file = $_FILES['csvFile'];

			// prevent timeouts
			ignore_user_abort( 1 );
			set_time_limit( 0 );

			// parse and import links
			self::$links_to_import = self::get_links_from_csv( $file );
			self::import_links( self::$links_to_import );
		}

	}


	public static function page_content() {

		if ( isset( $_POST['az_import_form'] ) && check_admin_referer( 'az_importer_nonce' ) ) {
			self::handle_form_submission();
		}

		$links_to_import = self::$links_to_import;

		include Plugin::get( 'template_dir' ) . '/page-az-import-links.php';

	}


	public static function init() {

		add_action( 'admin_menu', __CLASS__ . '::add_tools_page' );

	}
}

Page_Import_Links::init();
