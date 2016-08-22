<?php
/**
 * Products Carousel Tab
 *
 * @package Electro/Templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args['nav-align'] = empty ( $args['nav-align'] ) ? 'center' : $args['nav-align'];
$section_class = empty( $section_class ) ? 'products-carousel-tabs' : 'products-carousel-tabs ' . $section_class;

if ( ! empty( $animation ) ) {
	$section_class .= ' animate-in-view';
}

?><section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ): ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
	<h2 class="sr-only"><?php echo esc_html__( 'Product Carousel Tabs', 'electro' ); ?></h2>
	<ul class="nav nav-inline text-xs-<?php echo esc_attr( $args['nav-align'] ); ?>">

	<?php

	foreach( $args['tabs'] as $key => $tab ) {

		$tab_id = ! empty( $tab['id'] ) ? $tab['id'] : 'home-tab-' . $key;

	?>
		<li class="nav-item">
			<a class="nav-link<?php if ( $key == 0 ) echo esc_attr( ' active' ); ?>" href="#<?php echo esc_attr( $tab_id ); ?>" data-toggle="tab">
				<?php echo wp_kses_post ( $tab['title'] ); ?>
			</a>
		</li>

	<?php }	?>

	</ul>

	<div class="tab-content">

		<?php

		foreach( $args['tabs'] as $key => $tab ) :

			$tab_id = ! empty( $tab['id'] ) ? $tab['id'] : 'home-tab-' . $key;
		?>

		<div class="tab-pane <?php if ( $key == 0 ) echo esc_attr( 'active' ); ?>" id="<?php echo esc_attr( $tab_id ); ?>" role="tabpanel">

		<?php
			$default_atts 	= array( 'per_page' => intval( $args['limit'] ), 'columns' => intval( $args['columns'] ) );
			$atts 			= isset( $tab['atts'] ) ? $tab['atts'] : array();
			$atts 			= wp_parse_args( $atts, $default_atts );

			if ( $tab['shortcode_tag'] == 'products' && !isset( $atts['orderby'] ) ) {
				$atts['orderby'] = 'post__in';
			}

			$products_html = electro_do_shortcode( $tab['shortcode_tag'], $atts );

			$section_args = array(
				'products_html'		=> $products_html,
				'show_custom_nav'	=> false
			);

			$carousel_args = array(
				'items'			=> intval( $args['columns'] ),
				'responsive'	=> array(
					'0'		=> array( 'items'	=> 1 ),
					'480'	=> array( 'items'	=> 1 ),
					'768'	=> array( 'items'	=> 2 ),
					'992'	=> array( 'items'	=> 3 ),
					'1200'	=> array( 'items' => intval( $args['columns'] ) )
				)
			);

			electro_products_carousel( $section_args, $carousel_args );
		?>
		</div>

		<?php endforeach; ?>

	</div>
</section>
