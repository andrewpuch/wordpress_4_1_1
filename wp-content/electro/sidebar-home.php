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
	if ( is_active_sidebar( 'home-sidebar-widgets' ) ) {

		dynamic_sidebar( 'home-sidebar-widgets' );

	} else {

		do_action( 'electro_default_home_sidebar_widgets' );
	}
?>
</div><!-- /.sidebar-home -->