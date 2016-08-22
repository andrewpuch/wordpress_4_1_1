<?php
/**
 * @package electro
 */

$additional_post_classes = apply_filters( 'electro_additional_post_classes', array() );

$post_format = get_post_format();

if( $post_format == 'quote' || $post_format == 'link' || $post_format == 'aside' || $post_format == 'status' ) {
	get_template_part( 'templates/contents/content', $post_format );
} else {
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( $additional_post_classes ); ?>>
		<?php
			/**
			* @hooked electro_post_thumbnail - 10
			* @hooked electro_post_header - 20
			* @hooked electro_post_content - 30
			*/
			do_action( 'electro_single_post' );
		?>
	</article><!-- #post-## -->
	<?php
}
