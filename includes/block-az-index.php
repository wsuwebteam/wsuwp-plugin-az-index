<?php namespace WSUWP\Plugin\AZ_Index;

class BlockAZIndex {

	protected static $block_name    = 'wsuwp/az-index';
	protected static $default_attrs = array(
		'className'    => '',
		'headingLevel' => 'h2',
		'showAllLinks' => false,
	);


	public static function render( $attributes, $content ) {

		$attrs = array_merge( self::$default_attrs, $attributes );

		$link_groups     = array_merge( array( '0' ), range( 'A', 'Z' ) );
		$grouped_links   = self::get_grouped_links( $link_groups );
		$selected_letter = self::get_selected_letter( $link_groups, $grouped_links );

		ob_start();

		include Plugin::get( 'template_dir' ) . '/block-az-index.php';

		return ob_get_clean();

	}


	private static function render_link_group( $attrs, $label, $links ) {

		include Plugin::get( 'template_dir' ) . '/link-group.php';

	}


	private static function get_selected_letter( $link_groups, $grouped_links ) {

		$c = esc_attr( $_GET['c'] );

		if ( isset( $c ) && in_array( strtoupper( $c ), $link_groups, true ) ) {
			return self::get_group_label( strtoupper( $c ) );
		} else {
			$group = self::first_non_empty_group( $link_groups, $grouped_links );
			return self::get_group_label( $group );
		}

	}


	private static function get_group_label( $group ) {

		return '0' === $group ? '#' : $group;

	}


	private static function get_group_to_display( $link_groups, $grouped_links ) {

		$label = '';
		$links = array();

		if ( isset( $_GET['search'] ) ) {
			$search_term = esc_attr( $_GET['search'] );
			$label       = 'Search results for "' . $search_term . '"';
			$links       = self::search_az_posts( $search_term );
		} elseif ( isset( $_GET['c'] ) && in_array( strtoupper( $_GET['c'] ), $link_groups, true ) ) {
			$q     = esc_attr( $_GET['c'] );
			$label = self::get_group_label( strtoupper( $q ) );
			$links = isset( $grouped_links[ strtoupper( $q ) ] ) ? $grouped_links[ strtoupper( $q ) ] : array();
		} else {
			$group = self::first_non_empty_group( $link_groups, $grouped_links );
			$label = self::get_group_label( $group );
			$links = isset( $grouped_links[ $group ] ) ? $grouped_links[ $group ] : array();
		}

		return array(
			'label' => $label,
			'links' => $links,
		);

	}


	private static function first_non_empty_group( $link_groups, $grouped_links ) {

		foreach ( $link_groups as $group ) {
			if ( ! empty( $grouped_links[ $group ] ) ) {
				return $group;
			}
		}

		return null;

	}


	private static function get_grouped_links( $groups ) {

		$az_links = array();

		$args = array(
			'post_status'    => 'publish',
			'post_type'      => 'az_link',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		);

		$query = new \WP_Query( $args );

		while ( $query->have_posts() ) {
			$query->the_post();
			$letter               = strtoupper( get_the_title()[0] );
			$group                = in_array( $letter, $groups, true ) ? $letter : '0';
			$az_links[ $group ][] = self::map_to_az_link( $query->post );
		}

		wp_reset_postdata();

		return $az_links;

	}


	private static function search_az_posts( $term ) {

		$az_links = array();

		$args = array(
			'post_status'    => 'publish',
			'post_type'      => 'az_link',
			'_meta_or_title' => $term,
			'meta_query'     => array(
				'relation' => 'OR',
				array(
					'key'     => 'wsuwp_az_link_url',
					'value'   => $term,
					'compare' => 'LIKE',
				),
				array(
					'key'     => 'wsuwp_az_link_keywords',
					'value'   => $term,
					'compare' => 'LIKE',
				),
			),
		);

		$query = new \WP_Query( $args );

		while ( $query->have_posts() ) {
			$query->the_post();
			$az_links[] = self::map_to_az_link( $query->post );
		}

		wp_reset_postdata();

		return $az_links;

	}


	private static function map_to_az_link( $post ) {

		return array(
			'title' => $post->post_title,
			'url'   => get_post_meta( $post->ID, 'wsuwp_az_link_url', true ),
		);

	}


	public static function search_title_or_meta( $q ) {

		if ( $title = $q->get( '_meta_or_title' ) ) {
			add_filter(
				'get_meta_sql',
				function( $sql ) use ( $title ) {
					global $wpdb;

					// Only run once:
					static $nr = 0;
					if ( 0 != $nr++ ) {
						return $sql;
					}

					// Modify WHERE part:
					$sql['where'] = sprintf(
						' AND ( %s OR %s ) ',
						$wpdb->prepare( "{$wpdb->posts}.post_title = '%s'", $title ),
						mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
					);
					return $sql;
				}
			);
		}

	}


	public static function register_block() {

		register_block_type(
			self::$block_name,
			array(
				'render_callback' => array( __CLASS__, 'render' ),
				'api_version'     => 2,
				'editor_script'   => 'wsuwp-plugin-az-index-editor-scripts',
				'editor_style'    => 'wsuwp-plugin-az-index-editor-styles',
			)
		);

	}


	public static function init() {

		add_action( 'init', __CLASS__ . '::register_block' );
		add_filter( 'pre_get_posts', __CLASS__ . '::search_title_or_meta' );

	}
}

BlockAZIndex::init();
