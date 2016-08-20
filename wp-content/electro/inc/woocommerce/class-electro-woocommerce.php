<?php
/**
 * Electro WooCommerce Class
 *
 * @package  electro
 * @author   Transvelo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Electro_WooCommerce' ) ) :

	/**
	 * The Electro WooCommerce Integration class
	 */
	class Electro_WooCommerce {
		
		/**
		 * Setup class.
		 *
		 */
		public function __construct() {
			
			add_filter( 'woocommerce_output_related_products_args', 			array( $this, 'modify_linked_product_args' ) );
			add_filter( 'woocommerce_upsell_display_args', 						array( $this, 'modify_linked_product_args' ) );
			add_filter( 'woocommerce_product_description_heading',				array( $this, 'hide_tab_heading' ) );
			add_filter( 'woocommerce_product_additional_information_heading', 	array( $this, 'hide_tab_heading' ) );
			add_filter( 'woocommerce_product_tabs',								array( $this, 'modify_product_tabs' ) );
			add_filter( 'comments_template', 									array( $this, 'comments_template_loader' ), 20 );
			add_filter( 'get_terms_orderby',									array( $this, 'orderby_slug_order' ), 10, 2 );
			add_action( 'wp_enqueue_scripts', 									array( $this, 'woocommerce_scripts' ),	20 );
		}

		public function orderby_slug_order( $orderby, $args ) {
			if ( isset( $args['orderby'] ) && 'include' == $args['orderby'] ) {
				$include = implode( ',', array_map( 'sanitize_text_field', $args['include'] ) );
				$orderby = "FIELD( t.slug, $include )";
			}

			return $orderby;
		}

		public function comments_template_loader( $template ) {

			if ( get_post_type() !== 'product' || ! apply_filters( 'electro_use_advanced_reviews', true ) ) {
				return $template;
			}

			$check_dirs = array(
				trailingslashit( get_stylesheet_directory() ) . 'templates/shop/',
				trailingslashit( get_template_directory() ) . 'templates/shop/',
				trailingslashit( get_stylesheet_directory() ) . WC()->template_path(),
				trailingslashit( get_template_directory() ) . WC()->template_path(),
				trailingslashit( get_stylesheet_directory() ),
				trailingslashit( get_template_directory() ),
				trailingslashit( WC()->plugin_path() ) . 'templates/'
			);
			
			if ( WC_TEMPLATE_DEBUG_MODE ) {
				$check_dirs = array( array_pop( $check_dirs ) );
			}
			
			foreach ( $check_dirs as $dir ) {
				if ( file_exists( trailingslashit( $dir ) . 'single-product-advanced-reviews.php' ) ) {
					return trailingslashit( $dir ) . 'single-product-advanced-reviews.php';
				}
			}
		}

		public function modify_product_tabs( $tabs ) {
			
			global $product, $post;

			if ( isset( $tabs['description'] ) ) {
				$tabs['description']['callback'] = 'electro_product_description_tab';
			}

			if ( isset( $tabs['reviews'] ) ) {
				$tabs['reviews']['title'] = esc_html__( 'Reviews', 'electro' );
			}

			if ( isset( $tabs['additional_information'] ) ) {
				$tabs['additional_information']['title'] = esc_html__( 'Specification', 'electro' );
			}

			if ( isset( $tabs['additional_information'] ) ) {
				unset( $tabs['additional_information'] );
			}

			// Specification tab - shows attributes
			if ( $product && ( !empty( $product->specifications ) || ( $product->specifications_display_attributes && ( $product->has_attributes() || ( $product->enable_dimensions_display() && ( $product->has_dimensions() || $product->has_weight() ) ) ) ) ) ) {
				$tabs['specification'] = array(
					'title'    => esc_html__( 'Specification', 'electro' ),
					'priority' => 20,
					'callback' => 'electro_product_specification_tab'
				);
			}

			$accessories = Electro_WC_Helper::get_accessories( $product );

			if ( sizeof( $accessories ) !== 0 && array_filter( $accessories ) && $product->is_type( array( 'simple', 'variable' ) ) ) {
				$tabs['accessories'] = array(
					'title'		=> esc_html__( 'Accessories', 'electro' ),
					'priority'	=> 5,
					'callback'	=> 'electro_product_accessories_tab',
				);
			}

			return $tabs;
		}

		public function hide_tab_heading( $heading ) {
			return '';
		}

		public function modify_linked_product_args( $args ) {

			if ( 'full-width' === electro_get_single_product_layout() ) {
				
				$args['columns'] 		= 5;
				$args['posts_per_page'] = 5;

			} else {

				$args['columns'] 		= 4;
				$args['posts_per_page'] = 4;

			}

			return $args;
		}

		public function woocommerce_scripts() {
			global $electro_version;
			
			wp_register_script( 'electro-sticky-payment', get_template_directory_uri() . '/assets/js/checkout.min.js', 'jquery', $electro_version, true );
			
			if ( is_checkout() && apply_filters( 'electro_sticky_order_review', true ) ) {
				wp_enqueue_script( 'waypoints-sticky-js',	get_template_directory_uri() . '/assets/js/waypoints-sticky.min.js', array( 'jquery' ), $electro_version, true );
				wp_enqueue_script( 'electro-sticky-payment' );
			}
		}
	}

endif;

return new Electro_WooCommerce();