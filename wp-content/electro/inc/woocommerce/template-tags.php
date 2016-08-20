<?php
/**
 * Template functions available for WooCommerce
 */

if ( ! function_exists( 'electro_before_wc_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @return  void
	 */
	function electro_before_wc_content() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
			<?php
	}
}

if ( ! function_exists( 'electro_product_subcategories' ) ) {
	/**
	 * Wrapper woocommerce_product_subcategories
	 *
	 */
	function electro_product_subcategories() {
		global $woocommerce_loop;

		$woocommerce_loop[ 'type' ] = 'product_subcategories';

		$columns 	= electro_set_loop_shop_columns();
		$class 		= 'woocommerce columns-' . $columns;
		$before 	= '<div class="' .esc_attr( $class ) . '"><ul class="product-loop-categories">';
		$after 		= '</ul></div>';

		if ( ! woocommerce_products_will_display() ) {

			$layout = electro_get_shop_layout();

			if ( 'full-width' == $layout ) {

				add_action( 'electro_after_product_subcategories', 'electro_best_sellers_carousel_in_category' );

			} else {

				add_action( 'electro_after_product_subcategories', 'electro_best_sellers_in_category' );
				add_action( 'electro_after_product_subcategories', 'electro_top_rated_in_category' );

			}
		}

		do_action( 'electro_before_product_subcategories' );

		ob_start();
		woocommerce_product_subcategories( array( 'before' => $before, 'after' => $after ) );
		$sub_categories_html = ob_get_clean();

		if ( ! empty( $sub_categories_html ) ):

			?><section>
				<header>
					<h2 class="h1"><?php echo sprintf( esc_html__( '%s Categories', 'electro' ), woocommerce_page_title() ); ?></h2>
				</header><?php

				echo wp_kses_post( $sub_categories_html );

			?></section><?php

		endif;

		do_action( 'electro_after_product_subcategories' );

		$woocommerce_loop[ 'type' ] = '';
	}
}

if ( ! function_exists( 'electro_best_sellers_carousel_in_category' ) ) {
	function electro_best_sellers_carousel_in_category() {

		$term = get_queried_object();

		if ( ! ( $term instanceof WP_Term ) ) {
			return;
		}

		$args = apply_filters( 'electro_best_sellers_carousel_in_category', array(
			'limit'			=> 24,
			'columns'		=> 6,
			'section_args' 	=> array(
				'section_title'		=> esc_html__( 'People buying in this category', 'electro' ),
				'section_class'		=> 'section-products-carousel',
			),
			'carousel_args'	=> array(
				'items'				=> 6,
				'responsive'		=> array(
					'0'		=> array( 'items'	=> 1 ),
					'480'	=> array( 'items'	=> 1 ),
					'768'	=> array( 'items'	=> 2 ),
					'992'	=> array( 'items'	=> 3 ),
					'1200'	=> array( 'items' => 6 ),
				)
			)
		) );

		$best_selling_products = electro_do_shortcode( 'best_selling_products', array(
			'per_page' 	=> intval( $args[ 'limit' ] ),
			'columns' 	=> intval( $args[ 'columns' ] ),
			'category'	=> $term->slug
		) );

		$args['section_args']['products_html'] = $best_selling_products;

		electro_products_carousel( $args['section_args'], $args['carousel_args'] );
	}
}

if ( ! function_exists( 'electro_best_sellers_in_category' ) ) {
	function electro_best_sellers_in_category() {

		global $wp_query;

		$term = get_queried_object();

		if ( ! ( $term instanceof WP_Term ) ) {
			return;
		}

		$args = apply_filters( 'electro_best_sellers_in_category', array(
			'query_args'	=> array(
				'limit'		=> 8,
				'category'	=> $term->slug
			),
			'section_args' 	=> array(
				'section_title'	=> esc_html__( 'Best Sellers', 'electro' ),
				'rows'			=> 1,
				'columns'		=> 2,
				'total'			=> 8,
				'show_nav'		=> false
			),
			'carousel_args'	=> array()
		) );

		$products_in_category = Electro_Products::best_selling_products( array(
			'limit' 	=> intval( $args['query_args']['limit'] ),
			'category'	=> sanitize_title( $args['query_args']['category'] )
		) );

		if ( $products_in_category->have_posts() ){
		
			$args['section_args']['products'] = apply_filters( 'electro_best_sellers_in_category_products_html', $products_in_category );
		
			electro_product_cards_carousel( $args['section_args'], $args['carousel_args'] );
		}
	}
}

if ( ! function_exists( 'electro_top_rated_in_category' ) ) {
	function electro_top_rated_in_category() {

		global $wp_query;

		$term = get_queried_object();

		if ( ! ( $term instanceof WP_Term ) ) {
			return;
		}

		$args = apply_filters( 'electro_top_rated_in_category', array(
			'query_args'	=> array(
				'limit'		=> 8,
				'category'	=> $term->slug
			),
			'section_args' 	=> array(
				'section_title'	=> esc_html__( 'Top rated in this category', 'electro' ),
				'rows'			=> 1,
				'columns'		=> 2,
				'total'			=> 8,
				'show_nav'		=> false
			),
			'carousel_args'	=> array()
		) );

		$products_in_category = Electro_Products::top_rated_products( array(
			'per_page' 	=> intval( $args['query_args']['limit'] ),
			'category'	=> sanitize_title( $args['query_args']['category'] )
		) );

		if ( $products_in_category->have_posts() ) {
		
			$args['section_args']['products'] = apply_filters( 'electro_top_rated_in_category_products_html', $products_in_category );
	
			electro_product_cards_carousel( $args['section_args'], $args['carousel_args'] );
		}
	}
}

if ( ! function_exists( 'electro_wc_loop_title' ) ) {
	/**
	 * Outputs WooCommerce Page titl
	 */
	function electro_wc_loop_title() {

		if ( apply_filters( 'woocommerce_show_page_title', true ) && woocommerce_products_will_display() ) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
			<?php woocommerce_result_count(); ?>
		</header>

		<?php
		endif;
	}
}

if ( ! function_exists( 'electro_after_wc_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @return  void
	 */
	function electro_after_wc_content() {
		?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php
		if ( apply_filters( 'electro_show_shop_sidebar', true ) ) {
			/**
			 *
			 */
			do_action( 'electro_sidebar', 'shop' );
		}
	}
}

if ( ! function_exists( 'electro_header_products_search' ) ) {
	/**
	 * Displays Products Search bar at header
	 */
	function electro_header_products_search() {

	}
}

if ( ! function_exists( 'electro_navbar_mini_cart' ) ) {
	/**
	 * Navbar mini cart
	 */
	function electro_navbar_mini_cart() {
		electro_get_template( 'shop/electro-mini-cart.php' );
	}
}

if ( ! function_exists( 'electro_wrap_product_outer' ) ) {
	/**
	 * Wraps product with product-outer div
	 */
	function electro_wrap_product_outer() {
		?><div class="product-outer"><?php
	}
}

if ( ! function_exists( 'electro_wrap_product_inner' ) ) {
	/**
	 * Wraps product with product-inner div
	 */
	function electro_wrap_product_inner() {
		?><div class="product-inner"><?php
	}
}

if ( ! function_exists( 'electro_wrap_price_and_add_to_cart' ) ) {
	/**
	 * Wraps price and add-to-cart button
	 */
	function electro_wrap_price_and_add_to_cart() {
		?><div class="price-add-to-cart"><?php
	}
}

if ( ! function_exists( 'electro_wrap_price_and_add_to_cart_close' ) ) {
	/**
	 * Closes product-add-to-cart wrapper
	 */
	function electro_wrap_price_and_add_to_cart_close() {
		?></div><!-- /.price-add-to-cart --><?php
	}
}

if ( ! function_exists( 'electro_wrap_product_inner_close' ) ) {
	/**
	 * Closes product-inner wrapper
	 */
	function electro_wrap_product_inner_close() {
		?></div><!-- /.product-inner --><?php
	}
}

if ( ! function_exists( 'electro_wrap_product_outer_close' ) ) {
	/**
	 * Closes product-outer wrapper
	 */
	function electro_wrap_product_outer_close() {
		?></div><!-- /.product-outer --><?php
	}
}

if ( ! function_exists( 'electro_product_media_object' ) ) {
	/**
	 * Displays product thumbnail link
	 */
	function electro_product_media_object() {

		global $product; ?>

		<a class="media-left" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
			<?php echo str_replace( 'class="', 'class="media-object ', woocommerce_get_product_thumbnail() ); ?>
		</a>

		<?php
	}
}



if ( ! function_exists( 'electro_featured_products_carousel' ) ) {
	/**
	 * Featured Products Carousel
	 */
	function electro_featured_products_carousel( $per_page , $columns = 4 ) {

		$per_page = empty( $per_page ) ? 12 : $per_page;

		$args = array(
			'per_page'	=> $per_page,
			'columns'	=> $columns
		);

		$featured = WC_Shortcodes::featured_products( $args );
		electro_products_carousel( $featured, esc_html__( 'Recommended Products', 'electro' ), $columns );
	}
}

if ( ! function_exists( 'electro_template_loop_categories' ) ) {
	/**
	 * Output Product Categories
	 *
	 */
	function electro_template_loop_categories() {
		global $product;
		$categories = $product->get_categories();
		echo apply_filters( 'electro_template_loop_categories_html', wp_kses_post( sprintf( '<span class="loop-product-categories">%s</span>', $categories ) ) );
	}
}

if ( ! function_exists( 'electro_template_loop_product_thumbnail') ) {
	/**
	 * Get the product thumbnail for the loop.
	 */
	function electro_template_loop_product_thumbnail() {
		$thumbnail = woocommerce_get_product_thumbnail();
		echo apply_filters( 'electro_template_loop_product_thumbnail', wp_kses_post( sprintf( '<div class="product-thumbnail">%s</div>', $thumbnail ) ) );
	}
}

if ( ! function_exists( 'electro_template_loop_product_single_image') ) {
	/**
	 * Get the product thumbnail for the loop.
	 */
	function electro_template_loop_product_single_image() {
		$thumbnail = woocommerce_get_product_thumbnail( 'shop_single' );
		echo apply_filters( 'electro_template_loop_product_thumbnail', wp_kses_post( sprintf( '<div class="product-thumbnail">%s</div>', $thumbnail ) ) );
	}
}

if ( ! function_exists( 'electro_shop_control_bar' ) ) {
	/**
	 * Outputs shop control bar
	 */
	function electro_shop_control_bar() {

		global $wp_query;

		if ( 1 === $wp_query->found_posts || ! woocommerce_products_will_display() ) {
			return;
		}

		?><div class="shop-control-bar">
			<?php
			/**
			 * @hooked electro_shop_view_switcher - 10
			 * @hooked woocommerce_sorting - 20
			 */
			do_action( 'electro_shop_control_bar' );
			?>
		</div><?php
	}
}

if ( ! function_exists( 'electro_shop_view_switcher' ) ) {
	/**
	 * Outputs view switcher
	 */
	function electro_shop_view_switcher() {

		global $wp_query;

		if ( 1 === $wp_query->found_posts || ! woocommerce_products_will_display() ) {
			return;
		}

		$shop_views = electro_get_shop_views();
		?>
		<ul class="shop-view-switcher nav nav-tabs" role="tablist">
		<?php foreach( $shop_views as $view_id => $shop_view ) : ?>
			<li class="nav-item"><a class="nav-link <?php $active_class = $shop_view[ 'active' ] ? 'active': ''; echo esc_attr( $active_class ); ?>" data-toggle="tab" title="<?php echo esc_attr( $shop_view[ 'label' ] ); ?>" href="#<?php echo esc_attr( $view_id );?>"><i class="<?php echo esc_attr( $shop_view[ 'icon' ] ); ?>"></i></a></li>
		<?php endforeach; ?>
		</ul>
		<?php
	}
}

if ( ! function_exists( 'electro_shop_loop' ) ) {
	/**
	 *
	 */
	function electro_shop_loop() {

		$shop_views = electro_get_shop_views();
		?>
		<div class="tab-content">
			<?php foreach( $shop_views as $view_id => $shop_view ) : ?>
			<div id="<?php echo esc_attr( $view_id ); ?>" class="tab-pane <?php $active_class = $shop_view[ 'active' ] ? 'active': ''; echo esc_attr( $active_class ); ?>" role="tabpanel">

				<?php woocommerce_product_loop_start(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( $shop_view['template']['slug'], $shop_view['template']['name'] ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_shop_control_bar_bottom' ) ) {
	/**
	 * Outputs shop control bar bottom
	 */
	function electro_shop_control_bar_bottom() {

		global $wp_query;

		if ( 1 === $wp_query->found_posts || ! woocommerce_products_will_display() ) {
			return;
		}
		?>
		<div class="shop-control-bar-bottom">
			<?php
			/**
			 * @hooked woocommerce_pagination - 20
			 */
			do_action( 'electro_shop_control_bar_bottom' );
			?>
		</div>
		<?php
	}
}



if ( ! function_exists( 'electro_brands_carousel' ) ) {
	/**
	 * Display brands carousel
	 *
	 */
	function electro_brands_carousel( $section_args = array(), $taxonomy_args = array(), $carousel_args = array() ) {

		global $electro_version;

		if( is_woocommerce_activated() ) {

			$default_section_args = array(
				'section_title'	=> ''
			);

			$default_taxonomy_args = array(
				'orderby'		=> 'title',
				'order'			=> 'ASC',
				'number'		=> 12,
				'hide_empty'	=> false
			);

			$default_carousel_args 	= array(
				'items'				=> 5,
				'navRewind'			=> true,
				'autoplayHoverPause'=> true,
				'nav'				=> true,
				'stagePadding'		=> 1,
				'dots'				=> false,
				'rtl'				=> is_rtl() ? true : false,
				'navText'			=> is_rtl() ? array( '<i class="fa fa-chevron-right"></i>', '<i class="fa fa-chevron-left"></i>' ) : array( '<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>' ),
				'touchDrag'			=> false,
				'responsive'		=> array(
					'0'		=> array( 'items'	=> 1 ),
					'480'	=> array( 'items'	=> 2 ),
					'768'	=> array( 'items'	=> 2 ),
					'992'	=> array( 'items'	=> 3 ),
					'1200'	=> array( 'items' => 5 ),
				)
			);

			$section_args 		= wp_parse_args( $section_args, $default_section_args );
			$taxonomy_args 		= wp_parse_args( $taxonomy_args, $default_taxonomy_args );
			$carousel_args 		= wp_parse_args( $carousel_args, $default_carousel_args );

			$brand_taxonomy = electro_get_brands_taxonomy();

			if( ! empty( $brand_taxonomy ) ) {

				$terms = get_terms( $brand_taxonomy, $taxonomy_args );

				if( ! is_wp_error( $terms ) && !empty( $terms ) ) {
					wp_enqueue_script( 'owl-carousel-js', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true );
					electro_get_template( 'sections/brands-carousel.php', array( 'terms' => $terms, 'section_args' => $section_args, 'carousel_args' => $carousel_args ) );
				}
			}
		}
	}
}

if ( ! function_exists( 'electro_deal_progress_bar' ) ) {
	/**
	 *
	 */
	function electro_deal_progress_bar() {
		$stock_sold 	 	= ( $total_sales = get_post_meta( get_the_ID(), 'total_sales', true ) ) ? round( $total_sales ) : 0;
		$stock_available 	= ( $stock = get_post_meta( get_the_ID(), '_stock', true ) ) ? round( $stock ) : 0;
		$percentage 		= ( $stock_available > 0 ? round( $stock_sold/$stock_available * 100 ) : 0 );
		if( $stock_available > 0 ) :
		?>
		<div class="deal-progress">
			<div class="deal-stock">
				<span class="stock-sold"><?php echo esc_html__( 'Already Sold:', 'electro' );?> <strong><?php echo esc_html( $stock_sold ); ?></strong></span>
				<span class="stock-available"><?php echo esc_html__( 'Available:', 'electro' );?> <strong><?php echo esc_html( $stock_available ); ?></strong></span>
			</div>
			<div class="progress">
				<span class="progress-bar" style="<?php echo esc_attr( 'width:' . $percentage . '%' ); ?>"><?php echo esc_html( $percentage ); ?></span>
			</div>
		</div>
		<?php
		endif;
	}
}

if ( ! function_exists( 'electro_deal_countdown_timer' ) ) {
	/**
	 *
	 */
	function electro_deal_countdown_timer( $product ) {
		$sale_price_dates_from = $sale_price_dates_to = '';
		if( $product->product_type == 'variable' ) {
			$var_sale_price_dates_from = array();
			$var_sale_price_dates_to = array();
			$available_variations = $product->get_available_variations();
			foreach ( $available_variations as $key => $available_variation ) {
				$variation_id = $available_variation['variation_id']; // Getting the variable id of just the 1st product. You can loop $available_variations to get info about each variation.
				if( $date_from = get_post_meta( $variation_id, '_sale_price_dates_from', true ) ) {
					$var_sale_price_dates_from[] = date_i18n( 'Y-m-d', $date_from );
				}
				if( $date_to =get_post_meta( $variation_id, '_sale_price_dates_to', true ) ) {
					$var_sale_price_dates_to[] = date_i18n( 'Y-m-d', $date_to );
				}
			}

			if( ! empty( $var_sale_price_dates_from ) )
				$sale_price_dates_from = min( $var_sale_price_dates_from );
			if( ! empty( $var_sale_price_dates_to ) )
				$sale_price_dates_to = max( $var_sale_price_dates_to );
		} else {
			if( $date_from = get_post_meta( $product->id, '_sale_price_dates_from', true ) ) {
				$sale_price_dates_from = date_i18n( 'Y-m-d', $date_from );
			}
			if( $date_to = get_post_meta( $product->id, '_sale_price_dates_to', true ) ) {
				$sale_price_dates_to = date_i18n( 'Y-m-d', $date_to );
			}
		}
		
		if( ! empty( $sale_price_dates_to ) ) :
		?>
		<div class="deal-countdown-timer">
			<div class="marketing-text text-xs-center">
				<?php echo apply_filters( 'electro_deal_countdown_timer_info_text', esc_html__( 'Hurry Up! Offer ends in:', 'electro' ) ); ?>
			</div>
			<span class="deal-end-date" style="display:none;"><?php echo esc_html( $sale_price_dates_to ); ?></span>
			<div class="deal-countdown countdown"></div>
		</div>
		<?php
		endif;
	}
}

if ( ! function_exists( 'electro_deal_cart_button' ) ) {
	/**
	 *
	 */
	function electro_deal_cart_button() {
		?>
		<div class="deal-cart-button">
			<?php woocommerce_template_loop_add_to_cart(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_proceed_to_checkout' ) ) {
	/**
	 * Displays Proceed to Checkout Action
	 *
	 * @return void
	 */
	function electro_proceed_to_checkout() {
		?>
		<div class="wc-proceed-to-checkout">
			<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_shipping_details_header' ) ) {
	/**
	 *
	 */
	function electro_shipping_details_header() {
		if ( true === WC()->cart->needs_shipping_address() ) : ?>
		<h3><?php echo esc_html__( 'Shipping Details', 'electro' ); ?></h3>
		<?php endif;
	}
}

if ( ! function_exists( 'electro_before_login_text' ) ) {
	/**
	 *
	 */
	function electro_before_login_text() {
		?>
		<p class="before-login-text">
			<?php echo apply_filters( 'electro_before_login_text', esc_html__( 'Welcome back! Sign in to your account', 'electro' ) ); ?>
		</p>
		<?php
	}
}

if ( ! function_exists( 'electro_before_register_text' ) ) {
	/**
	 *
	 */
	function electro_before_register_text() {
		?>
		<p class="before-register-text">
			<?php echo apply_filters( 'electro_before_register_text', esc_html__( 'Create your very own account', 'electro' ) ); ?>
		</p>
		<?php
	}
}

if ( ! function_exists( 'electro_register_benefits' ) ) {
	/**
	 *
	 */
	function electro_register_benefits() {
		$benefits = apply_filters( 'electro_register_benefits', array(
			esc_html__( 'Speed your way through checkout', 'electro' ),
			esc_html__( 'Track your orders easily', 'electro' ),
			esc_html__( 'Keep a record of all your purchases', 'electro' )
		) );

		?>
		<div class="register-benefits">
			<h3><?php echo apply_filters( 'electro_register_benefits_title', esc_html__( 'Sign up today and you will be able to :' , 'electro' ) ); ?></h3>
			<ul>
				<?php foreach ( $benefits as $benefit ) : ?>
				<li><?php echo esc_html( $benefit ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_wrap_customer_login_form' ) ) {
	/**
	 *
	 */
	function electro_wrap_customer_login_form() {

		$classes = 'customer-login-form';
		$or_text = '<span class="or-text">' . apply_filters( 'electro_or_text', esc_html__( 'or', 'electro' ) ) . '</span>';

		if ( get_option( 'woocommerce_enable_myaccount_registration' ) !== 'yes' ) {
			$classes .= ' no-registration-form';
			$or_text = '';
		}

		?>
		<div class="<?php echo esc_attr( $classes ); ?>">
		<?php
			echo wp_kses_post( $or_text );
	}
}

if ( ! function_exists( 'electro_wrap_customer_login_form_close' ) ) {
	/**
	 *
	 */
	function electro_wrap_customer_login_form_close() {
		?>
		</div><!-- /.customer-login-form -->
		<?php
	}
}

if ( ! function_exists( 'electro_wrap_track_order' ) ) {
	/**
	 *
	 *
	 */
	function electro_wrap_track_order() {
		?>
		<div class="track-order">
		<?php
	}
}

if ( ! function_exists( 'electro_wrap_track_order_close' ) ) {
	/**
	 *
	 *
	 */
	function electro_wrap_track_order_close() {
		?>
		</div><!-- /.track-order -->
		<?php
	}
}

if ( ! function_exists( 'electro_template_loop_availability' ) ) {
	/**
	 *
	 */
	function electro_template_loop_availability() {

		global $product;
		$availability = $product->get_availability();

		if ( ! empty( $availability[ 'availability'] ) ) : ?>

			<div class="availability <?php echo esc_attr( $availability['class'] ); ?>">
				<?php echo esc_html__( 'Availablity:', 'electro' );?> <span><?php echo esc_html( $availability['availability'] ); ?></span></div>

		<?php endif;
	}
}

if ( ! function_exists( 'electro_wc_review_meta' ) ) {
	/**
	 *
	 */
	function electro_wc_review_meta( $comment ) {

		if ( $comment->comment_approved == '0' ) : ?>

			<p class="meta"><em><?php _e( 'Your comment is awaiting approval', 'electro' ); ?></em></p>

		<?php else : ?>

			<p class="meta">
				<strong><?php comment_author(); ?></strong> <?php
					if ( get_option( 'woocommerce_review_rating_verification_label' ) === 'yes' )
						if ( isset( $verified ) && $verified )
							echo '<em class="verified">(' . __( 'verified owner', 'electro' ) . ')</em> ';
				?>&ndash; <time datetime="<?php echo get_comment_date( 'c' ); ?>"><?php echo get_comment_date( wc_date_format() ); ?></time>
			</p>

		<?php endif;
	}
}

if ( ! function_exists( 'electro_template_loop_rating') ) {
	function electro_template_loop_rating() {
		global $product;

		if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ){
			return;
		}
		if ( $rating_html = $product->get_rating_html() ) :
		else :
			$rating_html  = '<div class="star-rating" title="' . sprintf( __( 'Rated %s out of 5', 'electro' ), 0 ) . '">';
            $rating_html .= '<span style="width:' . ( ( 0 / 5 ) * 100 ) . '%"><strong class="rating">' . 0 . '</strong> ' . __( 'out of 5', 'electro' ) . '</span>';
            $rating_html .= '</div>';
        endif;
        $review_count = $product->get_review_count();
		?>
		<div class="product-rating">
			<?php echo wp_kses_post( $rating_html ); ?> (<?php echo esc_html( $review_count ); ?>)
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_template_loop_product_excerpt' ) ) {
	/**
	 *
	 */
	function electro_template_loop_product_excerpt() {
		global $post;

		if ( ! $post->post_excerpt ) {
			return;
		}

		?>
		<div class="product-short-description">
			<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_template_loop_product_sku' ) ) {
	/**
	 *
	 *
	 */
	function electro_template_loop_product_sku() {
		global $product;

		$sku = $product->get_sku();

		if ( empty( $sku ) ) {
			$sku = 'n/a';
		}

		?>
		<div class="product-sku"><?php echo sprintf( esc_html__( 'SKU: %s', 'electro' ), $sku ); ?></div><?php
	}
}

if ( ! function_exists( 'electro_show_wc_product_images' ) ) {
	function electro_show_wc_product_images() {

		global $post, $product, $woocommerce;

		echo '<div class="images">';

		if ( has_post_thumbnail() ) {
			$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
			$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'electro_single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> get_the_title( get_post_thumbnail_id() )
			) );

			echo apply_filters( 'electro_single_product_image_html', sprintf( '<a href="%s" class="woocommerce-main-image" title="%s">%s</a>', get_the_permalink(), $image_caption, $image ), $post->ID );

		} else {

			echo apply_filters( 'electro_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'electro' ) ), $post->ID );

		}

		$attachment_ids = $product->get_gallery_attachment_ids();

		if ( $attachment_ids ) {
			$loop 		= 0;
			$columns 	= apply_filters( 'electro_product_thumbnails_columns', 3 );
			?>
			<div class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php

				foreach ( $attachment_ids as $attachment_id ) {

					if( $loop > 3 ) {
						break;
					}

					$classes = array();

					if ( $loop === 0 || $loop % $columns === 0 )
						$classes[] = 'first';

					if ( ( $loop + 1 ) % $columns === 0 )
						$classes[] = 'last';

					$image_link = wp_get_attachment_url( $attachment_id );

					if ( ! $image_link )
						continue;

					$image_title 	= esc_attr( get_the_title( $attachment_id ) );
					$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'electro_single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
						'title'	=> $image_title,
						'alt'	=> $image_title
						) );

					$image_class = esc_attr( implode( ' ', $classes ) );

					echo apply_filters( 'electro_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s">%s</a>', get_the_permalink(), $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );

					$loop++;
				}

			?></div>
			<?php
		}

		echo '</div>';
	}
}

if ( ! function_exists( 'electro_show_product_images' ) ) {
	function electro_show_product_images() {

		if( ! is_yith_zoom_magnifier_activated() ) {
			global $post, $product, $woocommerce;

			$attachment_ids = $product->get_gallery_attachment_ids();

			echo '<div class="images electro-gallery">';

			if( count( $attachment_ids ) > 0 ) {
				$gallery = '[product-gallery]';
				if ( has_post_thumbnail() ) {
					$featured_image_id = get_post_thumbnail_id();
					array_unshift( $attachment_ids, $featured_image_id );
				}

				if ( $attachment_ids ) {
					$loop 		= 0;
					?>
					<div class="thumbnails-single owl-carousel"><?php

						foreach ( $attachment_ids as $attachment_id ) {

							$image_link = wp_get_attachment_url( $attachment_id );

							if ( ! $image_link )
								continue;

							$image_title 	= esc_attr( get_the_title( $attachment_id ) );
							$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

							$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), 0, $attr = array(
								'title'	=> $image_title,
								'alt'	=> $image_title
							) );

							$image_class = 'zoom';

							echo apply_filters( 'electro_single_product_thumbnails_single_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );

							$loop++;
						}

					?></div>
					<?php
				}

			} elseif ( has_post_thumbnail() ) {
				$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
				$image_link    = wp_get_attachment_url( get_post_thumbnail_id() );
				$image         = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
					'title'	=> get_the_title( get_post_thumbnail_id() )
				) );

				$gallery = '';

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_caption, $image ), $post->ID );

			} else {

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'electro' ) ), $post->ID );

			}

			if ( $attachment_ids ) {
				$loop 		= 0;
				$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
					?>
					<div class="thumbnails-all <?php echo 'columns-' . $columns; ?> owl-carousel"><?php

						foreach ( $attachment_ids as $attachment_id ) {

							$classes = array();

							if ( $loop === 0 || $loop % $columns === 0 )
								$classes[] = 'first';

							if ( ( $loop + 1 ) % $columns === 0 )
								$classes[] = 'last';

							$image_link = wp_get_attachment_url( $attachment_id );

							if ( ! $image_link )
								continue;

							$image_title 	= esc_attr( get_the_title( $attachment_id ) );
							$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

							$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
								'title'	=> $image_title,
								'alt'	=> $image_title
							) );

							$image_class = esc_attr( implode( ' ', $classes ) );

							echo apply_filters( 'electro_single_product_thumbnails_html', sprintf( '<a href="%s" class="%s" title="%s">%s</a>', $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );

							$loop++;
						}

					?></div>
					<?php
			}

			echo '</div>';
		}
	}
}

if ( ! function_exists( 'electro_promoted_products' ) ) {
	/**
	 * Featured and On-Sale Products
	 * Check for featured products then on-sale products and use the appropiate shortcode.
	 * If neither exist, it can fallback to show recently added products.
	 *
	 * @param integer $per_page total products to display.
	 * @param integer $columns columns to arrange products in to.
	 * @param boolean $recent_fallback Should the function display recent products as a fallback when there are no featured or on-sale products?.
	 * @uses  is_woocommerce_activated()
	 * @uses  wc_get_featured_product_ids()
	 * @uses  wc_get_product_ids_on_sale()
	 * @uses  electro_do_shortcode()
	 * @return void
	 */
	function electro_promoted_products( $per_page = '2', $columns = '2', $recent_fallback = true ) {
		if ( is_woocommerce_activated() ) {
			if ( wc_get_featured_product_ids() ) {
				echo '<section><header><h2 class="h1">' . esc_html__( 'Featured Products', 'electro' ) . '</h2></header>';
				echo electro_do_shortcode( 'featured_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
				echo '</section>';
			} elseif ( wc_get_product_ids_on_sale() ) {
				echo '<section><header><h2 class="h1">' . esc_html__( 'On Sale Now', 'electro' ) . '</h2>';
				echo electro_do_shortcode( 'sale_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
				echo '</section>';
			} elseif ( $recent_fallback ) {
				echo '<section><header><h2 class="h1">' . esc_html__( 'New In Store', 'electro' ) . '</h2>';
				echo electro_do_shortcode( 'recent_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
				echo '</section>';
			}
		}
	}
}

if ( ! function_exists( 'electro_wrap_order_review' ) ) {
	function electro_wrap_order_review() {
		?><div class="order-review-wrapper">
			<h3 id="order_review_heading_v2"><?php _e( 'Your order', 'electro' ); ?></h3><?php
	}
}

if ( ! function_exists( 'electro_wrap_order_review_close' ) ) {
	function electro_wrap_order_review_close() {
		?></div><!-- /.order-review-wrapper --><?php	
	}
}

if ( ! function_exists( 'electro_woocommerce_init_structured_data' ) ) {
	/**
	* Generate product category structured data...
	* Hooked into the `woocommerce_before_shop_loop_item` action...
	* Apply the `electro_woocommerce_structured_data` filter hook for structured data customization...
	*/
	function electro_woocommerce_init_structured_data() {
		if ( ! is_product_category() ) {
			return;
		}
		global $product;
		$json['@type']             = 'Product';
		$json['@id']               = 'product-' . get_the_ID();
		$json['name']              = get_the_title();
		$json['image']             = wp_get_attachment_url( $product->get_image_id() );
		$json['description']       = get_the_excerpt();
		$json['url']               = get_the_permalink();
		$json['sku']               = $product->get_sku();
		$json['brand']             = array(
			'@type'                  => 'Thing',
			'name'                   => $product->get_attribute( __( 'brand', 'electro' ) )
			);

		if ( $product->get_rating_count() ) {
			$json['aggregateRating'] = array(
				'@type'                => 'AggregateRating',
				'ratingValue'          => $product->get_average_rating(),
				'ratingCount'          => $product->get_rating_count(),
				'reviewCount'          => $product->get_review_count()
				);
		}

		$json['offers']            = array(
			'@type'                  => 'Offer',
			'priceCurrency'          => get_woocommerce_currency(),
			'price'                  => $product->get_price(),
			'itemCondition'          => 'http://schema.org/NewCondition',
			'availability'           => 'http://schema.org/' . $stock = ( $product->is_in_stock() ? 'InStock' : 'OutOfStock' ),
			'seller'                 => array(
				'@type'                => 'Organization',
				'name'                 => get_bloginfo( 'name' )
				)
			);

		if ( ! isset( $json ) ) {
			return;
		}

		Electro::set_structured_data( apply_filters( 'electro_woocommerce_structured_data', $json ) );
	}
}