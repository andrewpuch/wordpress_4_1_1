<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package electro
 */

global $post;
$page_meta_values = get_post_meta( $post->ID, '_electro_page_metabox', true );

$header_style = '';
if ( isset( $page_meta_values['site_header_style'] ) && ! empty( $page_meta_values['site_header_style'] ) ) {
	$header_style = $page_meta_values['site_header_style'];
}

electro_get_header( $header_style ); ?>

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

<?php get_footer();