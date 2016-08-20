<?php

$r = new WP_Query( apply_filters( 'electro_widget_recent_posts_args', array(
	'posts_per_page'      => $instance['number'],
	'no_found_rows'       => true,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true
) ) );

if ($r->have_posts()) :

	echo wp_kses_post( $args['before_widget'] );

	if ( ! empty( $instance['title'] ) ) {
		echo wp_kses_post( $args['before_title'] . $instance['title'] . $args['after_title'] );
	}

	?>
	<ul>
	<?php while ( $r->have_posts() ) : $r->the_post(); ?>
		<li>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php 
				$post_format 	= get_post_format();
				$post_icon 		= electro_get_post_icon( $post_format );
				echo electro_get_thumbnail( get_the_id(), 'thumbnail', true, false, $post_icon ); 
			?></a>
			<div class="post-content">
				<a class ="post-name" href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
				<?php if ( $instance['show_date'] ) : ?>
					<span class="post-date"><?php echo get_the_date(); ?></span>
				<?php endif; ?>
			</div>
		</li>
	<?php endwhile; ?>
	</ul>
	<?php

	echo wp_kses_post( $args['after_widget'] );

endif;

wp_reset_postdata();
