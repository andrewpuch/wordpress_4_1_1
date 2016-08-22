<?php
/**
 * Mini Cart
 *
 * Contains the markup for mini-cart used in header
 *
 * @package electro
 */

if( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$cart_subtotal = WC()->cart->subtotal;

if( is_woocommerce_activated() && electro_get_shop_catalog_mode() == false ) : ?>

<ul class="navbar-mini-cart navbar-nav animate-dropdown nav pull-right flip">
	<li class="nav-item dropdown">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="nav-link" data-toggle="dropdown">
			<i class="ec ec-shopping-bag"></i>
			<span class="cart-items-count count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
			<span class="cart-items-total-price total-price"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
		</a>
		<ul class="dropdown-menu dropdown-menu-mini-cart">
			<li>
				<div class="widget_shopping_cart_content">
				  <?php woocommerce_mini_cart();?>
				</div>
			</li>
		</ul>
	</li>
</ul>

<?php endif; ?>
