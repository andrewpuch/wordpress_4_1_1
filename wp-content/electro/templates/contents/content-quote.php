<?php
/**
 * @package electro
 */

$additional_post_classes = apply_filters( 'electro_additional_post_classes', array() );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $additional_post_classes ); ?>>

	<div class="entry-content">

		<?php
			$quote_text = get_post_meta ( get_the_ID() , 'postformat_quote_text' , true );
			$quote_source = get_post_meta( get_the_ID() , 'postformat_quote_source' , true );
		?>

		<?php if( ! empty( $quote_text ) ) : ?>
		<blockquote>
			<p><?php echo esc_html( $quote_text ); ?></p>
			<cite><?php echo esc_html( $quote_source ); ?></cite>
		</blockquote>
		<?php endif; ?>

		<?php
		the_content(
			sprintf(
				__( 'Continue reading %s', 'electro' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'electro' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->