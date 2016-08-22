<?php
/**
 * Products Carousel Tab
 *
 * @package Electro/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section_class = empty( $section_class ) ? 'home-list-categories' : 'home-list-categories ' . $section_class;
$categories = get_terms( 'product_cat', $category_args );

if ( ! empty( $animation ) ) {
	$section_class .= ' animate-in-view';
} ?>
<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
	<header>
		<h2 class="h1"><?php echo esc_html( $section_title ); ?></h2>
	</header>
	<ul class="categories">
		<?php foreach( $categories as $category ) : ?>
		<li class="category">
			<div class="media">
				<a class="media-left" href="<?php echo esc_url( get_term_link( $category ) ); ?>">
					<?php woocommerce_subcategory_thumbnail( $category ); ?>
				</a>
				<div class="media-body">
					<h4 class="media-heading"><a href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a></h4>
					<?php
						$child_category_args = wp_parse_args( array( 'taxonomy' => 'product_cat', 'child_of' => $category->term_id ), $child_category_args );
						echo '<ul class="sub-categories list-unstyled">' . wp_list_categories( $child_category_args ) . '</ul>';
					?>
				</div>
			</div>
			<a class="see-all" href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html__( 'See all', 'electro' ); ?></a>
		</li>
		<?php endforeach; ?>
	</ul>
</section>