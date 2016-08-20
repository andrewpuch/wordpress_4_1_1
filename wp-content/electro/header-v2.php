<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package electro
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php
	/**
	 * @hooked electro_skip_links - 0
	 * @hooked electro_top_bar - 10
	 */
	do_action( 'electro_before_header' ); ?>

	<header id="masthead" class="site-header<?php if ( ! apply_filters( 'electro_show_header_support_info', true ) ) { echo esc_attr( ' no-header-support-info' ); } ?>">
		<div class="container">
			<?php
			/**
			 * @hooked electro_row_wrap_start - 0
			 * @hooked electro_header_logo - 10
			 * @hooked electro_primary_menu - 20
			 * @hooked electro_header_support_info - 30
			 * @hooked electro_row_wrap_end - 40
			 */
			do_action( 'electro_header' ); ?>

		</div>
	</header><!-- #masthead -->

	<?php
	/**
	 * @hooked electro_navbar - 10
	 */
	do_action( 'electro_before_content' ); ?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="container">

		<?php
		/**
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'electro_content_top' ); ?>