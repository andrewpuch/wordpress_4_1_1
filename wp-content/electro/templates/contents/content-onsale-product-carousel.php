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
<div class="onsale-product-content">

	<?php
	/**
	 *
	 */
	do_action( 'electro_onsale_product_carousel_content', $product ); ?>

</div>
