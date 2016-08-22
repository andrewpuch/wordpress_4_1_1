<?php
/**
 * @package electro
 */

$additional_post_classes = apply_filters( 'electro_additional_post_classes', array('') );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $additional_post_classes ); ?>>

	<?php
	/**
 	 * @hooked electro_post_header() - 10
 	 * @hooked electro_post_meta() - 20
 	 * @hooked electro_post_content() - 30
	 */
	do_action( 'electro_loop_post' );
	?>

</article><!-- #post-## -->