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

$classes[] = 'list-view';

?>
<li <?php post_class( $classes ); ?>>
	<?php
		/**
		 * electro_wc_before_list_view_shop_loop_item hook
		 * 
		 */
		do_action( 'electro_wc_before_list_view_shop_loop_item' );
	?>
	<div class="media">
		<div class="media-left">
			<?php
				/**
				 * electro_wc_before_list_view_shop_loop_item_title hook
				 * 
				 * @hooked woocommerce_template_loop_product_link_open - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 20
				 * @hooked woocommerce_template_loop_product_link_close - 30
				 */
				do_action( 'electro_wc_before_list_view_shop_loop_item_title' );
			?>
		</div>
		<div class="media-body media-middle">
			<div class="row">
				<div class="col-xs-12">
					<?php
						/**
						 * electro_wc_list_view_shop_loop_item_title hook
						 * 
						 * @hooked electro_template_loop_categories - 10
						 * @hooked woocommerce_template_loop_product_link_open - 20
						 * @hooked woocommerce_template_loop_product_title - 30
						 * @hooked electro_template_loop_rating - 40
						 * @hooked electro_template_loop_product_excerpt - 50
						 * @hooked woocommerce_template_loop_product_link_close - 65
						 */
						do_action( 'electro_wc_list_view_shop_loop_item_title' );
					?>
				</div>
				<div class="col-xs-12">
					<?php
						/**
						 * electro_wc_after_list_view_shop_loop_item_title hook 
						 * 
						 * @hooked electro_template_loop_availability - 10
						 * @hooked woocommerce_template_loop_price - 20
						 * @hooked woocommerce_template_loop_add_to_cart - 30
						 * @hooked electro_template_loop_hover - 40
						 */
						do_action( 'electro_wc_after_list_view_shop_loop_item_title' );
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
		/**
		 * electro_wc_after_list_view_shop_loop_item hook
		 */
		do_action( 'electro_wc_after_list_view_shop_loop_item' ); 
	?>
</li>