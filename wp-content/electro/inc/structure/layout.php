<?php
/**
 * Layout related functions
 *
 * @package Electro/Structure
 */

if ( ! function_exists( 'electro_get_page_layout_args' ) ) {
	function electro_get_page_layout_args() {

		$args = array();

		if ( is_woocommerce_activated() && is_product() ) {
			$args['layout_name'] = electro_get_single_product_layout();
		}

		return $args;
	}
}

if ( ! function_exists( 'electro_content_wrapper_start' ) ) {
	/**
	 * Display electro content wrapper
	 * 
	 */
	function electro_content_wrapper_start() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main">
		<?php
	}
}

if ( ! function_exists( 'electro_content_wrapper_end' ) ) {
	/**
	 * Display electro content wrapper
	 * 
	 */
	function electro_content_wrapper_end() {
		
		$layout 	= electro_get_blog_layout();
		$sidebar 	= electro_get_sidebar_area();
	?>
		</main>
	</div><!-- /#primary -->

	<?php 
		if ( 'left-sidebar' === $layout || 'right-sidebar' === $layout ) {
			do_action( 'electro_sidebar', $sidebar );
		}
	}
}

if ( ! function_exists( 'electro_get_sidebar_area' ) ) {
	function electro_get_sidebar_area() {
		return apply_filters( 'electro_sidebar_area', 'blog' );
	}
}

if ( ! function_exists( 'electro_get_blog_layout' ) ) {
	function electro_get_blog_layout() {
		return apply_filters( 'electro_blog_layout', 'right-sidebar' );
	}
}

if ( ! function_exists( 'electro_get_blog_style' ) ) {
	function electro_get_blog_style() {
		return apply_filters( 'electro_blog_style', 'blog-default' );
	}
}

if ( ! function_exists( 'electro_get_single_post_layout' ) ) {
	function electro_get_single_post_layout() {
		return apply_filters( 'electro_single_post_layout', 'right-sidebar' );
	}
}

if ( ! function_exists( 'electro_get_sidebar' ) ) {
	/**
	 * Display electro sidebar
	 * @uses get_sidebar()
	 * 
	 */
	function electro_get_sidebar( $name = null ) {
		get_sidebar( $name );
	}
}

if ( ! function_exists( 'electro_init_structured_data' ) ) {
	/**
	 * Generate the structured data...
	 * Initialize Electro::$structured_data via Electro::set_structured_data()...
	 * Hooked into:
	 * `electro_loop_post`
	 * `electro_single_post`
	 * `electro_page`
	 * Apply `electro_structured_data` filter hook for structured data customization :)
	 */
	function electro_init_structured_data() {
		if ( is_home() || is_category() || is_date() || is_search() || is_single() && ( is_woocommerce_activated() && ! is_woocommerce() ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'normal' );
			$logo  = apply_filters( 'electro_logo_image_src', wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ) );

			$json['@type']            = 'BlogPosting';
			$json['mainEntityOfPage'] = array(
				'@type'                 => 'webpage',
				'@id'                   => get_the_permalink(),
			);
			$json['image']            = array(
				'@type'                 => 'ImageObject',
				'url'                   => $image[0],
				'width'                 => $image[1],
				'height'                => $image[2],
			);
			$json['publisher']        = array(
				'@type'                 => 'organization',
				'name'                  => get_bloginfo( 'name' ),
				'logo'                  => array(
					'@type'               => 'ImageObject',
					'url'                 => $logo[0],
					'width'               => $logo[1],
					'height'              => $logo[2],
				),
			);

			$json['author']           = array(
				'@type'                 => 'person',
				'name'                  => get_the_author(),
			);
			$json['datePublished']    = get_post_time( 'c' );
			$json['dateModified']     = get_the_modified_date( 'c' );
			$json['name']             = get_the_title();
			$json['headline']         = get_the_title();
			$json['description']      = get_the_excerpt();
		} elseif ( is_page() ) {
			$json['@type']            = 'WebPage';
			$json['url']              = get_the_permalink();
			$json['name']             = get_the_title();
			$json['description']      = get_the_excerpt();
		}
		if ( isset( $json ) ) {
			Electro::set_structured_data( apply_filters( 'electro_structured_data', $json ) );
		}
	}
}