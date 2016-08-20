<?php
/**
 * Template functions hooked into the `homepage_v3` action in the homepage template
 */

function electro_get_default_home_v3_options() {
	$home_v3 = array(
		'header_style'	=> '',
		'sdr'	=> array(
			'is_enabled'	=> 'yes',
			'priority'		=> 10,
			'animation'		=> '',
			'shortcode'		=> '',
		),
		'fl'	=> array(
			'is_enabled'	=> 'yes',
			'priority'		=> 10,
			'animation'		=> '',
			array(
				'icon'	=> 'ec ec-transport',
				'text'	=> wp_kses_post( __( '<strong>Free Delivery</strong> from $50', 'electro' ) )
			),
			array(
				'icon'	=> 'ec ec-customers',
				'text'	=> wp_kses_post( __( '<strong>99% Positive</strong> Feedbacks', 'electro' ) )
			),
			array(
				'icon'	=> 'ec ec-returning',
				'text'	=> wp_kses_post( __( '<strong>365 days</strong> for free return', 'electro' ) )
			),
			array(
				'icon'	=> 'ec ec-payment',
				'text'	=> wp_kses_post( __( '<strong>Payment</strong> Secure System', 'electro' ) )
			),
			array(
				'icon'	=> 'ec ec-tag',
				'text'	=> wp_kses_post( __( '<strong>Only Best</strong> Brands', 'electro' ) )
			)
		),
		'ad'	=> array(
			'is_enabled'	=> 'yes',
			'priority'		=> 10,
			'animation'		=> '',
			array(
				'ad_text'		=> wp_kses_post( __( 'Catch Hottest <strong>Deals</strong> in Cameras Category', 'electro' ) ),
				'action_text'	=> wp_kses_post( __( 'Shop now', 'electro' ) ),
				'action_link'	=> '#',
				'ad_image'		=> '',
				'el_class'		=> 'col-xs-12 col-sm-6',
			),
			array(
				'ad_text'		=> wp_kses_post( __( 'Tablets, Smartphones <strong>and more</strong>', 'electro' ) ),
				'action_text'	=> wp_kses_post( __( '<span class="from"><span class="prefix">From</span><span class="value"><sup>$</sup>749</span><span class="suffix">99</span></span>', 'electro' ) ),
				'action_link'	=> '#',
				'ad_image'		=> '',
				'el_class'		=> 'col-xs-12 col-sm-6',
			),
		),
		'pct'	=> array(
			'is_enabled'		=> 'yes',
			'priority'			=> 10,
			'animation'			=> '',
			'product_limit'		=> 12,
			'product_columns'	=> 4,
			'tabs'				=> array(
				array(
					'title'		=> esc_html__( 'Featured', 'electro' ),
					'content'	=> array(
						'shortcode'				=> 'featured_products',
						'product_category_slug'	=> '',
						'products_choice'		=> 'ids',
						'products_ids_skus'		=> '',
					)
				),
				array(
					'title'		=> esc_html__( 'On Sale', 'electro' ),
					'content'	=> array(
						'shortcode'				=> 'sale_products',
						'product_category_slug'	=> '',
						'products_choice'		=> 'ids',
						'products_ids_skus'		=> '',
					)
				),
				array(
					'title'		=> esc_html__( 'Top Rated', 'electro' ),
					'content'	=> array(
						'shortcode'				=> 'top_rated_products',
						'product_category_slug'	=> '',
						'products_choice'		=> 'ids',
						'products_ids_skus'		=> '',
					)
				)
			),
		),
		'pci'	=> array(
			'is_enabled'	=> 'yes',
			'priority'		=> 10,
			'animation'		=> '',
			'image'			=> array(
				'bg_img'		=> '',
				'ad_img'		=> '',
			),
			'carousel'		=> array(
				'section_title'		=> esc_html__( 'Hoodies', 'electro' ),
				'product_limit'		=> 6,
				'product_columns'	=> 2,
				'content'			=> array(
					'shortcode'				=> 'product_category',
					'product_category_slug'	=> 'hoodies',
					'products_choice'		=> '',
					'products_ids_skus'		=> '',
				)
			)
		),
		'pcc'	=> array(
			'is_enabled'		=> 'yes',
			'priority'			=> 10,
			'animation'			=> '',
			'section_title'		=> esc_html__( 'Music', 'electro' ),
			'product_limit'		=> 16,
			'product_columns'	=> 2,
			'product_rows'		=> 2,
			'cat_limit'			=> 3,
			'cat_slugs'			=> '',
			'content'			=> array(
				'shortcode'				=> 'product_category',
				'product_category_slug'	=> 'music',
				'products_choice'		=> '',
				'products_ids_skus'		=> '',
			)
		),
		'so'	=> array(
			'is_enabled'		=> 'yes',
			'priority'			=> 10,
			'animation'			=> '',
			'section_title'		=> esc_html__( 'Bestsellers', 'electro' ),
			'cat_limit'			=> 3,
			'cat_slugs'			=> '',
			'content'			=> array(
				'shortcode'				=> 'best_selling_products',
				'product_category_slug'	=> '',
				'products_choice'		=> '',
				'products_ids_skus'		=> '',
			)
		),
		'hlc'	=> array(
			'is_enabled'		=> 'yes',
			'priority'			=> 10,
			'animation'			=> '',
			'section_title'		=> esc_html__( 'Top Categories this Month', 'electro' ),
			'cat_slugs'			=> '',
			'cat_args'			=> array(
				'number'			=> 6,
				'orderby'			=> 'name',
				'order'				=> 'ASC',
				'hide_empty'		=> true
			)
		)
	);

	return apply_filters( 'electro_home_v3_default_options', $home_v3 );
}

function electro_get_home_v3_meta( $merge_default = true ) {
	global $post;

	if ( isset( $post->ID ) ){
		$home_v3_options = json_decode( get_post_meta( $post->ID, '_home_v3_options', true ), true );
	
		if ( $merge_default ) {
			$default_options = electro_get_default_home_v3_options();
			$home_v3 = wp_parse_args( $home_v3_options, $default_options );
		} else {
			$home_v3 = $home_v3_options;
		}
	
		return apply_filters( 'electro_home_v3_meta', $home_v3, $post );
	}
}

if ( ! function_exists( 'electro_home_v3_slider' ) ) {
	/**
	 * Displays Slider in Home v3
	 */
	function electro_home_v3_slider() {

		$home_v3 	= electro_get_home_v3_meta();
		$sdr 		= $home_v3['sdr'];

		$is_enabled = isset( $sdr['is_enabled'] ) ? $sdr['is_enabled'] : 'no';

		if ( $is_enabled !== 'yes' ) {
			return;
		}

		$animation = !empty( $sdr['animation'] ) ? $sdr['animation'] : '';
		$shortcode = !empty( $sdr['shortcode'] ) ? $sdr['shortcode'] : '[rev_slider alias="home-v3-slider"]';

		$section_class = 'home-v3-slider';
		if ( ! empty( $animation ) ) {
			$section_class = ' animate-in-view';
		}
		?>
		<div class="<?php echo esc_attr( $section_class );?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>
			<?php echo apply_filters( 'electro_home_v3_slider_html', do_shortcode( $shortcode ) ); ?>
		</div><?php
	}
}


if ( ! function_exists( 'electro_home_v3_features_list' ) ) {
	/**
	 *
	 */
	function electro_home_v3_features_list() {

		$home_v3 = electro_get_home_v3_meta();

		$is_enabled = isset( $home_v3['fl']['is_enabled'] ) ? $home_v3['fl']['is_enabled'] : 'no';

		if ( $is_enabled !== 'yes' ) {
			return;
		}

		$animation = isset( $home_v3['fl']['animation'] ) ? $home_v3['fl']['animation'] : '';

		$features = array(
			array(
				'icon'	=> isset( $home_v3['fl'][0]['icon'] ) ? $home_v3['fl'][0]['icon'] : 'ec ec-transport',
				'text'	=> isset( $home_v3['fl'][0]['text'] ) ? $home_v3['fl'][0]['text'] : wp_kses_post( __( '<strong>Free Delivery</strong> from $50', 'electro' ) )
			),
			array(
				'icon'	=> isset( $home_v3['fl'][1]['icon'] ) ? $home_v3['fl'][1]['icon'] : 'ec ec-customers',
				'text'	=> isset( $home_v3['fl'][1]['text'] ) ? $home_v3['fl'][1]['text'] : wp_kses_post( __( '<strong>99% Positive</strong> Feedbacks', 'electro' ) )
			),
			array(
				'icon'	=> isset( $home_v3['fl'][2]['icon'] ) ? $home_v3['fl'][2]['icon'] : 'ec ec-returning',
				'text'	=> isset( $home_v3['fl'][2]['text'] ) ? $home_v3['fl'][2]['text'] : wp_kses_post( __( '<strong>365 days</strong> for free return', 'electro' ) )
			),
			array(
				'icon'	=> isset( $home_v3['fl'][3]['icon'] ) ? $home_v3['fl'][3]['icon'] : 'ec ec-payment',
				'text'	=> isset( $home_v3['fl'][3]['text'] ) ? $home_v3['fl'][3]['text'] : wp_kses_post( __( '<strong>Payment</strong> Secure System', 'electro' ) )
			),
			array(
				'icon'	=> isset( $home_v3['fl'][4]['icon'] ) ? $home_v3['fl'][4]['icon'] : 'ec ec-tag',
				'text'	=> isset( $home_v3['fl'][4]['text'] ) ? $home_v3['fl'][4]['text'] : wp_kses_post( __( '<strong>Only Best</strong> Brands', 'electro' ) )
			)
		);

		ob_start();

		electro_features_list( $features );

		$features_html = ob_get_clean();

		$section_class 	= 'home-v3-features-block';

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view';
		}
		?><div class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
			<?php echo wp_kses_post( $features_html ); ?>
		</div><?php
	}
}

if ( ! function_exists( 'electro_home_v3_ads_block' ) ) {
	/**
	 *
	 */
	function electro_home_v3_ads_block() {

		$home_v3 = electro_get_home_v3_meta();

		$is_enabled = isset( $home_v3['ad']['is_enabled'] ) ? $home_v3['ad']['is_enabled'] : 'no';

		if ( $is_enabled !== 'yes' ) {
			return;
		}

		$animation = !empty( $home_v3['ad']['animation'] ) ? ' animated ' . $home_v3['ad']['animation'] : '';

		$args = apply_filters( 'home_v3_ads_args', array(
			array(
				'ad_text'		=> isset( $home_v3['ad'][0]['ad_text'] ) ? $home_v3['ad'][0]['ad_text'] : wp_kses_post( __( 'Catch Big <strong>Deals</strong> on the Cameras', 'electro' ) ),
				'action_text'	=> isset( $home_v3['ad'][0]['action_text'] ) ? $home_v3['ad'][0]['action_text'] : wp_kses_post( __( 'Shop now', 'electro' ) ),
				'action_link'	=> isset( $home_v3['ad'][0]['action_link'] ) ? $home_v3['ad'][0]['action_link'] : '#',
				'ad_image'		=> isset( $home_v3['ad'][0]['ad_image'] ) ? wp_get_attachment_url( $home_v3['ad'][0]['ad_image'] ) : '',
				'el_class'		=> isset( $home_v3['ad'][0]['el_class'] ) ? $home_v3['ad'][0]['el_class'] : 'col-xs-12 col-sm-4',
			),
			array(
				'ad_text'		=> isset( $home_v3['ad'][1]['ad_text'] ) ? $home_v3['ad'][1]['ad_text'] : wp_kses_post( __( 'Tablets, Smartphones <strong>and more</strong>', 'electro' ) ),
				'action_text'	=> isset( $home_v3['ad'][1]['action_text'] ) ? $home_v3['ad'][1]['action_text'] : wp_kses_post( __( '<span class="upto"><span class="prefix">Upto</span><span class="value">70</span><span class="suffix">%</span>', 'electro' ) ),
				'action_link'	=> isset( $home_v3['ad'][1]['action_link'] ) ? $home_v3['ad'][1]['action_link'] : '#',
				'ad_image'		=> isset( $home_v3['ad'][1]['ad_image'] ) ? wp_get_attachment_url( $home_v3['ad'][1]['ad_image'] ) : '',
				'el_class'		=> isset( $home_v3['ad'][1]['el_class'] ) ? $home_v3['ad'][1]['el_class'] : 'col-xs-12 col-sm-4',
			),
		) );

		ob_start();

		electro_ads_block( $args );

		$ads_html = ob_get_clean();

		$section_class 	= 'home-v3-ads-block';

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view';
		}
		?><div class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
			<?php echo wp_kses_post( $ads_html ); ?>
		</div><?php
	}
}

if ( ! function_exists( 'electro_home_v3_products_carousel_tabs' ) ) {
	/**
	 *
	 */
	function electro_home_v3_products_carousel_tabs() {

		if ( is_woocommerce_activated() ) {

			$home_v3 = electro_get_home_v3_meta();

			$is_enabled = isset( $home_v3['pct']['is_enabled'] ) ? $home_v3['pct']['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation = isset( $home_v3['pct']['animation'] ) ? $home_v3['pct']['animation'] : '';

			$args = array(
				'animation'	=> $animation,
				'tabs' 			=> array(
					array(
						'id'			=> 'tab-products-1',
						'title'			=> isset( $home_v3['pct']['tabs'][0]['content']['shortcode'] ) ? $home_v3['pct']['tabs'][0]['title'] : esc_html__( 'Featured', 'electro' ),
						'shortcode_tag'	=> isset( $home_v3['pct']['tabs'][0]['content']['shortcode'] ) ? $home_v3['pct']['tabs'][0]['content']['shortcode'] : 'featured_products',
						'atts'			=> electro_get_atts_for_shortcode( $home_v3['pct']['tabs'][0]['content'] )
					),
					array(
						'id'			=> 'tab-products-2',
						'title'			=> isset( $home_v3['pct']['tabs'][1]['content']['shortcode'] ) ? $home_v3['pct']['tabs'][1]['title'] : esc_html__( 'On Sale', 'electro' ),
						'shortcode_tag'	=> isset( $home_v3['pct']['tabs'][1]['content']['shortcode'] ) ? $home_v3['pct']['tabs'][1]['content']['shortcode'] : 'sale_products',
						'atts'			=> electro_get_atts_for_shortcode( $home_v3['pct']['tabs'][1]['content'] )
					),
					array(
						'id'			=> 'tab-products-3',
						'title'			=> isset( $home_v3['pct']['tabs'][2]['content']['shortcode'] ) ? $home_v3['pct']['tabs'][2]['title'] : esc_html__( 'Top Rated', 'electro' ),
						'shortcode_tag'	=> isset( $home_v3['pct']['tabs'][2]['content']['shortcode'] ) ? $home_v3['pct']['tabs'][2]['content']['shortcode'] : 'top_rated_products',
						'atts'			=> electro_get_atts_for_shortcode( $home_v3['pct']['tabs'][2]['content'] )
					)
				),
				'limit'			=> isset( $home_v3['pct']['product_limit'] ) ? $home_v3['pct']['product_limit'] : 8,
				'columns'		=> isset( $home_v3['pct']['product_columns'] ) ? $home_v3['pct']['product_columns'] : 4
			);

			if ( is_rtl() ) {
				$args['nav-align'] = 'right';
			} else {
				$args['nav-align'] = 'left';
			}

			electro_get_template( 'homepage/products-carousel-tabs.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_products_carousel_with_image' ) ) {
	/**
	 *
	 */
	function electro_products_carousel_with_image() {

		if ( is_woocommerce_activated() ) {
			$home_v3 	= electro_get_home_v3_meta();

			$is_enabled = isset( $home_v3['pci']['is_enabled'] ) ? $home_v3['pci']['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation 	= isset( $home_v3['pci']['animation'] ) ? $home_v3['pci']['animation'] : '';
			$bg_img		= isset( $home_v3['pci']['image']['bg_img'] ) ? wp_get_attachment_url( $home_v3['pci']['image']['bg_img'] ) : '';
			$ad_img		= isset( $home_v3['pci']['image']['ad_img'] ) ? wp_get_attachment_url( $home_v3['pci']['image']['ad_img'] ) : '';

			$section_class = 'products-carousel-with-image';

			if ( ! empty( $animation ) ) {
				$section_class .= ' animate-in-view';
			}

			?>
			<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $bg_img ) ) : ?>style="background-size: cover; background-position: center center; background-image: url( <?php echo esc_url( $bg_img ); ?> );"<?php endif; ?> <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
				<h2 class="sr-only"><?php echo esc_html__( 'Products Carousel', 'electro' ); ?></h2>		
				<div class="container">
					<div class="row">
						<div class="image-block col-xs-12 col-sm-6">
							<?php
								if ( ! empty( $ad_img ) ) {
									?><img src="<?php echo esc_url( $ad_img ); ?>" class="img-responsive" alt="" /><?php
								}
							?>
						</div>
						<div class="products-carousel-block col-xs-12 col-sm-6">
							<?php

								$args = array(
									'section_args' 	=> array(
										'section_title'		=> isset( $home_v3['pci']['carousel']['section_title'] ) ? $home_v3['pci']['carousel']['section_title'] : esc_html__( 'Hoodies', 'electro' ),
										'section_class'		=> 'home-v2-categories-products-carousel section-products-carousel',
									),
									'carousel_args' => array(
										'margin'		=> 30,
										'columns'		=> 2,
										'responsive'	=> array(
											'0'		=> array( 'items'	=> 1 ),
											'480'	=> array( 'items'	=> 1 ),
											'768'	=> array( 'items'	=> 1 ),
											'992'	=> array( 'items'	=> 3 ),
											'1200' 	=> array( 'items' 	=> 2 )
										)
									),
								);

								$limit 			= isset( $home_v3['pci']['carousel']['product_limit'] ) ? $home_v3['pci']['carousel']['product_limit'] : 6;
								$columns 		= isset( $home_v3['pci']['carousel']['product_columns'] ) ? $home_v3['pci']['carousel']['product_columns'] : 2;

								$shortcode 		= isset( $home_v3['pci']['carousel']['content']['shortcode'] ) ? $home_v3['pci']['carousel']['content']['shortcode'] : 'product_category';

								$default_atts 	= array( 'per_page' => intval( $limit ) );
								$atts 			= electro_get_atts_for_shortcode( $home_v3['pci']['carousel']['content'] );
								$atts 			= wp_parse_args( $atts, $default_atts );

								$products_in_category = electro_do_shortcode( $shortcode, $atts );

								$args['section_args']['products_html'] = apply_filters( 'electro_home_v3_products_carousel_with_image_product_html', $products_in_category );

								electro_products_carousel( $args['section_args'], $args['carousel_args'] );
							?>
						</div>
					</div>
				</div>
			</section><?php
		}
	}
}

if ( ! function_exists( 'electro_home_v3_product_cards_carousel' ) ) {
	/**
	 *
	 */
	function electro_home_v3_product_cards_carousel() {

		if ( is_woocommerce_activated() ) {
			$home_v3 		= electro_get_home_v3_meta();

			$is_enabled = isset( $home_v3['pcc']['is_enabled'] ) ? $home_v3['pcc']['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation 		= isset( $home_v3['pcc']['animation'] ) ? $home_v3['pcc']['animation'] : '';
			$limit 			= isset( $home_v3['pcc']['product_limit'] ) ? intval( $home_v3['pcc']['product_limit'] ) : 16;
			$rows 			= isset( $home_v3['pcc']['product_rows'] ) ? intval( $home_v3['pcc']['product_rows'] ) : 2;
			$columns 		= isset( $home_v3['pcc']['product_columns'] ) ? intval( $home_v3['pcc']['product_columns'] ) : 2;

			$shortcode 		= isset( $home_v3['pcc']['content']['shortcode'] ) ? $home_v3['pcc']['content']['shortcode'] : 'product_category';

			$default_atts 	= array( 'per_page' => intval( $limit ) );
			$atts 			= electro_get_atts_for_shortcode( $home_v3['pcc']['content'] );
			$atts 			= wp_parse_args( $atts, $default_atts );
			$products 		= Electro_Products::$shortcode( $atts );

			$args = apply_filters( 'electro_home_v3_product_cards_carousel_args', array(
				'section_args' 	=> array(
					'section_title'		=> isset( $home_v3['pcc']['section_title'] ) ? $home_v3['pcc']['section_title'] : esc_html__( 'Music', 'electro' ),
					'products'			=> $products,
					'columns'			=> $columns,
					'rows'				=> $rows,
					'total'				=> $limit,
					'show_nav'			=> false,
					'show_carousel_nav'	=> true,
					'animation'			=> $animation,
				),
				'carousel_args'	=> array()
			) );

			electro_product_cards_carousel( $args['section_args'], $args['carousel_args'] );
		}
	}
}

if ( ! function_exists( 'electro_home_v3_6_1_block' ) ) {
	/**
	 * Displays a 6-1 Block in Home v3
	 */
	function electro_home_v3_6_1_block() {

		if ( is_woocommerce_activated() ) {

			$home_v3 		= electro_get_home_v3_meta();
			$so 			= $home_v3['so'];

			$is_enabled = isset( $so['is_enabled'] ) ? $so['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation 		= isset( $so['animation'] ) ? $so['animation'] : '';
			$shortcode 		= isset( $so['content']['shortcode'] ) ? $so['content']['shortcode'] : 'sale_products';
			$default_atts 	= array( 'per_page' => 7 );
			$atts 			= electro_get_atts_for_shortcode( $so['content'] );
			$atts 			= wp_parse_args( $atts, $default_atts );
			$products 		= Electro_Products::$shortcode( $atts );

			$args = apply_filters( 'electro_home_v3_6_1_args', array(
				'section_title'		=> $so['section_title'],
				'categories_count'	=> $so['cat_limit'],
				'categories_slugs'	=> $so['cat_slugs'],
				'products'			=> $products,
				'category_args'		=> '',
				'animation'			=> $animation
			) );
			electro_products_6_1_block( $args );
		}
	}
}

if ( ! function_exists( 'electro_home_v3_list_categories' ) ) {
	/**
	 *
	 */
	function electro_home_v3_list_categories() {

		if ( is_woocommerce_activated() ) {
			$home_v3 	= electro_get_home_v3_meta();

			$is_enabled = isset( $home_v3['hlc']['is_enabled'] ) ? $home_v3['hlc']['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation 	= isset( $home_v3['hlc']['animation'] ) ? $home_v3['hlc']['animation'] : '';
			$cat_args 	= isset( $home_v3['hlc']['cat_args'] ) ? $home_v3['hlc']['cat_args'] : array( 'number' => 6 );

			if ( ! empty( $home_v3['hlc']['cat_slugs'] ) ) {
				$cat_slugs = explode( ',', $home_v3['hlc']['cat_slugs'] );
				$cat_slugs = array_map( 'trim', $cat_slugs );
				$cat_args['slug'] 				= $cat_slugs;
				$cat_args['hide_empty'] 		= false;

				$include = array();

				foreach ( $cat_slugs as $slug ) {
					$include[] = "'" . $slug ."'";
				}

				if ( ! empty($include ) ) {
					$cat_args['include'] 	= $include;
					$cat_args['orderby']	= 'include';
				}
			}

			$args = array(
				'section_title'			=> isset( $home_v3['hlc']['section_title'] ) ? $home_v3['hlc']['section_title'] : esc_html__( 'Top Categories this Month', 'electro' ),
				'animation'				=> $animation,
				'category_args'			=> $cat_args,
				'child_category_args'	=> array(
					'echo' 					=> false,
					'title_li' 				=> '',
					'show_option_none' 		=> '',
					'number' 				=> 6,
					'depth'					=> 1,
					'hide_empty'			=> false
				)
			);

			electro_home_list_categories( $args );
		}
	}
}
