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
	if ( is_active_sidebar( 'store-sidebar-widgets' ) ) {

		dynamic_sidebar( 'store-sidebar-widgets' );

	} else {

		do_action( 'electro_default_store_sidebar_widgets' );
	}
?>
</div><!-- /.sidebar-store -->