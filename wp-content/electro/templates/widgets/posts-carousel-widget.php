<?php

$r = new WP_Query( apply_filters( 'electro_recent_posts_widget_args', array(
	'posts_per_page'      => $instance['number'],
	'no_found_rows'       => true,
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true
) ) );

$carousel_id = 'posts-carousel-' . uniqid();
$carousel_args 	= apply_filters( 'electro_posts_carousel_widget_carousel_args', array(
	'items'				=> 1,
	'nav'				=> false,
	'slideSpeed'		=> 300,
	'dots'				=> false,
	'rtl'				=> is_rtl() ? true : false,
	'paginationSpeed'	=> 400,
	'navText'			=> array( '', '' ),
	'margin'			=> 0,
	'touchDrag'			=> true,
) );

if ($r->have_posts()) :

	echo wp_kses_post( $args['before_widget'] );
	?>

	<section class="section-posts-carousel">
		<?php if ( ! empty( $instance['title'] ) ) : ?>
		<header>

			<?php echo wp_kses_post( $args['before_title'] . $instance['title'] . $args['after_title'] ); ?>

			<?php if ( apply_filters( 'show_custom_nav', true ) ) : ?>
				<div class="owl-nav">
					<?php if ( is_rtl() ) : ?>
					<a href="#posts-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-right"></i></a>
					<a href="#posts-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-left"></i></a>
					<?php else : ?>
					<a href="#posts-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-left"></i></a>
					<a href="#posts-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-right"></i></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</header>
		<?php endif; ?>

		<div id="<?php echo esc_attr( $carousel_id );?>">
			<div class="owl-carousel">
			<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<?php
					$post_id 			= get_the_id();
					$post_format 		= get_post_format();
					$post_icon 			= electro_get_post_icon( $post_format );
					$categories_list	= get_the_category_list( __( ', ', 'electro' ) );
				?>
				<div class="post-item">
					<a class="post-thumbnail" href="<?php the_permalink(); ?>">
						<?php echo electro_get_thumbnail( $post_id, 'electro_blog_carousel', true, false, $post_icon ); ?>
					</a>
					<div class="post-content">
						<?php if ( $instance['show_category'] && $categories_list ) : ?>
							<span class="post-category"><?php echo wp_kses_post( $categories_list ); ?></span> -
						<?php endif; ?>
						<?php if ( $instance['show_date'] ) : ?>
							<span class="post-date"><?php echo get_the_date(); ?></span>
						<?php endif; ?>
						<a class ="post-name" href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
						<?php electro_comment_meta(); ?>
					</div>
				</div>
			<?php endwhile; ?>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$( '#<?php echo esc_attr( $carousel_id ); ?> .owl-carousel').owlCarousel(<?php echo json_encode( $carousel_args ); ?>);
			});
		</script>
	</section>
	<?php

	echo wp_kses_post( $args['after_widget'] );

endif;

wp_reset_postdata();
