<?php
/**
 * Product Card View
 *
 * @package Electro/WooCommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>
<div class="onsale-product">
	
	<?php 
	/**
	 * 
	 */
	do_action( 'electro_onsale_product_content', $product ); ?>

</div>