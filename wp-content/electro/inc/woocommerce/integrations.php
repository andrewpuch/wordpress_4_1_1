<?php
/**
 * WooCommerce Extensions Integrations
 *
 * @package electro
 */

if ( is_yith_wcwl_activated() ) {

	global $yith_wcwl;

	function electro_add_to_wishlist_button() {
		echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}

	add_action( 'electro_single_product_action_buttons', 	'electro_add_to_wishlist_button' );
	add_action( 'electro_loop_action_buttons',				'electro_add_to_wishlist_button' );

	if( property_exists( $yith_wcwl, 'wcwl_init' ) ) {
		remove_action( 'wp_enqueue_scripts', array( $yith_wcwl->wcwl_init, 'enqueue_styles_and_stuffs' ) );
	}

	if( ! function_exists( 'electro_get_wishlist_page_id' ) ){
		/**
		 * Gets the page ID of wishlist page
		 * 
		 * @return int
		 */
		function electro_get_wishlist_page_id() {
			$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
			return $wishlist_page_id;
		}
	}

	if( ! function_exists( 'electro_is_wishlist_page' ) ) {
		/**
		 * Conditional tag to determine if a page is a wishlist page or not
		 *
		 * @return boolean
		 */
		function electro_is_wishlist_page() {
			$wishlist_page_id = electro_get_wishlist_page_id();
			return is_page( $wishlist_page_id );
		}
	}

	if( ! function_exists( 'electro_get_wishlist_url') ) {
		/**
		 * Returns URL of wishlist page
		 *
		 * @return string
		 */
		function electro_get_wishlist_url(){
			$wishlist_page_id = electro_get_wishlist_page_id();
			return get_permalink( $wishlist_page_id );
		}
	}

	if( ! function_exists( 'electro_header_wishlist_link' ) ) {
		function electro_header_wishlist_link() {
			?>
			<div class="wishlist">
				<a id="yith-wishlist-link" href="<?php echo esc_url( electro_get_wishlist_url() ); ?>">
					<i class="fa fa-heart"></i> 
					<?php echo __( 'Wishlist', 'electro' ); ?> 
					<span id="top-cart-wishlist-count" class="value">(<?php echo yith_wcwl_count_products(); ?>)</span> 
				</a>
			</div><!-- /.wishlist -->
			<?php
		}
	}
}

if( is_yith_woocompare_activated() ) {

	global $yith_woocompare;

	remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj , 'add_compare_link' ), 35 );

	function electro_add_compare_url_to_localize_data( $data ) {
		$data[ 'compare_page_url' ] = electro_get_compare_page_url();
		return $data;
	}

	add_filter( 'electro_localize_script_data', 'electro_add_compare_url_to_localize_data' );

	function electro_add_to_compare_link() {
		
		global $product, $yith_woocompare;
        $product_id = isset( $product->id ) ? $product->id : 0;

        $button_text = get_option( 'yith_woocompare_button_text', __( 'Compare', 'electro' ) );
        $button_text = function_exists( 'icl_translate' ) ? icl_translate( 'Plugins', 'plugin_yit_compare_button_text', $button_text ) : $button_text;

        if( ! is_admin() ) {
        	echo apply_filters( 'electro_add_to_compare_link', sprintf( 
				'<a href="%s" class="%s" data-product_id="%d">%s</a>', 
				$yith_woocompare->obj->add_product_url( $product_id ),
				'add-to-compare-link',
				$product_id,
				$button_text
			) );
        }
	}

	add_action( 'electro_single_product_action_buttons', 	'electro_add_to_compare_link', 20 );
	add_action( 'electro_loop_action_buttons', 				'electro_add_to_compare_link', 20 );
	
	function electro_update_yith_compare_options( $options ) {
		
		foreach( $options['general'] as $key => $option ) {
			
			if( $option['id'] == 'yith_woocompare_auto_open' ) {
				$options['general'][$key]['std'] = 'no';
				$options['general'][$key]['default'] = 'no';
			}
		
		}
		
		return $options;
	}
	
	add_filter( 'yith_woocompare_tab_options', 'electro_update_yith_compare_options' );

	if( ! function_exists( 'electro_get_compare_page_id' ) ) {
		/**
		 * Gets page ID of product comparision page
		 *
		 * @return int
		 */
		function electro_get_compare_page_id() {
			$compare_page_id = apply_filters( 'electro_product_comparison_page_id', 0 );
			
			if( 0 !== $compare_page_id && function_exists( 'icl_object_id' ) ) {
				$compare_page_id = icl_object_id( $compare_page_id, 'page' );
			}

			return $compare_page_id;
		}
	}

	if( ! function_exists( 'electro_get_compare_page_url' ) ) {
		/**
		 * Returns URL of Product Comparision Page
		 *
		 * @return string
		 */
		function electro_get_compare_page_url() {
			$compare_page_id = electro_get_compare_page_id();
			$compare_page_url = '#';

			if( 0 !== $compare_page_id ) {
				$compare_page_url = get_permalink( $compare_page_id );
			}

			return $compare_page_url;
		}
	}

	if( ! function_exists( 'electro_header_compare_link' ) ) {
		function electro_header_compare_link() {
			global $yith_woocompare;
			?>
			<div class="compare">
	            <a id="yith-woocompare-link" href="<?php echo esc_url( electro_get_compare_page_url() ); ?>" class="compare">
	                <i class="fa fa-exchange"></i>
	                <?php echo __( 'Compare', 'electro' ); ?>
	                <span id="top-cart-compare-count" class="value">(<?php echo count( $yith_woocompare->obj->products_list ); ?>)</span>
	            </a>
	        </div><!-- /.compare -->
			<?php
		}
	}
}

if ( is_yith_wcan_activated() ) {
	add_action( 'woocommerce_before_shop_loop', 'electro_wcan_wrap_start', 10 );
	add_action( 'woocommerce_after_shop_loop', 'electro_wcan_wrap_end', 91 );

	function electro_wcan_wrap_start() {
		?><div class="wcan-products-container"><?php
	}

	function electro_wcan_wrap_end() {
		?></div><!-- /.wcan-products-container --><?php
	}
}