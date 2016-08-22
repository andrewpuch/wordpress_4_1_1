<?php
/**
 * @package electro
 */

$additional_post_classes = apply_filters( 'electro_additional_post_classes', array() );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $additional_post_classes ); ?>>

	<?php
		electro_post_content();
		electro_posted_on();
	?>

</article><!-- #post-## -->