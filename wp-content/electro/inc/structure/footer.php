<?php
/**
 * Template functions used in footer
 */

if ( ! function_exists( 'electro_footer_widgets' ) ) {
	/**
	 * Displays Footer Widgets
	 */
	function electro_footer_widgets() {
		if( apply_filters( 'electro_footer_widgets', true  ) ) {
			?>
			<div class="footer-widgets">
				<div class="container">
					<div class="row">
					<?php
						if ( is_active_sidebar( 'footer-widgets' ) ) {

							dynamic_sidebar( 'footer-widgets' );

						} else {

							$footer_widget_args = apply_filters( 'electro_footer_widget_args', array(
								'before_widget' => '<div class="col-lg-4 col-md-4 col-xs-12"><aside class="widget clearfix"><div class="body">',
								'after_widget'  => '</div></aside></div>',
								'before_title'  => '<h4 class="widget-title">',
								'after_title'   => '</h4>',
								'widget_id'     => '',
							) );

							do_action( 'electro_default_footer_widgets', $footer_widget_args );
						}
					?>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'electro_footer_divider' ) ) {
	/**
	 * Area that divides electro footer and footer bottom widgets
	 */
	function electro_footer_divider() {
		/**
		 * @hooked electro_footer_newsletter - 10
		 */
		do_action( 'electro_footer_divider' );
	}
}

if ( ! function_exists( 'electro_footer_newsletter' ) ) {
	/**
	 * Electro Footer Newsletter
	 */
	function electro_footer_newsletter() {

		if( apply_filters( 'electro_footer_newsletter', true  ) ) {
			$footer_newsletter_title 			= apply_filters( 'electro_footer_newsletter_title', esc_html__( 'Sign up to Newsletter', 'electro' ) );
			$footer_newsletter_marketing_text 	= apply_filters( 'electro_footer_newsletter_marketing_text', __( '...and receive <strong>$20 coupon for first shopping</strong>', 'electro' ) );

			?>
			<div class="footer-newsletter">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-7">

							<h5 class="newsletter-title"><?php echo esc_html( $footer_newsletter_title ); ?></h5>

							<?php if ( ! empty( $footer_newsletter_marketing_text ) ) : ?>

							<span class="newsletter-marketing-text"><?php echo wp_kses_post( $footer_newsletter_marketing_text ); ?></span>

							<?php endif; ?>

						</div>
						<div class="col-xs-12 col-sm-5">

							<?php footer_newsletter_form(); ?>

						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'footer_newsletter_form' ) ) {
	/**
	 * Electro Footer Newsletter Form
	 */
	function footer_newsletter_form() {
		ob_start();
		?>
		<form>
			<div class="input-group">
				<input type="text" class="form-control" placeholder="<?php echo esc_attr( __( 'Enter your email address', 'electro' ) ); ?>">
				<span class="input-group-btn">
					<button class="btn btn-secondary" type="button"><?php echo esc_html( __( 'Sign Up', 'electro' ) ); ?></button>
				</span>
			</div>
		</form>
		<?php
		$footer_newsletter_form = ob_get_clean();
		echo apply_filters( 'electro_footer_newsletter_form', $footer_newsletter_form );
	}
}

if ( ! function_exists( 'electro_footer_contact_info' ) ) {
	/**
	 * Electro Contact Info Block at the footer
	 */
	function electro_footer_contact() {

		/**
		 * @hooked electro_footer_logo - 10
		 * @hooked electro_footer_call_us - 20
		 * @hooked electro_footer_address - 30
		 * @hooked electro_footer_social_icons - 40
		 */
		do_action( 'electro_footer_contact' );
	}
}

if ( ! function_exists( 'electro_footer_logo' ) ) {
	/**
	 * Displays Electro Logo at the footer contact
	 */
	function electro_footer_logo() {

		if ( apply_filters( 'electro_footer_logo', true ) ) {

			ob_start();
			?>
			<div class="footer-logo">
				<svg version="1.1" x="0px" y="0px" width="156px"
					height="37px" viewBox="0 0 175.748 42.52" enable-background="new 0 0 175.748 42.52">
					<ellipse fill-rule="evenodd" clip-rule="evenodd" fill="#FDD700" cx="170.05" cy="36.341" rx="5.32" ry="5.367"/>
					<path fill-rule="evenodd" clip-rule="evenodd" fill="#333E48" d="M30.514,0.71c-0.034,0.003-0.066,0.008-0.056,0.056
					C30.263,0.995,29.876,1.181,29.79,1.5c-0.148,0.548,0,1.568,0,2.427v36.459c0.265,0.221,0.506,0.465,0.725,0.734h6.187
					c0.2-0.25,0.423-0.477,0.669-0.678V1.387C37.124,1.185,36.9,0.959,36.701,0.71H30.514z M117.517,12.731
					c-0.232-0.189-0.439-0.64-0.781-0.734c-0.754-0.209-2.039,0-3.121,0h-3.176V4.435c-0.232-0.189-0.439-0.639-0.781-0.733
					c-0.719-0.2-1.969,0-3.01,0h-3.01c-0.238,0.273-0.625,0.431-0.725,0.847c-0.203,0.852,0,2.399,0,3.725
					c0,1.393,0.045,2.748-0.055,3.725h-6.41c-0.184,0.237-0.629,0.434-0.725,0.791c-0.178,0.654,0,1.813,0,2.765v2.766
					c0.232,0.188,0.439,0.64,0.779,0.733c0.777,0.216,2.109,0,3.234,0c1.154,0,2.291-0.045,3.176,0.057v21.277
					c0.232,0.189,0.439,0.639,0.781,0.734c0.719,0.199,1.969,0,3.01,0h3.01c1.008-0.451,0.725-1.889,0.725-3.443
					c-0.002-6.164-0.047-12.867,0.055-18.625h6.299c0.182-0.236,0.627-0.434,0.725-0.79c0.176-0.653,0-1.813,0-2.765V12.731z
					 M135.851,18.262c0.201-0.746,0-2.029,0-3.104v-3.104c-0.287-0.245-0.434-0.637-0.781-0.733c-0.824-0.229-1.992-0.044-2.898,0
					c-2.158,0.104-4.506,0.675-5.74,1.411c-0.146-0.362-0.451-0.853-0.893-0.96c-0.693-0.169-1.859,0-2.842,0h-2.842
					c-0.258,0.319-0.625,0.42-0.725,0.79c-0.223,0.82,0,2.338,0,3.443c0,8.109-0.002,16.635,0,24.381
					c0.232,0.189,0.439,0.639,0.779,0.734c0.707,0.195,1.93,0,2.955,0h3.01c0.918-0.463,0.725-1.352,0.725-2.822V36.21
					c-0.002-3.902-0.242-9.117,0-12.473c0.297-4.142,3.836-4.877,8.527-4.686C135.312,18.816,135.757,18.606,135.851,18.262z
					 M14.796,11.376c-5.472,0.262-9.443,3.178-11.76,7.056c-2.435,4.075-2.789,10.62-0.501,15.126c2.043,4.023,5.91,7.115,10.701,7.9
					c6.051,0.992,10.992-1.219,14.324-3.838c-0.687-1.1-1.419-2.664-2.118-3.951c-0.398-0.734-0.652-1.486-1.616-1.467
					c-1.942,0.787-4.272,2.262-7.134,2.145c-3.791-0.154-6.659-1.842-7.524-4.91h19.452c0.146-2.793,0.22-5.338-0.279-7.563
					C26.961,15.728,22.503,11.008,14.796,11.376z M9,23.284c0.921-2.508,3.033-4.514,6.298-4.627c3.083-0.107,4.994,1.976,5.685,4.627
					C17.119,23.38,12.865,23.38,9,23.284z M52.418,11.376c-5.551,0.266-9.395,3.142-11.76,7.056
					c-2.476,4.097-2.829,10.493-0.557,15.069c1.997,4.021,5.895,7.156,10.646,7.957c6.068,1.023,11-1.227,14.379-3.781
					c-0.479-0.896-0.875-1.742-1.393-2.709c-0.312-0.582-1.024-2.234-1.561-2.539c-0.912-0.52-1.428,0.135-2.23,0.508
					c-0.564,0.262-1.223,0.523-1.672,0.676c-4.768,1.621-10.372,0.268-11.537-4.176h19.451c0.668-5.443-0.419-9.953-2.73-13.037
					C61.197,13.388,57.774,11.12,52.418,11.376z M46.622,23.343c0.708-2.553,3.161-4.578,6.242-4.686
					c3.08-0.107,5.08,1.953,5.686,4.686H46.622z M160.371,15.497c-2.455-2.453-6.143-4.291-10.869-4.064
					c-2.268,0.109-4.297,0.65-6.02,1.524c-1.719,0.873-3.092,1.957-4.234,3.217c-2.287,2.519-4.164,6.004-3.902,11.007
					c0.248,4.736,1.979,7.813,4.627,10.326c2.568,2.439,6.148,4.254,10.867,4.064c4.457-0.18,7.889-2.115,10.199-4.684
					c2.469-2.746,4.012-5.971,3.959-11.063C164.949,21.134,162.732,17.854,160.371,15.497z M149.558,33.952
					c-3.246-0.221-5.701-2.615-6.41-5.418c-0.174-0.689-0.26-1.25-0.4-2.166c-0.035-0.234,0.072-0.523-0.045-0.77
					c0.682-3.698,2.912-6.257,6.799-6.547c2.543-0.189,4.258,0.735,5.52,1.863c1.322,1.182,2.303,2.715,2.451,4.967
					C157.789,30.669,154.185,34.267,149.558,33.952z M88.812,29.55c-1.232,2.363-2.9,4.307-6.13,4.402
					c-4.729,0.141-8.038-3.16-8.025-7.563c0.004-1.412,0.324-2.65,0.947-3.726c1.197-2.061,3.507-3.688,6.633-3.612
					c3.222,0.079,4.966,1.708,6.632,3.668c1.328-1.059,2.529-1.948,3.9-2.99c0.416-0.315,1.076-0.688,1.227-1.072
					c0.404-1.031-0.365-1.502-0.891-2.088c-2.543-2.835-6.66-5.377-11.704-5.137c-6.02,0.288-10.218,3.697-12.484,7.846
					c-1.293,2.365-1.951,5.158-1.729,8.408c0.209,3.053,1.191,5.496,2.619,7.508c2.842,4.004,7.385,6.973,13.656,6.377
					c5.976-0.568,9.574-3.936,11.816-8.354c-0.141-0.271-0.221-0.604-0.336-0.902C92.929,31.364,90.843,30.485,88.812,29.55z"/>
				</svg>
			</div>
			<?php
			echo apply_filters( 'electro_footer_logo_html', ob_get_clean() );
		}
	}
}

if ( ! function_exists( 'electro_footer_call_us' ) ) {
	/**
	 * Displays Call Us text in Footer contact
	 */
	function electro_footer_call_us() {

		$call_us_text 	= apply_filters( 'electro_call_us_text', __( 'Got Questions ? Call us 24/7!', 'electro' ) );
		$call_us_number = apply_filters( 'electro_call_us_number', '(800) 8001-8588, (0600) 874 548' );
		$call_us_icon 	= apply_filters( 'electro_call_us_icon'	, 'ec ec-support' );

		if ( apply_filters( 'electro_footer_call_us', true ) && ! empty( $call_us_number ) ) : ?>

			<div class="footer-call-us">
				<div class="media">
					<span class="media-left call-us-icon media-middle"><i class="<?php echo esc_html( $call_us_icon ); ?>"></i></span>
					<div class="media-body">
						<span class="call-us-text"><?php echo esc_html( $call_us_text ); ?></span>
						<span class="call-us-number"><?php echo esc_html( $call_us_number ); ?></span>
					</div>
				</div>
			</div>

		<?php endif;
	}
}

if ( ! function_exists( 'electro_footer_address' ) ) {
	/**
	 * Displays shop address at the footer
	 */
	function electro_footer_address() {

		// Default values and can be overwritten either via filters or via Theme Options
		$footer_address_title 	= apply_filters( 'electro_footer_address_title', __( 'Contact info', 'electro' ) );
		$footer_address 		= apply_filters( 'electro_footer_address_content', __( '17 Princess Road, London, Greater London NW1 8JR, UK', 'electro' ) );

		if ( apply_filters( 'electro_footer_address', true ) && ! empty( $footer_address ) ) : ?>

			<div class="footer-address">
				<strong class="footer-address-title"><?php echo esc_html( $footer_address_title ); ?></strong>
				<address><?php echo wp_kses_post( nl2br( $footer_address ) ); ?></address>
			</div>

		<?php endif;
	}
}

if ( ! function_exists( 'electro_footer_social_icons' ) ) {
	/**
	 * Displays social icons at the footer
	 */
	function electro_footer_social_icons() {

		$social_networks 		= apply_filters( 'electro_set_social_networks', electro_get_social_networks() );
		$social_links_output 	= '';
		$social_link_html		= apply_filters( 'electro_footer_social_link_html', '<a class="%1$s" href="%2$s"></a>' );

		foreach ( $social_networks as $social_network ) {
			if ( isset( $social_network[ 'link' ] ) && !empty( $social_network[ 'link' ] ) ) {
				$social_links_output .= sprintf( '<li>' . $social_link_html . '</li>', $social_network[ 'icon' ], $social_network[ 'link' ] );
			}
		}

		if ( apply_filters( 'electro_footer_social_icons', true ) && ! empty( $social_links_output ) ) {

			ob_start();
			?>
			<div class="footer-social-icons">
				<ul class="social-icons list-unstyled">
					<?php echo wp_kses_post( $social_links_output ); ?>
				</ul>
			</div>
			<?php
			echo apply_filters( 'electro_footer_social_links_html', ob_get_clean() );
		}
	}
}

if ( ! function_exists( 'electro_footer_bottom_widgets' ) ) {
	/**
	 * Displays Footer Bottom Widgets & Footer Contact Block
	 */
	function electro_footer_bottom_widgets() {
		$show_footer_bottom_widgets = apply_filters( 'electro_show_footer_bottom_widgets', true );
		$show_footer_contact_block  = apply_filters( 'electro_enable_footer_contact_block', true );

		if ( $show_footer_bottom_widgets || $show_footer_contact_block ) : ?>
		
		<div class="footer-bottom-widgets">
			<div class="container">
				<?php if ( $show_footer_contact_block ) : ?>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7 col-md-push-5">
					<?php electro_display_footer_bottom_widgets(); ?>
					</div>
					<div class="footer-contact col-xs-12 col-sm-12 col-md-5 col-md-pull-7">
						<?php electro_footer_contact(); ?>
					</div>
				</div>
				<?php else : ?>
					<?php electro_display_footer_bottom_widgets(); ?>
				<?php endif; ?>
			</div>
		</div><?php

		endif;
	}
}

if ( ! function_exists( 'electro_display_footer_bottom_widgets' ) ) {
	/**
	 * Displays footer bottome widgets
	 */
	function electro_display_footer_bottom_widgets() {
		if ( apply_filters( 'electro_show_footer_bottom_widgets', true ) ) {
			if ( is_active_sidebar( 'footer-bottom-widgets' ) ) {
				dynamic_sidebar( 'footer-bottom-widgets' );
			} else {
				if ( apply_filters( 'electro_show_default_footer_bottom_widgets', true ) ) {
					$footer_bottom_widget_args = apply_filters( 'electro_footer_bottom_widget_args', array(
						'before_widget' => '<div class="columns"><aside class="widget clearfix"><div class="body">',
						'after_widget'  => '</div></aside></div>',
						'before_title'  => '<h4 class="widget-title">',
						'after_title'   => '</h4>',
						'widget_id'     => '',
					) );
					do_action( 'electro_default_footer_bottom_widgets', $footer_bottom_widget_args );
				}
			}
		}
	}
}

if ( ! function_exists( 'electro_default_fb_widgets' ) ) {
	/**
	 * Displays default footer bottom widgets
	 */
	function electro_default_fb_widgets( $args ) {

		$args['widget_id'] = 'meta-footer';
		the_widget( 'WP_Widget_Meta', array( 'title' => '&nbsp;' ), $args );

		$args['widget_id'] = 'pages-widget-footer-bottom';
		the_widget( 'WP_Widget_Pages', array( 'title' => __( 'Customer Care', 'electro') ), $args );
	}
}


if ( ! function_exists( 'electro_copyright_bar' ) ) {
	/**
	 * Displays the copyright bar
	 */
	function electro_copyright_bar() {

		$website_title_with_url 	= sprintf( '<a href="%s">%s</a>', esc_url( home_url( '/' ) ), get_bloginfo( 'name' ) );
		$footer_copyright_text 		= apply_filters( 'electro_footer_copyright_text', sprintf( __( '&copy; %s - All Rights Reserved', 'electro' ), $website_title_with_url ) );
		$credit_card_icons 			= apply_filters( 'electro_footer_credit_card_icons', '' );

		if ( apply_filters( 'electro_enable_footer_credit_block', true ) ) : ?>
		
		<div class="copyright-bar">
			<div class="container">
				<div class="pull-left flip copyright"><?php echo wp_kses_post( $footer_copyright_text ); ?></div>
				<div class="pull-right flip payment"><?php echo wp_kses_post( $credit_card_icons ); ?></div>
			</div>
		</div><?php
		
		endif;
	}
}

if ( ! function_exists( 'electro_footer_brands_carousel' ) ) {
	/**
	 * Display brands carousel on footer
	 *
	 */
	function electro_footer_brands_carousel(){
		if( function_exists( 'electro_brands_carousel' ) && apply_filters( 'electro_footer_brands_carousel', true ) ) {
			$no_of_brands  = apply_filters( 'electro_footer_brands_number', 12 );
			
			$section_args  = apply_filters( 'ec_footer_bc_section_args', array() );
			$taxonomy_args = apply_filters( 'ec_footer_bc_taxonomy_args', array(
				'number'  => $no_of_brands
			) );
			$carousel_args = apply_filters( 'ec_footer_bc_carousel_args', array() );
			
			electro_brands_carousel( $section_args, $taxonomy_args, $carousel_args );
		}
	}
}
