<?php
/**
 *
 */
function electro_get_default_home_v2_options() {
	$home_v2 = array(
		'sdr'	=> array(
			'is_enabled'	=> 'yes',
			'priority'		=> 10,
			'animation'		=> '',
			'shortcode'		=> '',
		),
		'ad'	=> array(
			'is_enabled'		=> 'yes',
			'animation'			=> '',
			'priority'			=> 20,
			array(
				'ad_text'		=> wp_kses_post( __( 'Catch Hottest <strong>Deals</strong> in Cameras', 'electro' ) ),
				'action_text'	=> wp_kses_post( __( 'Shop now', 'electro' ) ),
				'action_link'	=> '#',
				'ad_image'		=> '',
				'el_class'		=> 'col-xs-12 col-sm-6',
			),
			array(
				'ad_text'		=> wp_kses_post( __( 'Tablets, Smartphones <strong>and more</strong>', 'electro' ) ),
				'action_text'	=> wp_kses_post( __( '<span class="from"><span class="prefix">From</span><span class="value"><sup>$</sup>74</span><span class="suffix">99</span></span>', 'electro' ) ),
				'action_link'	=> '#',
				'ad_image'		=> '',
				'el_class'		=> 'col-xs-12 col-sm-6',
			),
		),
		'pct'	=> array(
			'is_enabled'		=> 'yes',
			'animation'			=> '',
			'priority'			=> 30,
			'product_limit'		=> 12,
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
			),
		),
		'dow'	=> array(
			'is_enabled'		=> 'yes',
			'animation'			=> '',
			'priority'			=> 40,
			'section_title'		=> esc_html__( 'Deals of the week', 'electro' ),
			'product_limit'		=> 4,
			'product_choice'	=> 'random',
			'product_ids'		=> '',
		),
		'pcc'	=> array(
			'is_enabled'		=> 'yes',
			'animation'			=> '',
			'priority'			=> 50,
			'section_title'		=> esc_html__( 'Bestsellers', 'electro' ),
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
			'animation'			=> '',
			'priority'			=> 60,
			'image'				=> 0,
			'link'				=> '#',
		),
		'pc'	=> array(
			'is_enabled'		=> 'yes',
			'animation'			=> '',
			'priority'			=> 70,
			'section_title'		=> esc_html__( 'Clothing', 'electro' ),
			'product_limit'		=> 20,
			'product_columns'	=> 4,
			'content'			=> array(
				'shortcode'				=> 'product_category',
				'product_category_slug'	=> 'clothing',
				'products_choice'		=> 'ids',
				'products_ids_skus'		=> '',
			)
		)
	);

	return apply_filters( 'electro_home_v2_default_options', $home_v2 );
}

function electro_get_home_v2_meta( $merge_default = true ) {
	global $post;

	if ( isset( $post->ID ) ) {
		$home_v2_options = json_decode( get_post_meta( $post->ID, '_home_v2_options', true ), true );
	
		if ( $merge_default ) {
			$default_options = electro_get_default_home_v2_options();
			$home_v2 = wp_parse_args( $home_v2_options, $default_options );
		} else {
			$home_v2 = $home_v2_options;
		}
	
		return apply_filters( 'electro_home_v2_meta', $home_v2, $post );
	}
}

if ( ! function_exists( 'electro_home_v2_slider' ) ) {
	/**
	 *
	 */
	function electro_home_v2_slider() {
		$home_v2 	= electro_get_home_v2_meta();
		$sdr 		= $home_v2['sdr'];

		$is_enabled = isset( $sdr['is_enabled'] ) ? $sdr['is_enabled'] : 'no';

		if ( $is_enabled !== 'yes' ) {
			return;
		}

		$animation = isset( $sdr['animation'] ) ? $sdr['animation'] : '';
		$shortcode = !empty( $sdr['shortcode'] ) ? $sdr['shortcode'] : '[rev_slider alias="home-v2-boxed-slider"]';

		$section_class = 'home-v1-slider';
		if ( ! empty( $animation ) ) {
			$section_class = ' animate-in-view';
		}
		?>
		<div class="<?php echo esc_attr( $section_class );?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>
			<?php echo apply_filters( 'electro_home_v2_slider_html', do_shortcode( $shortcode ) ); ?>
		</div><?php
	}
}

if ( ! function_exists( 'electro_home_v2_ads_block' ) ) {
	/**
	 *
	 */
	function electro_home_v2_ads_block() {

		$home_v2 = electro_get_home_v2_meta();

		$is_enabled = isset( $home_v2['ad']['is_enabled'] ) ? $home_v2['ad']['is_enabled'] : 'no';

		if ( $is_enabled !== 'yes' ) {
			return;
		}

		$animation = !empty( $home_v2['ad']['animation'] ) ? ' animated ' . $home_v2['ad']['animation'] : '';

		$args = apply_filters( 'electro_home_v2_ads_args', array(
			array(
				'ad_text'		=> isset( $home_v2['ad'][0]['ad_text'] ) ? $home_v2['ad'][0]['ad_text'] : wp_kses_post( __( 'Catch Hottest <strong>Deals</strong> in Cameras', 'electro' ) ),
				'action_text'	=> isset( $home_v2['ad'][0]['action_text'] ) ? $home_v2['ad'][0]['action_text'] : wp_kses_post( __( 'Shop now', 'electro' ) ),
				'action_link'	=> isset( $home_v2['ad'][0]['action_link'] ) ? $home_v2['ad'][0]['action_link'] : '#',
				'ad_image'		=> isset( $home_v2['ad'][0]['ad_image'] ) ? wp_get_attachment_url( $home_v2['ad'][0]['ad_image'] ) : '',
				'el_class'		=> isset( $home_v2['ad'][0]['el_class'] ) ? $home_v2['ad'][0]['el_class'] : 'col-xs-12 col-sm-6',
			),
			array(
				'ad_text'		=> isset( $home_v2['ad'][1]['ad_text'] ) ? $home_v2['ad'][1]['ad_text'] : wp_kses_post( __( 'Tablets, Smartphones <strong>and more</strong>', 'electro' ) ),
				'action_text'	=> isset( $home_v2['ad'][1]['action_text'] ) ? $home_v2['ad'][1]['action_text'] : wp_kses_post( __( '<span class="from"><span class="prefix">From</span><span class="value"><sup>$</sup>74</span><span class="suffix">99</span>', 'electro' ) ),
				'action_link'	=> isset( $home_v2['ad'][1]['action_link'] ) ? $home_v2['ad'][1]['action_link'] : '#',
				'ad_image'		=> isset( $home_v2['ad'][1]['ad_image'] ) ? wp_get_attachment_url( $home_v2['ad'][1]['ad_image'] ) : '',
				'el_class'		=> isset( $home_v2['ad'][1]['el_class'] ) ? $home_v2['ad'][1]['el_class'] : 'col-xs-12 col-sm-6',
			),
		) );

		ob_start();

		electro_ads_block( $args );

		$ads_html = ob_get_clean();

		$section_class 	= 'home-v2-ads-block';

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view';
		}
		?><div class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
			<?php echo wp_kses_post( $ads_html ); ?>
		</div><?php
	}
}

if ( ! function_exists( 'electro_home_v2_products_carousel_tabs' ) ) {
	/**
	 *
	 */
	function electro_home_v2_products_carousel_tabs() {

		if ( is_woocommerce_activated() ) {

			$home_v2 = electro_get_home_v2_meta();

			$is_enabled = isset( $home_v2['pct']['is_enabled'] ) ? $home_v2['pct']['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation = isset( $home_v2['pct']['animation'] ) ? $home_v2['pct']['animation'] : '';

			$args = apply_filters( 'electro_home_v2_products_carousel_tabs_args', array(
				'animation'		=> $animation,
				'tabs' 			=> array(
					array(
						'id'			=> 'featured-products',
						'title'			=> isset( $home_v2['pct']['tabs'][0]['content']['shortcode'] ) ? $home_v2['pct']['tabs'][0]['title'] : esc_html__( 'Featured', 'electro' ),
						'shortcode_tag'	=> isset( $home_v2['pct']['tabs'][0]['content']['shortcode'] ) ? $home_v2['pct']['tabs'][0]['content']['shortcode'] : 'featured_products',
						'atts'			=> electro_get_atts_for_shortcode( $home_v2['pct']['tabs'][0]['content'] )
					),
					array(
						'id'			=> 'sale-products',
						'title'			=> isset( $home_v2['pct']['tabs'][1]['content']['shortcode'] ) ? $home_v2['pct']['tabs'][1]['title'] : esc_html__( 'On Sale', 'electro' ),
						'shortcode_tag'	=> isset( $home_v2['pct']['tabs'][1]['content']['shortcode'] ) ? $home_v2['pct']['tabs'][1]['content']['shortcode'] : 'sale_products',
						'atts'			=> electro_get_atts_for_shortcode( $home_v2['pct']['tabs'][1]['content'] )
					),
					array(
						'id'			=> 'top-rated-products',
						'title'			=> isset( $home_v2['pct']['tabs'][2]['content']['shortcode'] ) ? $home_v2['pct']['tabs'][2]['title'] : esc_html__( 'Top Rated', 'electro' ),
						'shortcode_tag'	=> isset( $home_v2['pct']['tabs'][2]['content']['shortcode'] ) ? $home_v2['pct']['tabs'][2]['content']['shortcode'] : 'top_rated_products',
						'atts'			=> electro_get_atts_for_shortcode( $home_v2['pct']['tabs'][2]['content'] )
					)
				),
				'limit'			=> isset( $home_v2['pct']['product_limit'] ) ? $home_v2['pct']['product_limit'] : 6,
				'columns'		=> isset( $home_v2['pct']['product_columns'] ) ? $home_v2['pct']['product_columns'] : 3,
				'nav-align'		=> 'center',
			) );

			electro_get_template( 'homepage/products-carousel-tabs.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_home_v2_onsale_product' ) ) {
	/**
	 * Displays an onsale product in home
	 *
	 * @return void
	 */
	function electro_home_v2_onsale_product() {

		if ( is_woocommerce_activated() ) {

			$home_v2 = electro_get_home_v2_meta();

			$is_enabled = isset( $home_v2['dow']['is_enabled'] ) ? $home_v2['dow']['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation = isset( $home_v2['dow']['animation'] ) ? $home_v2['dow']['animation'] : '';

			$section_args = array(
				'section_title'		=> isset( $home_v2['dow']['section_title'] ) ? $home_v2['dow']['section_title'] : esc_html__( 'Deals of the week', 'electro' ),
				'show_savings'		=> true,
				'savings_in'		=> 'amount',
				'savings_text'		=> esc_html__( 'Save', 'electro' ),
				'limit'				=> isset( $home_v2['dow']['product_limit'] ) ? $home_v2['dow']['product_limit'] : 4,
				'show_custom_nav'	=> true,
				'product_choice'	=> isset( $home_v2['dow']['product_choice'] ) ? $home_v2['dow']['product_choice'] : 'random',
				'product_ids'		=> isset( $home_v2['dow']['product_ids'] ) ? $home_v2['dow']['product_ids'] :'',
				'animation'			=> $animation
			);

			$carousel_args 	= array(
				'items'				=> 1,
				'nav'				=> false,
				'slideSpeed'		=> 300,
				'dots'				=> false,
				'rtl'				=> is_rtl() ? true : false,
				'paginationSpeed'	=> 400,
				'navText'			=> array( esc_html__( 'Previous Deal', 'electro' ), esc_html__( 'Next Deal', 'electro' ) ),
				'margin'			=> 0,
				'touchDrag'			=> true
			);

			electro_onsale_product_carousel( $section_args, $carousel_args );
		}
	}
}

if ( ! function_exists( 'electro_home_v2_product_cards_carousel' ) ) {
	/**
	 *
	 */
	function electro_home_v2_product_cards_carousel() {

		if ( is_woocommerce_activated() ) {

			$home_v2 		= electro_get_home_v2_meta();

			$is_enabled = isset( $home_v2['pcc']['is_enabled'] ) ? $home_v2['pcc']['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation 		= isset( $home_v2['pcc']['animation'] ) ? $home_v2['pcc']['animation'] : '';
			$limit 			= isset( $home_v2['pcc']['product_limit'] ) ? intval( $home_v2['pcc']['product_limit'] ) : 20;
			$rows 			= isset( $home_v2['pcc']['product_rows'] ) ? intval( $home_v2['pcc']['product_rows'] ) : 2;
			$columns 		= isset( $home_v2['pcc']['product_columns'] ) ? intval( $home_v2['pcc']['product_columns'] ) : 3;

			$shortcode 		= isset( $home_v2['pcc']['content']['shortcode'] ) ? $home_v2['pcc']['content']['shortcode'] : 'best_selling_products';
			$default_atts 	= array( 'per_page' => intval( $limit ) );
			$atts 			= electro_get_atts_for_shortcode( $home_v2['pcc']['content'] );
			$atts 			= wp_parse_args( $atts, $default_atts );
			$products 		= Electro_Products::$shortcode( $atts );

			$args = apply_filters( 'electro_home_v2_product_cards_carousel_args', array(
				'section_args' 	=> array(
					'section_title'		=> isset( $home_v2['pcc']['section_title'] ) ? $home_v2['pcc']['section_title'] : esc_html__( 'Best Sellers', 'electro' ),
					'section_class'		=> 'home-v2-product-cards-carousel',
					'animation'			=> $animation,
					'products'			=> $products,
					'columns'			=> $columns,
					'rows'				=> $rows,
					'total'				=> $limit,
					'cat_slugs'			=> isset( $home_v2['pcc']['cat_slugs'] ) ? $home_v2['pcc']['cat_slugs'] : '',
					'cat_limit'			=> isset( $home_v2['pcc']['cat_limit'] ) ? $home_v2['pcc']['cat_limit'] : 3,
				),
				'carousel_args'	=> ''
			) );

			electro_product_cards_carousel( $args['section_args'], $args['carousel_args'] );
		}
	}
}

if ( ! function_exists( 'electro_home_v2_ad_banner' ) ) {
	/**
	 * Displays a banner in home v2
	 */
	function electro_home_v2_ad_banner() {

		$home_v2 = electro_get_home_v2_meta();

		$is_enabled = isset( $home_v2['bd']['is_enabled'] ) ? $home_v2['bd']['is_enabled'] : 'no';

		if ( $is_enabled !== 'yes' ) {
			return;
		}

		$animation = !empty( $home_v2['bd']['animation'] ) ? ' animated ' . $home_v2['bd']['animation'] : '';

		$args = apply_filters( 'electro_home_v2_ad_banner_args', array(
			'img_src'	=> ( isset( $home_v2['bd']['image'] ) && $home_v2['bd']['image'] != 0 ) ? wp_get_attachment_url( $home_v2['bd']['image'] ) : 'http://placehold.it/1170x170',
			'el_class'	=> 'home-v2-fullbanner-ad',
			'link'		=> isset( $home_v2['bd']['link'] ) ? $home_v2['bd']['link'] : '#',
		) );

		ob_start();

		electro_fullbanner_ad( $args );

		$banner_html = ob_get_clean();

		$section_class = 'home-v2-banner-block';

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view';
		}
		?><div class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>
			<?php echo wp_kses_post( $banner_html ); ?>
		</div><?php
	}
}

if ( ! function_exists( 'electro_home_v2_products_carousel' ) ) {
	/**
	 *
	 */
	function electro_home_v2_products_carousel() {

		if ( is_woocommerce_activated() ) {

			$home_v2 	= electro_get_home_v2_meta();
			$pc_options = $home_v2['pc'];

			$is_enabled = isset( $pc_options['is_enabled'] ) ? $pc_options['is_enabled'] : 'no';

			if ( $is_enabled !== 'yes' ) {
				return;
			}

			$animation = isset( $pc_options['animation'] ) ? $pc_options['animation'] : '';

			$args = apply_filters( 'electro_home_v2_products_carousel', array(
				'limit'			=> $pc_options['product_limit'],
				'columns'		=> $pc_options['product_columns'],
				'section_args' 	=> array(
					'section_title'		=> $pc_options['section_title'],
					'section_class'		=> 'home-v2-categories-products-carousel section-products-carousel',
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
