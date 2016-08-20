<?php
/**
 * Electro Products Class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Electro_Products class
 */
class Electro_Products {

	private static function product_query( $query_args, $atts, $loop_name ) {
		return new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );
	}

	/**
	 * List products in a category shortcode.
	 *
	 * @param array $atts
	 * @return string
	 */
	public static function product_category( $atts ) {
		$atts = shortcode_atts( array(
			'per_page' => '12',
			'columns'  => '4',
			'orderby'  => 'title',
			'order'    => 'desc',
			'category' => '',  // Slugs
			'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
		), $atts );

		if ( ! $atts['category'] ) {
			return '';
		}

		// Default ordering args
		$ordering_args = WC()->query->get_catalog_ordering_args( $atts['orderby'], $atts['order'] );
		$meta_query    = WC()->query->get_meta_query();
		$query_args    = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => $ordering_args['orderby'],
			'order'               => $ordering_args['order'],
			'posts_per_page'      => $atts['per_page'],
			'meta_query'          => $meta_query
		);
		
		$query_args = self::_maybe_add_category_args( $query_args, $atts['category'], $atts['operator'] );
		
		if ( isset( $ordering_args['meta_key'] ) ) {
			$query_args['meta_key'] = $ordering_args['meta_key'];
		}
		
		$return = self::product_query( $query_args, $atts, 'product_cat' );
		
		// Remove ordering query arguments
		WC()->query->remove_ordering_args();
		
		return $return;
	}

	/**
	 * List of Recent Products
	 *
	 * @param array $atts
	 * @return string
	 */
	public static function recent_products( $atts ) {
		$atts = shortcode_atts( array(
			'per_page' => '12',
			'columns'  => '4',
			'orderby'  => 'date',
			'order'    => 'desc',
			'category' => '',  // Slugs
			'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
		), $atts );
		
		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $atts['per_page'],
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'meta_query'          => WC()->query->get_meta_query()
		);
		
		$query_args = self::_maybe_add_category_args( $query_args, $atts['category'], $atts['operator'] );
		
		return self::product_query( $query_args, $atts, 'recent_products' );
	}

	/**
	 * List multiple products shortcode.
	 *
	 * @param array $atts
	 * @return string
	 */
	public static function products( $atts ) {
		$atts = shortcode_atts( array(
			'columns' => '4',
			'orderby' => 'post__in',
			'order'   => 'asc',
			'ids'     => '',
			'skus'    => ''
		), $atts );
		
		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'posts_per_page'      => -1,
			'meta_query'          => WC()->query->get_meta_query()
		);
		
		if ( ! empty( $atts['skus'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_sku',
				'value'   => array_map( 'trim', explode( ',', $atts['skus'] ) ),
				'compare' => 'IN'
			);
		}
		
		if ( ! empty( $atts['ids'] ) ) {
			$query_args['post__in'] = array_map( 'trim', explode( ',', $atts['ids'] ) );
		}
		
		return self::product_query( $query_args, $atts, 'products' );
	}

	/**
	 * List all products on sale.
	 *
	 * @param array $atts
	 * @return string
	 */
	public static function sale_products( $atts ) {
		$atts = shortcode_atts( array(
			'per_page' 	=> '12',
			'columns'  	=> '4',
			'orderby'  	=> 'title',
			'order'    	=> 'asc',
			'post__in'	=> ''
		), $atts );

		$post_in = wc_get_product_ids_on_sale();

		if ( !empty( $atts['post__in'] ) ) {
			$atts['post__in'] = is_array( $atts['post__in'] ) ? $atts['post__in'] : array( $atts['post__in'] );
			$atts['post__in'] = array_map( 'trim', $atts['post__in'] );
			$post_in = array_intersect( $post_in, $atts['post__in'] );
		}
		
		$query_args = array(
			'posts_per_page' => $atts['per_page'],
			'orderby'        => $atts['orderby'],
			'order'          => $atts['order'],
			'no_found_rows'  => 1,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'meta_query'     => WC()->query->get_meta_query(),
			'post__in'       => array_merge( array( 0 ),  $post_in )
		);
		
		return self::product_query( $query_args, $atts, 'sale_products' );
	}

	/**
	 * List best selling products on sale.
	 *
	 * @param array $atts
	 * @return string
	 */
	public static function best_selling_products( $atts ) {
		$atts = shortcode_atts( array(
			'per_page' => '12',
			'columns'  => '4',
			'category' => '',  // Slugs
			'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
		), $atts );
		
		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $atts['per_page'],
			'meta_key'            => 'total_sales',
			'orderby'             => 'meta_value_num',
			'meta_query'          => WC()->query->get_meta_query()
		);
		
		$query_args = self::_maybe_add_category_args( $query_args, $atts['category'], $atts['operator'] );
		
		return self::product_query( $query_args, $atts, 'best_selling_products' );
	}
	/**
	 * List top rated products on sale.
	 *
	 * @param array $atts
	 * @return string
	 */
	public static function top_rated_products( $atts ) {
		$atts = shortcode_atts( array(
			'per_page' => '12',
			'columns'  => '4',
			'orderby'  => 'title',
			'order'    => 'asc',
			'category' => '',  // Slugs
			'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
		), $atts );
		
		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'posts_per_page'      => $atts['per_page'],
			'meta_query'          => WC()->query->get_meta_query()
		);
		
		$query_args = self::_maybe_add_category_args( $query_args, $atts['category'], $atts['operator'] );
		
		ob_start();
		
		add_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
		
		$return = self::product_query( $query_args, $atts, 'top_rated_products' );
		
		remove_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
		
		return $return;
	}
	/**
	 * Output featured products.
	 *
	 * @param array $atts
	 * @return string
	 */
	public static function featured_products( $atts ) {
		$atts = shortcode_atts( array(
			'per_page' => '12',
			'columns'  => '4',
			'orderby'  => 'date',
			'order'    => 'desc',
			'category' => '',  // Slugs
			'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
		), $atts );
		
		$meta_query   = WC()->query->get_meta_query();
		$meta_query[] = array(
			'key'   => '_featured',
			'value' => 'yes'
		);
		
		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $atts['per_page'],
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'meta_query'          => $meta_query
		);
		
		$query_args = self::_maybe_add_category_args( $query_args, $atts['category'], $atts['operator'] );
		
		return self::product_query( $query_args, $atts, 'featured_products' );
	}

	/**
	 * woocommerce_order_by_rating_post_clauses function.
	 *
	 * @param array $args
	 * @return array
	 */
	public static function order_by_rating_post_clauses( $args ) {
		global $wpdb;
		
		$args['where']   .= " AND $wpdb->commentmeta.meta_key = 'rating' ";
		$args['join']    .= "LEFT JOIN $wpdb->comments ON($wpdb->posts.ID               = $wpdb->comments.comment_post_ID) LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)";
		$args['orderby'] = "$wpdb->commentmeta.meta_value DESC";
		$args['groupby'] = "$wpdb->posts.ID";
		
		return $args;
	}

	/**
	 * List products with an attribute shortcode.
	 * Example [product_attribute attribute='color' filter='black'].
	 *
	 * @param array $atts
	 * @return string
	 */
	public static function product_attribute( $atts ) {
		$atts = shortcode_atts( array(
			'per_page'  => '12',
			'columns'   => '4',
			'orderby'   => 'title',
			'order'     => 'asc',
			'attribute' => '',
			'filter'    => ''
		), $atts );
		
		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $atts['per_page'],
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'meta_query'          => WC()->query->get_meta_query(),
			'tax_query'           => array(
				array(
					'taxonomy' => strstr( $atts['attribute'], 'pa_' ) ? sanitize_title( $atts['attribute'] ) : 'pa_' . sanitize_title( $atts['attribute'] ),
					'terms'    => array_map( 'sanitize_title', explode( ',', $atts['filter'] ) ),
					'field'    => 'slug'
				)
			)
		);
		
		return self::product_query( $query_args, $atts, 'product_attribute' );
	}

	/**
	 * Adds a tax_query index to the query to filter by category.
	 *
	 * @param array $args
	 * @param string $category
	 * @param string $operator
	 * @return array;
	 * @access private
	 */
	private static function _maybe_add_category_args( $args, $category, $operator ) {
		if ( ! empty( $category ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'terms'    => array_map( 'sanitize_title', explode( ',', $category ) ),
					'field'    => 'slug',
					'operator' => $operator
				)
			);
		}
		
		return $args;
	}
}