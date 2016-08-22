<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage v1
 *
 * @package electro
 */

remove_action( 'electro_content_top', 'electro_breadcrumb', 10 );

do_action( 'electro_before_homepage_v1' );

get_header( 'v1' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			/**
			 * @hooked electro_homepage_content - 10
			 * @hooked electro_product_categories - 20
			 * @hooked electro_recent_products - 30
			 * @hooked electro_featured_products - 40
			 * @hooked electro_popular_products - 50
			 * @hooked electro_on_sale_products - 60
			 */
			do_action( 'homepage_v1' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php 

get_footer();