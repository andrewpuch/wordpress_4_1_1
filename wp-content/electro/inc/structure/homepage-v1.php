<?php
/**
 *
 */
function electro_get_default_home_v1_options() {
	$home_v1 = array(
		'sdr'	=> array(
			'is_enabled'	=> 'yes',
			'priority'		=> 10,
			'animation'		=> '',
			'shortcode'		=> '',
		),
		'ad'	=> array(
			'is_enabled'	=> 'yes',
			'priority'		=> 10,
			'animation'		=> '',
			array(
				'ad_text'		=> wp_kses_post( __( 'Catch Big <strong>Deals</strong> on the Cameras', 'electro' ) ),
				'action_text'	=> wp_kses_post( __( 'Shop now', 'electro' ) ),
				'action_link'	=> '#',
				'ad_image'		=> '',
				'el_class'		=> 'col-xs-12 col-sm-4',
			),
			array(
				'ad_text'		=> wp_kses_post( __( 'Tablets, Smartphones <strong>and more</strong>', 'electro' ) ),
				'action_text'	=> wp_kses_post( __( '<span class="upto"><span class="prefix">Upto</span><span class="value">70</span><span class="suffix"></span></span>', 'electro' ) ),
				'action_link'	=> '#',
				'ad_image'		=> '',
				'el_class'		=> 'col-xs-12 col-sm-4',
			),
			array(
				'ad_text'		=> wp_kses_post( __( 'Shop the <strong>Hottest</strong> Products', 'electro' ) ),
				'action_text'	=> wp_kses_post( __( 'Shop now', 'electro' ) ),
				'action_link'	=> '#',
				'ad_image'		=> '',
				'el_class'		=> 'col-xs-12 col-sm-4',
			),
		),
		'dtd'	=> array(
			'is_enabled'	=> 'yes',
			'priority'		=> 10,
			'animation'		=> '',
			'deal'			=> array(
				'is_enabled'		=> 'yes',
				'section_title'		=> esc_html__( 'Special Offer', 'electro' ),
				'product_choice'	=> 'random',
				'product_id'		=> '',
				'savings_in'        => 'amount',
			),
			'tab'			=> array(
				'product_limit'		=> 6,
				'product_columns'	=> 3,
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
				)
			),
		),
		'tot'	=> array(
			'is_enabled'		=> 'yes',
			'priority'			=> 10,
			'animation'		=> '',
			'section_title'		=> esc_html__( 'Best Deals', 'electro' ),
			'cat_limit'			=> 7,
			'cat_slugs'			=> '',
			'content'			=> array(
				'shortcode'				=> 'sale_products',
				'product_category_slug'	=> '',
				'products_choice'		=> 'ids',
				'products_ids_skus'		=> '',
			)
		),
		'pcc'	=> array(
			'is_enabled'		=> 'yes',
			'priority'			=> 10,
			'animation'		=> '',
			'product_limit'		=> 20,
			'product_columns'	=> 3,
			'product_rows'		=> 2,
			'cat_limit'			=> 3,
			'cat_slugs'			=> '',
			'content'			=> array(
				'shortcode'				=> 'best_selling_products',
				'product_category_slug'	=> '',
				'products_choice'		=> 'ids',
				'products_ids_skus'		=> '',
			)
		),
		'bd'	=> array(
			'is_enabled'		=> 'yes',
			'priority'			=> 10,
			'animation'		=> '',
			'image'				=> 0,
			'link'				=> '#',
		),
		'pc'	=> array(
			'is_enabled'		=> 'yes',
			'priority'			=> 10,
			'animation'		=> '',
			'section_title'		=> esc_html__( 'Recently Added', 'electro' ),
			'product_limit'		=> 20,
			'product_columns'	=> 5,
			'content'			=> array(
				'shortcode'				=> 'recent_products',
				'product_category_slug'	=> '',
				'products_choice'		=> 'ids',
				'products_ids_skus'		=> '',
			)
		)
	);

	return apply_filters( 'electro_home_v1_default_options', $home_v1 );
}

function electro_get_home_v1_meta( $merge_default = true ) {
	global $post;

	if ( isset( $post->ID ) ){
	
		$home_v1_options = json_decode( get_post_meta( $post->ID, '_home_v1_options', true ), true );
	
		if ( $merge_default ) {
			$default_options = electro_get_default_home_v1_options();
			$home_v1 = wp_parse_args( $home_v1_options, $default_options );
		} else {
			$home_v1 = $home_v1_options;
		}
	
		return apply_filters( 'electro_home_v1_meta', $home_v1, $post );
	}
}

if ( ! function_exists( 'electro_home_v1_slider' ) ) {
	/**
	 * Displays Slider in Home v1
	 */
	function electro_home_v1_slider() {

		$home_v1 	= electro_get_home_v1_meta();
		$sdr 		= $home_v1['sdr'];

		$is_enabled = isset( $sdr['is_enabled'] ) ? $sdr['is_enabled'] : 'no';

		if ( $is_enabled !== 'yes' ) {
			return;
		}

		$animation = isset( $sdr['animation'] ) ? $sdr['animation'] : '';
		$shortcode = !empty( $sdr['shortcode'] ) ? $sdr['shortcode'] : '[rev_slider alias="home-v1-slider"]';

		$section_class = 'home-v1-slider';
		if ( ! empty( $animation ) ) {
			$section_class = ' animate-in-view';
		}
		?>
		<div class="<?php echo esc_attr( $section_class );?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>
			<?php echo apply_filters( 'electro_home_v1_slider_html', do_shortcode( $shortcode ) ); ?>
		</div><?php
	}
}

if ( ! function_exists( 'electro_home_v1_ads_block' ) ) {
	/**
	 * Displays Ads Block in Home v1
	 */
	function electro_home_v1_ads_block() {

		$home_v1 = electro_get_home_v1_meta();

		$is_enabled = isset( $home_v1['ad']['is_enabled'] ) ? $home_v1['ad']['is_enabled'] : 'no';

		if ( $is_enabled !== 'yes' ) {
			return;
		}

		$animation = isset( $home_v1['ad']['animation'] ) ? $home_v1['ad']['animation'] : '';

		$args = apply_filters( 'home_v1_ads_args', array(
			array(
				'ad_text'		=> isset( $home_v1['ad'][0]['ad_text'] ) ? $home_v1['ad'][0]['ad_text'] : wp_kses_post( __( 'Catch Big <strong>Deals</strong> on the Cameras', 'electro' ) ),
				'action_text'	=> isset( $home_v1['ad'][0]['action_text'] ) ? $home_v1['ad'][0]['action_text'] : wp_kses_post( __( 'Shop now', 'electro' ) ),
				'action_link'	=> isset( $home_v1['ad'][0]['action_link'] ) ? $home_v1['ad'][0]['action_link'] : '#',
				'ad_image'		=> isset( $home_v1['ad'][0]['ad_image'] ) ? wp_get_attachment_url( $home_v1['ad'][0]['ad_image'] ) : '',
				'el_class'		=> isset( $home_v1['ad'][0]['el_class'] ) ? $home_v1['ad'][0]['el_class'] : 'col-xs-12 col-sm-4',
			),
			array(
				'ad_text'		=> isset( $home_v1['ad'][1]['ad_text'] ) ? $home_v1['ad'][1]['ad_text'] : wp_kses_post( __( 'Tablets, Smartphones <strong>and more</strong>', 'electro' ) ),
				'action_text'	=> isset( $home_v1['ad'][1]['action_text'] ) ? $home_v1['ad'][1]['action_text'] : wp_kses_post( __( '<span class="upto"><span class="prefix">Upto</span><span class="value">70</span><span class="suffix">%</span>', 'electro' ) ),
				'action_link'	=> isset( $home_v1['ad'][1]['action_link'] ) ? $home_v1['ad'][1]['action_link'] : '#',
				'ad_image'		=> isset( $home_v1['ad'][1]['ad_image'] ) ? wp_get_attachment_url( $home_v1['ad'][1]['ad_image'] ) : '',
				'el_class'		=> isset( $home_v1['ad'][1]['el_class'] ) ? $home_v1['ad'][1]['el_class'] : 'col-xs-12 col-sm-4',
			),
			array(
				'ad_text'		=> isset( $home_v1['ad'][2]['ad_text'] ) ? $home_v1['ad'][2]['ad_text'] : wp_kses_post( __( 'Shop the <strong>Hottest</strong> Products', 'electro' ) ),
				'action_text'	=> isset( $home_v1['ad'][2]['action_text'] ) ? $home_v1['ad'][2]['action_text'] : wp_kses_post( __( 'Shop now', 'electro' ) ),
				'action_link'	=> isset( $home_v1['ad'][2]['action_link'] ) ? $home_v1['ad'][2]['action_link'] : '#',
				'ad_image'		=> isset( $home_v1['ad'][2]['ad_image'] ) ? wp_get_attachment_url( $home_v1['ad'][2]['ad_image'] ) : '',
				'el_class'		=> isset( $home_v1['ad'][2]['el_class'] ) ? $home_v1['ad'][2]['el_class'] : 'col-xs-12 col-sm-4',
			),
		) );

		ob_start();

		electro_ads_block( $args );

		$ads_html = ob_get_clean();

		$section_class 	= 'home-v1-ads-block';

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view';
		}
		?><div class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
			<?php echo wp_kses_post( $ads_html ); ?>
		</div><?php
	}
}



if ( ! function_exists( 'electro_home_v1_deal_and_tabs_block' ) ) {
	/**
	 * Displays a deal and tabs Block
	 */
	function electro_home_v1_deal_and_tabs_block() {

		if ( is_woocommerce_activated() ) {

			$home_v1 = electro_get_home_v1_meta();

			$is_enabled = isset( $home_v1['dtd']['is_enabled'] ) ? $home_v1['dtd']['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$product_tab_args = array(
				'tabs' 		=> array(
					array(
						'id'			=> 'tab-products-1',
						'title'			=> isset( $home_v1['dtd']['tab']['tabs'][0]['content']['shortcode'] ) ? $home_v1['dtd']['tab']['tabs'][0]['title'] : esc_html__( 'Featured', 'electro' ),
						'shortcode_tag'	=> isset( $home_v1['dtd']['tab']['tabs'][0]['content']['shortcode'] ) ? $home_v1['dtd']['tab']['tabs'][0]['content']['shortcode'] : 'featured_products',
						'atts'			=> electro_get_atts_for_shortcode( $home_v1['dtd']['tab']['tabs'][0]['content'] )
					),
					array(
						'id'			=> 'tab-products-2',
						'title'			=> isset( $home_v1['dtd']['tab']['tabs'][1]['content']['shortcode'] ) ? $home_v1['dtd']['tab']['tabs'][1]['title'] : esc_html__( 'On Sale', 'electro' ),
						'shortcode_tag'	=> isset( $home_v1['dtd']['tab']['tabs'][1]['content']['shortcode'] ) ? $home_v1['dtd']['tab']['tabs'][1]['content']['shortcode'] : 'sale_products',
						'atts'			=> electro_get_atts_for_shortcode( $home_v1['dtd']['tab']['tabs'][1]['content'] )
					),
					array(
						'id'			=> 'tab-products-3',
						'title'			=> isset( $home_v1['dtd']['tab']['tabs'][2]['content']['shortcode'] ) ? $home_v1['dtd']['tab']['tabs'][2]['title'] : esc_html__( 'Top Rated', 'electro' ),
						'shortcode_tag'	=> isset( $home_v1['dtd']['tab']['tabs'][2]['content']['shortcode'] ) ? $home_v1['dtd']['tab']['tabs'][2]['content']['shortcode'] : 'top_rated_products',
						'atts'			=> electro_get_atts_for_shortcode( $home_v1['dtd']['tab']['tabs'][2]['content'] )
					)
				),
				'limit'		=> isset( $home_v1['dtd']['tab']['product_limit'] ) ? $home_v1['dtd']['tab']['product_limit'] : 6,
				'columns'	=> isset( $home_v1['dtd']['tab']['product_columns'] ) ? $home_v1['dtd']['tab']['product_columns'] : 3,
			);

			$args = apply_filters( 'electro_home_v1_deal_and_tabs_block_args', array(
				'section_args'			=> array(
					'section_class'		=> 'home-v1-deals-and-tabs',
					'animation'			=> isset( $home_v1['dtd']['animation'] ) ? $home_v1['dtd']['animation'] : ''
				),
				'deal_products_args' 	=> array(
					'is_enabled'		=> isset( $home_v1['dtd']['deal']['is_enabled'] ) ? $home_v1['dtd']['deal']['is_enabled'] : 'no',
					'section_title'		=> isset( $home_v1['dtd']['deal']['title'] ) ? $home_v1['dtd']['deal']['title'] : esc_html__( 'Special Offer', 'electro' ),
					'product_choice'	=> isset( $home_v1['dtd']['deal']['product_choice'] ) ? $home_v1['dtd']['deal']['product_choice'] : '',
					'product_id'		=> isset( $home_v1['dtd']['deal']['product_id'] ) ? $home_v1['dtd']['deal']['product_id'] : '',
					'savings_in'        => isset( $home_v1['dtd']['deal']['savings_in'] ) ? $home_v1['dtd']['deal']['savings_in'] : 'amount',
				),
				'product_tabs_args'		=> $product_tab_args
			) );

			electro_deal_and_tabs_block( $args );
		}
	}
}

if ( ! function_exists( 'electro_home_v1_2_1_2_block' ) ) {
	/**
	 * Displays a 2-1-2 Block in Home v1
	 */
	function electro_home_v1_2_1_2_block() {

		if ( is_woocommerce_activated() ) {

			$home_v1 		= electro_get_home_v1_meta();
			$tot 			= $home_v1['tot'];

			$is_enabled = isset( $tot['is_enabled'] ) ? $tot['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$shortcode 		= isset( $tot['content']['shortcode'] ) ? $tot['content']['shortcode'] : 'sale_products';
			$default_atts 	= array( 'per_page' => 5 );
			$atts 			= electro_get_atts_for_shortcode( $tot['content'] );
			$atts 			= wp_parse_args( $atts, $default_atts );
			$products 		= Electro_Products::$shortcode( $atts );

			$args = apply_filters( 'electro_home_v1_2_1_1_args', array(
				'section_title'		=> $tot['section_title'],
				'section_class'		=> 'home-v1-products-2-1-2',
				'categories_count'	=> $tot['cat_limit'],
				'categories_slugs'	=> $tot['cat_slugs'],
				'products'			=> $products,
				'category_args'		=> '',
				'animation'			=> $tot['animation']
			) );
			electro_products_2_1_2_block( $args );
		}
	}
}

if ( ! function_exists( 'electro_home_v1_product_cards_carousel' ) ) {
	/**
	 * Displays a Products Cards carousel in home v1
	 */
	function electro_home_v1_product_cards_carousel() {

		if ( is_woocommerce_activated() ) {

			$home_v1 		= electro_get_home_v1_meta();

			$is_enabled = isset( $home_v1['pcc']['is_enabled'] ) ? $home_v1['pcc']['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation 		= isset( $home_v1['pcc']['animation'] ) ? $home_v1['pcc']['animation'] : '';
			$limit 			= isset( $home_v1['pcc']['product_limit'] ) ? intval( $home_v1['pcc']['product_limit'] ) : 20;
			$rows 			= isset( $home_v1['pcc']['product_rows'] ) ? intval( $home_v1['pcc']['product_rows'] ) : 2;
			$columns 		= isset( $home_v1['pcc']['product_columns'] ) ? intval( $home_v1['pcc']['product_columns'] ) : 3;

			$shortcode 		= isset( $home_v1['pcc']['content']['shortcode'] ) ? $home_v1['pcc']['content']['shortcode'] : 'best_selling_products';
			$default_atts 	= array( 'per_page' => intval( $limit ) );
			$atts 			= electro_get_atts_for_shortcode( $home_v1['pcc']['content'] );
			$atts 			= wp_parse_args( $atts, $default_atts );
			$products 		= Electro_Products::$shortcode( $atts );

			$args = apply_filters( 'electro_home_v1_product_cards_carousel_args', array(
				'section_args' 	=> array(
					'section_title'		=> isset( $home_v1['pcc']['section_title'] ) ? $home_v1['pcc']['section_title'] : esc_html__( 'Best Sellers', 'electro' ),
					'section_class'		=> 'home-v1-product-cards-carousel ',
					'products'			=> $products,
					'columns'			=> $columns,
					'rows'				=> $rows,
					'total'				=> $limit,
					'cat_slugs'			=> isset( $home_v1['pcc']['cat_slugs'] ) ? $home_v1['pcc']['cat_slugs'] : '',
					'cat_limit'			=> isset( $home_v1['pcc']['cat_limit'] ) ? $home_v1['pcc']['cat_limit'] : 3,
					'animation'			=> $animation
				),
				'carousel_args'	=> ''
			) );

			electro_product_cards_carousel( $args['section_args'], $args['carousel_args'] );
		}
	}
}

if ( ! function_exists( 'electro_home_v1_ad_banner' ) ) {
	/**
	 * Displays a banner in home v1
	 */
	function electro_home_v1_ad_banner() {

		$home_v1 = electro_get_home_v1_meta();

		$is_enabled = isset( $home_v1['bd']['is_enabled'] ) ? $home_v1['bd']['is_enabled'] : 'no';

		if ( $is_enabled !== 'yes' ) {
			return;
		}

		$animation = ! empty( $home_v1['bd']['animation'] ) ? $home_v1['bd']['animation'] : '';

		$args = apply_filters( 'electro_home_v1_ad_banner_args', array(
			'img_src'	=> ( isset( $home_v1['bd']['image'] ) && $home_v1['bd']['image'] != 0 ) ? wp_get_attachment_url( $home_v1['bd']['image'] ) : 'http://placehold.it/1170x170',
			'el_class'	=> 'home-v1-fullbanner-ad',
			'link'		=> isset( $home_v1['bd']['link'] ) ? $home_v1['bd']['link'] : '#',
		) );

		ob_start();

		electro_fullbanner_ad( $args );

		$banner_html = ob_get_clean();

		$section_class = 'home-v1-banner-block';

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view';
		}
		?><div class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
			<?php echo wp_kses_post( $banner_html ); ?>
		</div><?php
	}
}

if ( ! function_exists( 'electro_home_v1_products_carousel' ) ) {
	/**
	 *
	 */
	function electro_home_v1_products_carousel() {

		if ( is_woocommerce_activated() ) {

			$home_v1 	= electro_get_home_v1_meta();
			$pc_options = $home_v1['pc'];

			$is_enabled = isset( $pc_options['is_enabled'] ) ? $pc_options['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation = !empty( $pc_options['animation'] ) ? $pc_options['animation'] : '';

			$args = apply_filters( 'electro_home_v1_products_carousel', array(
				'limit'			=> $pc_options['product_limit'],
				'columns'		=> $pc_options['product_columns'],
				'section_args' 	=> array(
					'section_title'		=> $pc_options['section_title'],
					'section_class'		=> 'home-v1-recently-viewed-products-carousel section-products-carousel ',
					'animation'			=> $animation
				),
				'carousel_args'	=> array(
					'items'				=> $pc_options['product_columns'],
					'responsive'		=> array(
						'0'		=> array( 'items' => 1 ),
						'480'	=> array( 'items' => 2 ),
						'768'	=> array( 'items' => 2 ),
						'992'	=> array( 'items' => 3 ),
						'1200'	=> array( 'items' => $pc_options['product_columns'] ),
					)
				)
			) );

			$default_atts 	= array( 'per_page' => intval( $args['limit'] ), 'columns' => intval( $args['columns'] ) );
			$atts 			= electro_get_atts_for_shortcode( $pc_options['content'] );
			$atts 			= wp_parse_args( $atts, $default_atts );
			$products 		= electro_do_shortcode( $pc_options['content']['shortcode'], $atts );

			$args['section_args']['products_html'] = $products;

			electro_products_carousel( $args['section_args'], $args['carousel_args'] );
		}
	}
}
