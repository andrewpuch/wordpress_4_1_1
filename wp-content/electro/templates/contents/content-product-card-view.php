<?php
/**
 * Product Card View
 *
 * @package Electro/WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = 4;
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Extra post classes
$classes = array();

if ( ! function_exists( 'wc_get_loop_class' ) ) {
	// Increase loop count
	$woocommerce_loop['loop']++;

	if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
		$classes[] = 'first';
	}
	if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
		$classes[] = 'last';
	}
}

$classes[] = 'product-card';

?>
<li <?php post_class( $classes ); ?>>
	
	<?php  
	/**
	 * @hooked electro_wrap_product_outer - 10
	 */
	do_action( 'electro_before_card_view' ); ?>
	
	<div class="media product-inner">
		
		<?php 
		/**
		 * @hooked electro_product_media_object - 10
		 */
		do_action( 'electro_before_product_card_view_body' ); ?>

		<div class="media-body">
			<?php 
			/**
			 * @hooked electro_template_loop_categories - 10
			 * @hooked woocommerce_template_loop_product_link_open - 20
			 * @hooked woocommerce_template_loop_product_title - 30
			 * @hooked woocommerce_template_loop_product_link_close - 40
			 * @hooked electro_wrap_price_and_add_to_cart - 50
			 * @hooked woocommerce_template_loop_price - 60
			 * @hooked woocommerce_template_loop_add_to_cart - 70
			 * @hooked electro_wrap_price_and_add_to_cart_close - 80
			 */
			do_action( 'electro_product_card_view_body' ); ?>
		</div>
	</div>
	
	<?php 
	/**
	 * @hooked electro_wrap_product_outer_close - 10
	 */
	do_action( 'electro_after_card_view' ); ?>

</li>