<?php
/**
 * @package electro
 */

$additional_post_classes = apply_filters( 'electro_additional_post_classes', array() );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $additional_post_classes ); ?>>

	<?php
	/**
	 * @hooked electro_page_header - 10
	 * @hooked electro_page_content - 20
	 */
	do_action( 'electro_page' );
	?>
	
</article><!-- #post-## -->
