<?php
/**
 * Products 2-1-2 Block
 *
 * @package Electro/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section_class = empty( $section_class ) ? 'products-2-1-2' : $section_class . ' products-2-1-2'; 

if ( ! empty( $animation ) ) {
	$section_class .= ' animate-in-view';
}
?>
<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( !empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>
	<h2 class="sr-only"><?php echo esc_html__( 'Products Grid', 'electro' ); ?></h2>
	<div class="container">
		
		<?php if ( ! empty( $section_title ) && ! empty( $categories ) ) : ?>

		<ul class="nav nav-inline nav-justified">
			
			<?php if ( ! empty( $section_title ) ) : ?>
			<li class="nav-item"><a href="#" class="active nav-link"><?php echo esc_html( $section_title ); ?></a></li>
			<?php endif; ?>
			
			<?php 
			if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
				foreach( $categories as $category ) : ?>
			<li class="nav-item"><a class="nav-link" href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a></li>
				<?php endforeach;
			endif; ?>
		
		</ul>

		<?php endif; ?>

		<?php if ( !empty( $products ) ) : ?>
		
		<div class="columns-2-1-2">
			<ul class="products exclude-auto-height">
			<?php 
				$products_count = 0;

				if ( $products->have_posts() ) {

					while ( $products->have_posts() ) : $products->the_post();

						if ( $products_count == 2 || $products_count == 3 ) {
							
							echo '</ul>';

							if ( $products_count == 2 ) {
								remove_action( 'woocommerce_after_shop_loop_item_title',	'electro_template_loop_product_thumbnail', 		5  );
								add_action( 'woocommerce_after_shop_loop_item_title', 	 	'electro_template_loop_product_single_image', 	5  );
								echo '<ul class="products exclude-auto-height product-main-2-1-2">';
							}
							
							if ( $products_count == 3 ) {
								echo '<ul class="products exclude-auto-height">';
							}
						}
						
						wc_get_template_part( 'content', 'product' );

						if ( $products_count == 2 ) {
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

		<?php endif; ?>
	</div>
</section>