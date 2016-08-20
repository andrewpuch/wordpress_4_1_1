<?php
/**
 * The template for displaying product list view content within loops
 *
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
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
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

?>
<li <?php post_class( $classes ); ?>>

	<?php
	/**
	 * woocommerce_before_grid_extended_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'electro_wc_before_grid_extended_shop_loop_item' );

	/**
	 * woocommerce_before_grid_extended_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'electro_wc_before_grid_extended_shop_loop_item_title' );

	/**
	 * woocommerce_grid_extended_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'electro_wc_grid_extended_shop_loop_item_title' );

	/**
	 * woocommerce_after_grid_extended_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'electro_wc_after_grid_extended_shop_loop_item_title' );

	/**
	 * woocommerce_after_grid_extended_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	do_action( 'electro_wc_after_grid_extended_shop_loop_item' );
	?>

</li>