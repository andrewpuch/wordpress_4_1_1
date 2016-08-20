<?php
/**
 * Template functions hooked into the `homepage` action in the homepage template
 */

if ( ! function_exists( 'electro_revslider' ) ) {
	/**
	 * 
	 */
	function electro_revslider( $slider_name = '' ) {

		if ( ! empty( $slider_name ) && function_exists( 'putRevSlider' ) ) {
			putRevSlider( $slider_name );
		}
	}
}

if ( ! function_exists( 'electro_ads_block' ) ) {
	/**
	 *
	 */
	function electro_ads_block( $args = array() ) { ?>
		<div class="ads-block row">
		<?php foreach( $args as $arg ) : ?>
			<div class="ad <?php echo esc_attr( $arg['el_class'] ); ?>">
				<div class="media">
					<?php if ( ! empty( $arg['ad_image'] ) ) : ?>
					<div class="media-left media-middle"><img src="<?php echo esc_url( $arg['ad_image'] ); ?>" alt="" /></div>
					<?php endif; ?>
					<div class="media-body media-middle">
						<div class="ad-text">
							<?php echo wp_kses_post( $arg['ad_text'] ); ?>
						</div>
						<div class="ad-action">
							<a href="<?php echo esc_url( $arg['action_link'] ); ?>"><?php echo wp_kses_post( $arg['action_text'] ); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_products_carousel' ) ) {
	/**
	 * Products Carousel
	 */
	function electro_products_carousel( $section_args, $carousel_args ) {

		global $electro_version;

		$default_section_args 	= apply_filters( 'electro_products_carousel_section_args', array(
			'products_html'		=> '',
			'section_title'		=> '',
			'carousel_id'		=> 'products-carousel-' . uniqid(),
			'section_class'		=> 'section-products-carousel',
			'show_custom_nav'	=> true,
			'animation'			=> ''
		) );

		$default_carousel_args 	= apply_filters( 'electro_products_carousel_args', array(
			'items'				=> 4,
			'nav'				=> false,
			'slideSpeed'		=> 300,
			'dots'				=> true,
			'rtl'				=> is_rtl() ? true : false,
			'paginationSpeed'	=> 400,
			'navText'			=> array( '', '' ),
			'margin'			=> 0,
			'touchDrag'			=> true,
			'responsive'		=> array(
				'0'		=> array( 'items'	=> 1 ),
				'480'	=> array( 'items'	=> 3 ),
				'768'	=> array( 'items'	=> 2 ),
				'992'	=> array( 'items'	=> 3 ),
				'1200'	=> array( 'items'	=> 4 ),
			)
		) );

		$section_args 	= wp_parse_args( $section_args, $default_section_args );
		$carousel_args 	= wp_parse_args( $carousel_args, $default_carousel_args );

		extract( $section_args );

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view animation';
		}

		if ( ! empty( $products_html ) ) :

			wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true );
		?>
			<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>

				<?php if ( ! empty( $section_title ) ) : ?>

				<header>

					<h2 class="h1"><?php echo wp_kses_post( $section_title ); ?></h2>

				<?php if ( $show_custom_nav ) : ?>
					<div class="owl-nav">
						<?php if ( is_rtl() ) : ?>
						<a href="#products-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-right"></i></a>
						<a href="#products-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-left"></i></a>
						<?php else : ?>
						<a href="#products-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-left"></i></a>
						<a href="#products-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-right"></i></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				</header>

				<?php endif; ?>

				<div id="<?php echo esc_attr( $carousel_id );?>">
				<?php
					$search 		= array( '<ul', '<li', '</li>', '</ul>', 'class="products' );
					$replace 		= array( '<div', '<div', '</div>', '</div>', 'class="products owl-carousel products-carousel' );
					$products_html 	= str_replace( $search, $replace, $products_html );
					echo apply_filters( 'electro_products_carousel_html', $products_html );
				?>
				</div>

				<script type="text/javascript">
					jQuery(document).ready(function($){
						var $products_carousel = $( '#<?php echo esc_attr( $carousel_id ); ?> .owl-carousel')
						$products_carousel.on( 'initialized.owl.carousel translated.owl.carousel', function() {
							var $this = $(this);
							$this.find( '.owl-item.last-active' ).each( function() {
								$(this).removeClass( 'last-active' );
							});
							$(this).find( '.owl-item.active' ).last().addClass( 'last-active' );
						});
						$products_carousel.owlCarousel(<?php echo json_encode( $carousel_args ); ?>);
					});
				</script>
			</section>
		<?php

		endif;
	}
}


if ( ! function_exists( 'electro_products_carousel_tabs' ) ) {
	/**
	 * Displays Products Carousel Tabs in home
	 *
	 * @return void
	 */
	function electro_products_carousel_tabs( $args ) {

		if ( is_woocommerce_activated() ) {

			$defaults = apply_filters( 'electro_products_carousel_tabs_args', array(
				'tabs' 			=> array(
					array(
						'id'			=> 'featured-products',
						'title'			=> esc_html__( 'Featured', 'electro' ),
						'shortcode_tag'	=> 'featured_products',
					),
					array(
						'id'			=> 'sale-products',
						'title'			=> esc_html__( 'On Sale', 'electro' ),
						'shortcode_tag'	=> 'sale_products',
					),
					array(
						'id'			=> 'top-rated-products',
						'title'			=> esc_html__( 'Top Rated', 'electro' ),
						'shortcode_tag'	=> 'top_rated_products'
					)
				),
				'limit'			=> 4,
				'columns'		=> 3,
			) );

			$args = wp_parse_args( $args, $defaults );

			electro_get_template( 'homepage/products-carousel-tabs.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_deal_and_tabs_block' ) ) {
	/**
	 * Displays a deal and product tabs
	 *
	 * @return void
	 */
	function electro_deal_and_tabs_block( $args ) {

		if ( is_woocommerce_activated() ) {

			$defaults = array(
				'section_args' 			=> array( 'section_class' => '' ),
				'deal_products_args' 	=> '',
				'product_tabs_args'		=> '',
			);

			$args = wp_parse_args( $args, $defaults );

			extract( $args );

			$section_class 	= empty ( $section_args['section_class'] ) ? 'deals-and-tabs row' : $section_args['section_class'] . ' deals-and-tabs row';
			$animation 		= isset( $args['section_args']['animation'] ) ? $args['section_args']['animation'] : '';

			if ( !empty( $animation ) ) {
				$section_class .= ' animate-in-view';
			}

			$deals_is_enabled		= isset ( $deal_products_args['is_enabled'] ) ? $deal_products_args['is_enabled'] : 'no';
			$deals_section_class 	= $deals_is_enabled !== 'yes' ? 'deals-block col-lg-12' : 'deals-block col-lg-4';
			$tabs_section_class 	= $deals_is_enabled !== 'yes' ? 'tabs-block col-lg-12' : 'tabs-block col-lg-8';

			?>
			<div class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>
				<?php if( $deals_is_enabled === 'yes' ) : ?>
				<div class="<?php echo esc_attr( $deals_section_class ); ?>">
					<?php electro_onsale_product( $deal_products_args ); ?>
				</div>
				<?php endif; ?>
				<div class="<?php echo esc_attr( $tabs_section_class ); ?>">
					<?php electro_products_tabs( $product_tabs_args ); ?>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'electro_onsale_product' ) ) {
	/**
	 * Displays an onsale product in home
	 *
	 * @return void
	 */
	function electro_onsale_product( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			$defaults 	= array(
				'section_title'	=> wp_kses_post( __( '<span class="highlight">Special</span> Offer', 'electro' ) ),
				'section_class'	=> '',
				'show_savings'	=> true,
				'savings_in'	=> 'amount',
				'savings_text'	=> esc_html__( 'Save', 'electro' ),
			);

			if ( isset( $args['product_choice'] ) ) {
				switch( $args['product_choice'] ) {
					case 'random':
						$args['orderby'] = 'rand';
					break;
					case 'recent':
						$args['orderby'] 	= 'date';
						$args['order'] 		= 'DESC';
					break;
					case 'specific':
						$args['post__in'] 	= $args['product_id'];
					break;
				}
			}

			$args 		= wp_parse_args( array( 'per_page'	=> 1 ), $args );
			$args 		= wp_parse_args( $args, $defaults );
			$products 	= Electro_Products::sale_products( $args );

			extract( $args );

			if ( $products->have_posts() ) {

				while ( $products->have_posts() ) : $products->the_post();
			?>
			<section class="section-onsale-product <?php echo esc_attr( $section_class ); ?>">

				<?php if ( ! empty ( $section_title ) || $show_savings ) : ?>

				<header>

					<?php if ( ! empty ( $section_title ) ) : ?>

					<h2 class="h1"><?php echo wp_kses_post( $section_title ); ?></h2>

					<?php endif ; ?>

					<?php if ( $show_savings ) : ?>

					<div class="savings">
						<span class="savings-text">
						<?php
							global $product;
							echo sprintf( '%s %s', $savings_text, Electro_WC_Helper::get_savings_on_sale( $product, $savings_in ) );
						?>
						</span>
					</div>

					<?php endif; ?>

				</header>

				<?php endif; ?>
				<div class="onsale-products">
					<?php wc_get_template_part( 'templates/contents/content', 'onsale-product' ); ?>
				</div>

			</section>

			<?php

				endwhile;

				woocommerce_reset_loop();
				wp_reset_postdata();
			}
		}
	}
}

if ( ! function_exists( 'electro_onsale_product_carousel' ) ) {
	/**
	 * Displays an onsale products carousel in home
	 *
	 * @return void
	 */
	function electro_onsale_product_carousel( $section_args = array(), $carousel_args = array() ) {

		if ( is_woocommerce_activated() ) {

			$default_section_args 	= array(
				'section_title'		=> esc_html__( 'Deals of the week', 'electro' ),
				'section_class'		=> '',
				'show_savings'		=> true,
				'savings_in'		=> 'amount',
				'savings_text'		=> esc_html__( 'Save', 'electro' ),
				'limit'				=> 4,
				'show_custom_nav'	=> true,
				'product_ids'		=> '',
				'animation'			=> '',
				'show_progress'		=> true,
				'show_timer'		=> true,
				'show_cart_btn'		=> false
			);

			$default_carousel_args 	= array(
				'items'				=> 1,
				'nav'				=> false,
				'slideSpeed'		=> 300,
				'dots'				=> true,
				'rtl'				=> is_rtl() ? true : false,
				'paginationSpeed'	=> 400,
				'navText'			=> array( '', '' ),
				'margin'			=> 0,
				'touchDrag'			=> true
			);

			$section_args 		= wp_parse_args( $section_args, $default_section_args );
			$carousel_args 		= wp_parse_args( $carousel_args, $default_carousel_args );

			$args = array( 'per_page' => $section_args['limit'] );

			if ( isset( $section_args['product_choice'] ) ) {
				switch( $section_args['product_choice'] ) {
					case 'random':
						$args['orderby'] 	= 'rand';
					break;
					case 'recent':
						$args['orderby'] 	= 'date';
						$args['order'] 		= 'DESC';
					break;
					case 'specific':
						$args['post__in'] 	= explode( ',', $section_args['product_ids'] );
					break;
				}
			}

			$products 	= Electro_Products::sale_products( $args );

			extract( $section_args );

			$section_class .= ' section-onsale-product-carousel';

			if ( ! empty ( $animation ) ) {
				$section_class .= ' animate-in-view';
			}

			if( ! $show_progress ) {
				$section_class .= ' hide-progress';
			}

			if( ! $show_timer ) {
				$section_class .= ' hide-timer';
			}

			if( ! $show_cart_btn ) {
				$section_class .= ' hide-cart-button';
			}

			if ( $products->have_posts() ) {
				global $electro_version;
				$carousel_id = 'onsale-products-carousel-' . uniqid();
				wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true );

				?>
				<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation );?>"<?php endif; ?>>

					<?php if ( ! empty ( $section_title ) ) : ?>
						<header>
							<h2 class="h1"><?php echo wp_kses_post( $section_title ); ?></h2>
						</header>
					<?php endif ; ?>
					<?php if ( $show_custom_nav ) : ?>
						<div class="owl-nav">
							<?php if ( is_rtl() ) : ?>
							<a href="#onsale-products-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-right"></i><?php echo esc_html( $carousel_args['navText'][0] ); ?></a>
							<a href="#onsale-products-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><?php echo esc_html( $carousel_args['navText'][1] ); ?><i class="fa fa-angle-left"></i></a>
							<?php else : ?>
							<a href="#onsale-products-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-left"></i><?php echo esc_html( $carousel_args['navText'][0] ); ?></a>
							<a href="#onsale-products-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><?php echo esc_html( $carousel_args['navText'][1] ); ?><i class="fa fa-angle-right"></i></a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
					<div id="<?php echo esc_attr( $carousel_id ); ?>">
					<div class="onsale-product-carousel owl-carousel">
					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						<?php global $product; ?>
						<div class="onsale-product">
							<div class="onsale-product-thumbnails">

								<?php if ( $show_savings ) : ?>

								<div class="savings">
									<span class="savings-text">
									<?php echo sprintf( '%s %s', $savings_text, Electro_WC_Helper::get_savings_on_sale( $product, $savings_in ) ); ?>
									</span>
								</div>

								<?php endif; ?>

								<?php electro_show_wc_product_images(); ?>

							</div>
							<?php wc_get_template_part( 'templates/contents/content', 'onsale-product-carousel' ); ?>
						</div>
					<?php endwhile; ?>
					</div>
					</div>
					<script type="text/javascript">
						jQuery(document).ready( function($){
							$( '#<?php echo esc_attr( $carousel_id ); ?> .owl-carousel').owlCarousel( <?php echo json_encode( $carousel_args );?> );
						} );
					</script>
				</section>
				<?php
			}

			woocommerce_reset_loop();
			wp_reset_postdata();
		}
	}
}

if ( ! function_exists( 'electro_products_2_1_2_block' ) ) {
	/**
	 *
	 */
	function electro_products_2_1_2_block( $args ) {

		if ( is_woocommerce_activated() ) {
			$defaults = array(
				'section_title' 	=> '',
				'categories_count'	=> 7,
				'categories_slugs'	=> '',
				'category_args'		=> '',
				'products'			=> '',
				'animation'			=> '',
			);

			$args 	= wp_parse_args( $args, $defaults );

			if ( empty( $args['products'] ) ) {
				return;
			}

			$cat_args  	= array( 'number' => $args['categories_count'], 'hide_empty' => false );

			if ( !empty( $args['categories_slugs'] ) ) {
				$slugs 					= explode( ',', $args['categories_slugs'] );
				$cat_args['slug'] 		= $slugs;
				$cat_args['hide_empty'] = false;
				
				$include = array();
				
				foreach ( $slugs as $slug ) {
					$include[] = "'" . $slug ."'";
				}

				if ( ! empty($include ) ) {
					$cat_args['include'] 	= $include;
					$cat_args['orderby']	= 'include';
				}
			}

			if ( ! empty( $args['category_args'] ) ) {
				$cat_args = wp_parse_args( $args['category_args'], $cat_args );
			}

			$categories = get_terms( 'product_cat',  $cat_args );
			electro_get_template( 'homepage/products-2-1-2-block.php', array( 'categories' => $categories, 'products' => $args['products'], 'section_title' => $args['section_title'], 'animation' => $args['animation'] ) );
		}
	}
}

if ( ! function_exists( 'electro_products_6_1_block' ) ) {
	/**
	 *
	 */
	function electro_products_6_1_block( $args ) {

		if ( is_woocommerce_activated() ) {
			$defaults = array(
				'section_title' 	=> '',
				'section_class'		=> '',
				'categories_count'	=> 7,
				'categories_slugs'	=> '',
				'category_args'		=> '',
				'products'			=> '',
				'animation'			=> '',
			);

			$args 	= wp_parse_args( $args, $defaults );

			if ( empty( $args['products'] ) ) {
				return;
			}

			$cat_args  	= array( 'number' => $args['categories_count'], 'hide_empty' => false );

			if ( !empty( $args['categories_slugs'] ) ) {
				$slugs 					= explode( ',', $args['categories_slugs'] );
				$cat_args['slug'] 		= $slugs;
				$cat_args['hide_empty'] = false;
				
				$include = array();
				
				foreach ( $slugs as $slug ) {
					$include[] = "'" . $slug ."'";
				}

				if ( ! empty($include ) ) {
					$cat_args['include'] 	= $include;
					$cat_args['orderby']	= 'include';
				}
			}

			if ( ! empty( $args['category_args'] ) ) {
				$cat_args = wp_parse_args( $args['category_args'], $cat_args );
			}

			$categories = get_terms( 'product_cat',  $cat_args );
			electro_get_template( 'homepage/products-6-1-block.php', array( 'categories' => $categories, 'products' => $args['products'], 'section_title' => $args['section_title'], 'section_class' => $args['section_class'], 'animation' => $args['animation'] ) );
		}
	}
}

if ( ! function_exists( 'electro_fullbanner_ad' ) ) {
	function electro_fullbanner_ad( $args ) {

			$defaults = array(
				'img_src'	=> 'http://placehold.it/1170x170',
				'el_class'	=> '',
				'link'		=> '#'
			);

			$args = wp_parse_args( $args, $defaults );

			extract( $args );

			$el_class = empty ( $el_class ) ? 'fullbanner-ad' : $el_class . ' fullbanner-ad';
		?>
		<div class="<?php echo esc_attr( $el_class ); ?>" style="margin-bottom: 70px;">
			<a href="<?php echo esc_url( $link ); ?>" style="display: block;">
				<img src="<?php echo esc_url( $img_src ); ?>" class="img-fluid" alt="">
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_features_list' ) ) {
	/**
	 *
	 */
	function electro_features_list( $features = array(), $columns = 0 ) {

		if ( 0 === $columns ) {
			$columns = count( $features );
		}
		
		if( ! empty( $features ) ) {
			?>
			<div class="features-list columns-<?php echo esc_attr( $columns ) ; ?>">
				<?php foreach( $features as $feature ) : ?>
				<div class="feature">
					<div class="media">
						<div class="media-left media-middle feature-icon">
							<i class="<?php echo esc_attr( $feature['icon'] ); ?>"></i>
						</div>
						<div class="media-body media-middle feature-text">
							<?php echo wp_kses_post( $feature['text'] ); ?>
						</div>
					</div>
				</div>
				<?php endforeach ; ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'electro_products_tabs' ) ) {
	/**
	 * Displays Products Tabs in home
	 *
	 * @return void
	 */
	function electro_products_tabs( $args = array() ) {

		if ( is_woocommerce_activated() ) {

			$defaults =  array(
				'tabs' 		=> array(
					array(
						'id'			=> 'featured-products',
						'title'			=> esc_html__( 'Featured', 'electro' ),
						'shortcode_tag'	=> 'featured_products',
					),
					array(
						'id'			=> 'sale-products',
						'title'			=> esc_html__( 'On Sale', 'electro' ),
						'shortcode_tag'	=> 'sale_products',
					),
					array(
						'id'			=> 'top-rated-products',
						'title'			=> esc_html__( 'Top Rated', 'electro' ),
						'shortcode_tag'	=> 'top_rated_products'
					)
				),
				'limit'		=> 6,
				'columns'	=> 3,
				'animation'	=> '',
			);
			
			$args = apply_filters( 'electro_products_tabs_args', wp_parse_args( $args, $defaults ) );
			electro_get_template( 'homepage/products-tabs.php', $args );
		}
	}
}

if ( ! function_exists( 'electro_product_cards_carousel' ) ) {
	/**
	 * Displays Product cards as carousel
	 */
	function electro_product_cards_carousel( $section_args, $carousel_args ) {

		global $electro_version;

		$default_section_args 	= array(
			'section_title'		=> '',
			'section_class'		=> '',
			'show_nav'			=> true,
			'show_top_text'		=> true,
			'show_categories'	=> true,
			'show_carousel_nav'	=> false,
			'products'			=> '',
			'columns'			=> '',
			'rows'				=> '',
			'total'				=> '',
			'cat_limit'			=> 5,
			'cat_slugs'			=> '',
			'animation'			=> '',
		);

		$default_carousel_args 	= array(
			'items'				=> 1,
			'nav'				=> false,
			'slideSpeed'		=> 300,
			'dots'				=> true,
			'rtl'				=> is_rtl() ? true : false,
			'paginationSpeed'	=> 400,
			'navText'			=> array( '', '' ),
			'margin'			=> 0,
			'touchDrag'			=> true
		);

		$section_args 		= wp_parse_args( $section_args, $default_section_args );
		$carousel_args 		= wp_parse_args( $carousel_args, $default_carousel_args );

		extract( $section_args );

		$columns 			= intval( $columns );
		$rows 				= intval( $rows );

		$cat_args  			= array( 'number' => $cat_limit, 'hide_empty' => false );

		if ( !empty( $cat_slugs ) ) {
			$slugs 				= explode( ',', $cat_slugs );
			$cat_args['slug'] 	= $slugs;
			
			$include = array();
			
			foreach ( $slugs as $slug ) {
				$include[] = "'" . $slug ."'";
			}

			if ( ! empty($include ) ) {
				$cat_args['include'] 	= $include;
				$cat_args['orderby']	= 'include';
			}
		}

		if ( ! empty( $section_args['categories_args'] ) ) {
			$cat_args = wp_parse_args( $section_args['categories_args'], $cat_args );
		}

		$categories 		= get_terms( 'product_cat',  $cat_args );
		$products_card_html = '';
		$carousel_id 		= uniqid();

		if ( $products instanceof WP_Query ) {
			$products_card_html = Electro_WC_Helper::product_card_loop( $products, $columns, $rows );
		}

		$section_class = empty( $section_class ) ? 'section-product-cards-carousel' : 'section-product-cards-carousel ' . $section_class;

		if ( ! empty( $animation ) ) {
			$section_class .= ' animate-in-view';
		} 

		if ( ! empty( $products_card_html ) ) {

			wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true ); ?>
			
			<section class="<?php echo esc_attr( $section_class ); ?>" <?php if ( ! empty( $animation ) ) : ?>data-animation="<?php echo esc_attr( $animation ); ?>"<?php endif; ?>>

				<?php if ( ! empty( $section_title ) ) : ?>

				<header>

					<h2 class="h1"><?php echo esc_html( $section_title ); ?></h2>

					<?php if ( $show_nav ) : ?>
					<ul class="nav nav-inline">

						<?php if ( $show_top_text ) : ?>
						<li class="nav-item active">
							<span class="nav-link"><?php echo sprintf( esc_html__( 'Top %s', 'electro' ), $products->post_count ); ?></span>
						</li>
						<?php endif; ?>

						<?php if ( $show_categories && ! empty ( $categories ) && ! is_wp_error( $categories ) ) : ?>
							<?php foreach( $categories as $category ) : ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo esc_url( get_term_link( $category ) ); ?>"><?php echo esc_html( $category->name ); ?></a>
							</li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
					<?php elseif ( $show_carousel_nav ) : ?>
					<div class="owl-nav">
						<?php if ( is_rtl() ) : ?>
						<a href="#products-cards-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-right"></i></a>
						<a href="#products-cards-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-left"></i></a>
						<?php else : ?>
						<a href="#products-cards-carousel-prev" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-prev"><i class="fa fa-angle-left"></i></a>
						<a href="#products-cards-carousel-next" data-target="#<?php echo esc_attr( $carousel_id ); ?>" class="slider-next"><i class="fa fa-angle-right"></i></a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</header>

				<?php endif; ?>

				<div id="<?php echo esc_attr( $carousel_id );?>">
	
					<?php echo $products_card_html; ?>

				</div>

				<script type="text/javascript">
					jQuery(document).ready( function($){
						$( '#<?php echo esc_attr( $carousel_id ); ?> .owl-carousel' ).owlCarousel( <?php echo json_encode( $carousel_args );?> );
					} );
				</script>

			</section><?php
		}
	}
}

if ( ! function_exists( 'electro_home_list_categories' ) ) {
	/**
	 *
	 */
	function electro_home_list_categories( $args = array() ) {

		$default_args = apply_filters( 'electro_home_list_categories_args', array(
			'section_title'			=> '',
			'section_class'			=> '',
			'category_args'			=> array(
				'orderby'				=> 'name',
				'order'					=> 'ASC',
				'hide_empty'			=> true,
				'number'				=> 6,
				'hierarchical'			=> false,
				'slug'					=> '',
			),
			'child_category_args'	=> array( 
				'echo' 					=> false, 
				'title_li' 				=> '', 
				'show_option_none' 		=> '', 
				'number' 				=> 6,
				'depth'					=> 1,
				'hide_empty'			=> false
			)
		) );

		$args = wp_parse_args( $args, $default_args );

		if ( is_woocommerce_activated() ) {
			electro_get_template( 'homepage/home-list-categories.php', $args );
		}
	}
}

function electro_get_atts_for_shortcode( $args ) {
	$atts = array();
	
	if ( isset( $args['shortcode'] ) ) {

		if ( 'product_category' == $args['shortcode'] && ! empty( $args['product_category_slug'] ) ) {

			$atts['category'] = $args['product_category_slug'];
		
		} elseif ( 'products' == $args['shortcode'] && ! empty( $args['products_ids_skus'] ) ) {

			$ids_or_skus 		= ! empty( $args['products_choice'] ) ? $args['products_choice'] : 'ids';
			$atts[$ids_or_skus] = $args['products_ids_skus'];
		}
	}

	return $atts;
}

if( ! function_exists( 'electro_home_v1_hook_control' ) ) {
	function electro_home_v1_hook_control() {
		if( is_page_template( array( 'template-homepage-v1.php' ) ) ) {
			remove_all_actions( 'homepage_v1' );

			$home_v1 = electro_get_home_v1_meta();
			add_action( 'homepage_v1',	'electro_page_template_content',			5 );
			add_action( 'homepage_v1',	'electro_home_v1_slider',					isset( $home_v1['sdr']['priority'] ) ? intval( $home_v1['sdr']['priority'] ) : 10 );
			add_action( 'homepage_v1',	'electro_home_v1_ads_block',				isset( $home_v1['ad']['priority'] ) ? intval( $home_v1['ad']['priority'] ) : 20 );
			add_action( 'homepage_v1',	'electro_home_v1_deal_and_tabs_block',		isset( $home_v1['dtd']['priority'] ) ? intval( $home_v1['dtd']['priority'] ) : 30 );
			add_action( 'homepage_v1',	'electro_home_v1_2_1_2_block',				isset( $home_v1['tot']['priority'] ) ? intval( $home_v1['tot']['priority'] ) : 40 );
			add_action( 'homepage_v1',	'electro_home_v1_product_cards_carousel', 	isset( $home_v1['pcc']['priority'] ) ? intval( $home_v1['pcc']['priority'] ) : 50 );
			add_action( 'homepage_v1',	'electro_home_v1_ad_banner',				isset( $home_v1['bd']['priority'] ) ? intval( $home_v1['bd']['priority'] ) : 60 );
			add_action( 'homepage_v1',	'electro_home_v1_products_carousel',		isset( $home_v1['pc']['priority'] ) ? intval( $home_v1['pc']['priority'] ) : 70 );
		}
	}
}

if( ! function_exists( 'electro_home_v2_hook_control' ) ) {
	function electro_home_v2_hook_control() {
		if( is_page_template( array( 'template-homepage-v2.php' ) ) ) {
			remove_all_actions( 'homepage_v2' );

			$home_v2 = electro_get_home_v2_meta();
			add_action( 'homepage_v2',	'electro_page_template_content',			5 );
			add_action( 'homepage_v2',	'electro_home_v2_slider',					isset( $home_v2['sdr']['priority'] ) ? intval( $home_v2['sdr']['priority'] ) : 10 );
			add_action( 'homepage_v2',	'electro_home_v2_ads_block',				isset( $home_v2['ad']['priority'] ) ? intval( $home_v2['ad']['priority'] ) : 20 );
			add_action( 'homepage_v2',	'electro_home_v2_products_carousel_tabs',	isset( $home_v2['pct']['priority'] ) ? intval( $home_v2['pct']['priority'] ) : 30 );
			add_action( 'homepage_v2',	'electro_home_v2_onsale_product',			isset( $home_v2['dow']['priority'] ) ? intval( $home_v2['dow']['priority'] ) : 40 );
			add_action( 'homepage_v2',	'electro_home_v2_product_cards_carousel', 	isset( $home_v2['pcc']['priority'] ) ? intval( $home_v2['pcc']['priority'] ) : 50 );
			add_action( 'homepage_v2',	'electro_home_v2_ad_banner',				isset( $home_v2['bd']['priority'] ) ? intval( $home_v2['bd']['priority'] ) : 60 );
			add_action( 'homepage_v2',	'electro_home_v2_products_carousel',		isset( $home_v2['pc']['priority'] ) ? intval( $home_v2['pc']['priority'] ) : 70 );
		}
	}
}

if( ! function_exists( 'electro_home_v3_hook_control' ) ) {
	function electro_home_v3_hook_control() {
		if( is_page_template( array( 'template-homepage-v3.php' ) ) ) {
			remove_all_actions( 'homepage_v3' );

			$home_v3 = electro_get_home_v3_meta();
			add_action( 'homepage_v3',	'electro_page_template_content',			5 );
			add_action( 'homepage_v3',	'electro_home_v3_slider',					isset( $home_v3['sdr']['priority'] ) ? intval( $home_v3['sdr']['priority'] ) : 10 );
			add_action( 'homepage_v3',	'electro_home_v3_features_list',			isset( $home_v3['fl']['priority'] ) ? intval( $home_v3['fl']['priority'] ) : 20 );
			add_action( 'homepage_v3',	'electro_home_v3_ads_block',				isset( $home_v3['ad']['priority'] ) ? intval( $home_v3['ad']['priority'] ) : 30 );
			add_action( 'homepage_v3',	'electro_home_v3_products_carousel_tabs',	isset( $home_v3['pct']['priority'] ) ? intval( $home_v3['pct']['priority'] ) : 40 );
			add_action( 'homepage_v3',	'electro_products_carousel_with_image',		isset( $home_v3['pci']['priority'] ) ? intval( $home_v3['pci']['priority'] ) : 50 );
			add_action( 'homepage_v3',	'electro_home_v3_product_cards_carousel',	isset( $home_v3['pcc']['priority'] ) ? intval( $home_v3['pcc']['priority'] ) : 60 );
			add_action( 'homepage_v3',	'electro_home_v3_6_1_block',				isset( $home_v3['so']['priority'] ) ? intval( $home_v3['so']['priority'] ) : 70 );
			add_action( 'homepage_v3',	'electro_home_v3_list_categories',			isset( $home_v3['hlc']['priority'] ) ? intval( $home_v3['hlc']['priority'] ) : 80 );
		}
	}
}