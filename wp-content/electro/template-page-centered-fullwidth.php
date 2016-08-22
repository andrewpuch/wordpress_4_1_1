<?php
/**
 * Template Name: Centered Fullwidth
 *
 * @package electro
 */

electro_get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php 

		while ( have_posts() ) : the_post(); 

			do_action( 'electro_page_before' );

			get_template_part( 'templates/contents/content', 'page' );

			/**
			 * @hooked electro_display_comments - 10
			 */
			do_action( 'electro_page_after' );

		endwhile; // end of the loop.

		?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php 

get_footer();