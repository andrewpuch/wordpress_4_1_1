<?php
/**
 * Products 6-1 Block
 *
 * @package Electro/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section_class = empty( $section_class ) ? 'products-6-1' : 'products-6-1 ' . $section_class;
if ( ! empty( $animation ) ) {
	$section_class .= ' animate-in-view';
}
?>
<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( !empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>
	<div class="container">
		<header>
			<h2 class="h1"><?php echo esc_html( $section_title ); ?></h2>
			<ul class="nav nav-inline">
				<li class="nav-item active">
					<span class="nav-link"><?php echo sprintf( esc_html__( 'Top %s', 'electro' ), $products->post_count ); ?></span>
				</li>

				<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
					foreach( $categories as $category ) : ?>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
					</li>
					<?php endforeach;
				endif; ?>
			</ul>
		</header>
		<div class="columns-6-1">
			<ul class="products exclude-auto-height products-6">
			<?php
				$products_count = 0;

				if ( $products->have_posts() ) {
					
					global $woocommerce_loop;
					$woocommerce_loop['columns'] = 3;

					while ( $products->have_posts() ) : $products->the_post();

						if ( $products_count == 6 ) {
							echo '</ul>';
							echo '<ul class="products exclude-auto-height product-main-6-1">';
							add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_show_product_thumbnails', 5 );
							remove_action( 'woocommerce_after_shop_loop_item_title',	'electro_template_loop_product_thumbnail', 		5  );
							add_action( 'woocommerce_after_shop_loop_item_title', 	 	'electro_template_loop_product_single_image', 	5  );
						}
						
						wc_get_template_part( 'content', 'product' );

						if ( $products_count == 6 ) {
							remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_show_product_thumbnails', 5 );
							remove_action( 'woocommerce_after_shop_loop_item_title', 	'electro_template_loop_product_single_image', 	5  );
							add_action( 'woocommerce_after_shop_loop_item_title',		'electro_template_loop_product_thumbnail', 		5  );
						}

						$products_count++;

					endwhile;
				}

				woocommerce_reset_loop();
				wp_reset_postdata();
			?>
			</ul>
		</div>
	</div>
</section>