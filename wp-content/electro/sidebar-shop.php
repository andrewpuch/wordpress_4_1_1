<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Electro
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div id="sidebar" class="sidebar" role="complementary">
<?php
	if ( is_active_sidebar( 'shop-sidebar-widgets' ) ) {

		dynamic_sidebar( 'shop-sidebar-widgets' );

	} else {

		do_action( 'electro_default_shop_sidebar_widgets' );
	}
?>
</div><!-- /.sidebar-shop -->