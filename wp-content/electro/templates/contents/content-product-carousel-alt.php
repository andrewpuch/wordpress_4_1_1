<?php
/**
 * Product Carousel Alt
 *
 * @package Electro/WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>
<div class="product-carousel-alt">
	
	<?php 
	/**
	 * 
	 */
	do_action( 'electro_product_carousel_alt_content', $product ); ?>

</div>