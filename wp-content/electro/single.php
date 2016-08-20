<?php 
/**
 * The main template file.
 *
 * This is the single post template file in a WordPress theme
 *
 * @package electro
 */

electro_get_header();

	do_action( 'electro_before_main_content' );

	while ( have_posts() ) : the_post();
	
	do_action( 'electro_single_post_before' );
	
	get_template_part( 'templates/contents/content', 'single' );

	/**
	 * @hooked electro_post_nav - 10
	 * @hooked electro_display_comments - 10
	 */
	do_action( 'electro_single_post_after' );

	endwhile; // end of the loop.

	do_action( 'electro_after_main_content' );

get_footer();