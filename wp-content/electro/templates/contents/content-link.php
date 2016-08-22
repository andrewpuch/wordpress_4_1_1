<?php
/**
 * @package electro
 */

$additional_post_classes = apply_filters( 'electro_additional_post_classes', array() );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $additional_post_classes ); ?>>

	<div class="entry-content">
		<?php
		$post_url = get_post_meta ( get_the_ID() , 'postformat_link_url' , true );

		the_content(
			sprintf(
				__( 'Continue reading %s', 'electro' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);

		if( ! empty( $post_url ) ) {
			?>
			<p>
				<a href="<?php echo esc_url( $post_url ); ?>" target="_blank">
					<span><?php echo esc_url( $post_url ); ?></span>
				</a>
			</p>
			<?php
		}
		
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'electro' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->