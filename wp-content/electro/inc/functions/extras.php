<?php
/**
 * Additional functions used by the theme
 */

/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function electro_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;
	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	if ( $tag == 'products' && ! isset( $atts['orderby'] ) ) {
		$atts['orderby'] = 'post__in';
	}
	
	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

if ( ! function_exists( 'is_electro_customizer_enabled' ) ) {
	/**
	 * Check whether the Electro Customizer settings are enabled
	 * @return boolean
	 */
	function is_electro_customizer_enabled() {
		return apply_filters( 'electro_customizer_enabled', true );
	}
}

if ( ! function_exists( 'electro_page_menu_args' ) ) {
	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 *
	 * @param array $args Configuration arguments.
	 * @return array
	 */
	function electro_page_menu_args( $args ) {
		$args['show_home'] = true;
		return $args;
	}
}

if ( ! function_exists( 'electro_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	function electro_body_classes( $classes ) {
		
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Check if woocommerce breadcrumb is available
		if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
			$classes[]	= 'no-wc-breadcrumb';
		}

		$layout_args = electro_get_page_layout_args();

		if( isset( $layout_args['layout_name'] ) ) {
			$classes[] = $layout_args['layout_name'];
		}

		if( isset( $layout_args['body_classes'] ) ) {
			$classes[] = $layout_args['body_classes'];
		}

		/**
		 * What is this?!
		 * Take the blue pill, close this file and forget you saw the following code.
		 * Or take the red pill, filter electro_make_me_cute and see how deep the rabbit hole goes...
		 */
		$cute	= apply_filters( 'electro_make_me_cute', false );

		if ( true === $cute ) {
			$classes[] = 'electro-cute';
		}

		return $classes;
	}
}

/**
 * Enables template debug mode
 */
function electro_template_debug_mode() {
	if ( ! defined( 'ELECTRO_TEMPLATE_DEBUG_MODE' ) ) {
		$status_options = get_option( 'woocommerce_status_options', array() );
		if ( ! empty( $status_options['template_debug_mode'] ) && current_user_can( 'manage_options' ) ) {
			define( 'ELECTRO_TEMPLATE_DEBUG_MODE', true );
		} else {
			define( 'ELECTRO_TEMPLATE_DEBUG_MODE', false );
		}
	}
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */

function electro_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array( $args ) ) {
		extract( $args );
	}

	$located = electro_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
		return;
	}

	// Allow 3rd party plugin filter template file from their plugin
	$located = apply_filters( 'electro_get_template', $located, $template_name, $args, $template_path, $default_path );

	do_action( 'electro_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'electro_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function electro_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	if ( ! $template_path ) {
		$template_path = 'templates/';
	}

	if ( ! $default_path ) {
		$default_path = 'templates/';
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template || ELECTRO_TEMPLATE_DEBUG_MODE ) {
		$template = $default_path . $template_name;
	}

	// Return what we found
	return apply_filters( 'electro_locate_template', $template, $template_name, $template_path );
}

if ( ! function_exists( 'electro_get_social_networks' ) ) {
	/**
	 * List of all available social networks
	 *
	 * @return array array of all social networks and its details
	 */
	function electro_get_social_networks() {
		return apply_filters( 'electro_get_social_networks', array(
			'facebook' 		=> array(
				'label'	=> esc_html__( 'Facebook', 'electro' ),
				'icon'	=> 'fa fa-facebook',
				'id'	=> 'facebook_link',
				'link'	=> '#',
			),
			'twitter' 		=> array(
				'label'	=> esc_html__( 'Twitter', 'electro' ),
				'icon'	=> 'fa fa-twitter',
				'id'	=> 'twitter_link',
				'link'	=> '#',
			),
			'pinterest' 	=> array(
				'label'	=> esc_html__( 'Pinterest', 'electro' ),
				'icon'	=> 'fa fa-pinterest',
				'id'	=> 'pinterest_link',
				'link'	=> '#',
			),
			'linkedin' 		=> array(
				'label'	=> esc_html__( 'LinkedIn', 'electro' ),
				'icon'	=> 'fa fa-linkedin',
				'id'	=> 'linkedin_link',
				'link'	=> '#',
			),
			'googleplus' 	=> array(
				'label'	=> esc_html__( 'Google+', 'electro' ),
				'icon'	=> 'fa fa-google-plus',
				'id'	=> 'googleplus_link',
				'link'	=> '#',
			),
			'tumblr' 	=> array(
				'label'	=> esc_html__( 'Tumblr', 'electro' ),
				'icon'	=> 'fa fa-tumblr',
				'id'	=> 'tumblr_link'
			),
			'instagram' 	=> array(
				'label'	=> esc_html__( 'Instagram', 'electro' ),
				'icon'	=> 'fa fa-instagram',
				'id'	=> 'instagram_link'
			),
			'youtube' 		=> array(
				'label'	=> esc_html__( 'Youtube', 'electro' ),
				'icon'	=> 'fa fa-youtube',
				'id'	=> 'youtube_link'
			),
			'vimeo' 		=> array(
				'label'	=> esc_html__( 'Vimeo', 'electro' ),
				'icon'	=> 'fa fa-vimeo-square',
				'id'	=> 'vimeo_link'
			),
			'dribbble' 		=> array(
				'label'	=> esc_html__( 'Dribbble', 'electro' ),
				'icon'	=> 'fa fa-dribbble',
				'id'	=> 'dribbble_link',
				'link'	=> '#',
			),
			'stumbleupon' 	=> array(
				'label'	=> esc_html__( 'StumbleUpon', 'electro' ),
				'icon'	=> 'fa fa-stumbleupon',
				'id'	=> 'stumble_upon_link'
			),
			'rss'			=> array(
				'label'	=> esc_html__( 'RSS', 'electro' ),
				'icon'	=> 'fa fa-rss',
				'id'	=> 'rss_link',
				'link'	=> get_bloginfo( 'rss2_url' ),
			)
		) );
	}
}

/**
 * Query WooCommerce activation
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	function is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}

if ( ! function_exists( 'is_dokan_activated' ) ) {
	function is_dokan_activated() {
		return class_exists( 'WeDevs_Dokan' ) ? true : false;
	}
}

/**
 * Check if Visual Composer is activated
 */
if( ! function_exists( 'is_vc_activated' ) ) {
	function is_vc_activated() {
		return class_exists( 'WPBakeryVisualComposerAbstract' ) ? true : false;
	}
}

/**
 * Check if Redux Framework is activated
 */
if( ! function_exists( 'is_redux_activated' ) ) {
	function is_redux_activated() {
		return class_exists( 'ReduxFrameworkPlugin' ) ? true : false;
	}	
}

/**
 * Query WooCommerce Extension Activation.
 * @var  $extension main extension class name
 * @return boolean
 */
function is_woocommerce_extension_activated( $extension ) {

	if( is_woocommerce_activated() ) {
		$is_activated = class_exists( $extension ) ? true : false;
	} else {
		$is_activated = false;
	}
	
	return $is_activated;
}

/**
 * Checks if YITH Wishlist is activated
 *
 * @return boolean
 */
if( ! function_exists( 'is_yith_wcwl_activated' ) ) {
	function is_yith_wcwl_activated() {
		return is_woocommerce_extension_activated( 'YITH_WCWL' );
	}
}

/**
 * Checks if YITH WooCompare is activated
 *
 * @return boolean
 */
if( ! function_exists( 'is_yith_woocompare_activated' ) ) {
	function is_yith_woocompare_activated() {
		return is_woocommerce_extension_activated( 'YITH_Woocompare' );
	}
}

/**
 * Checks if YITH WooCommerce Zoom Magnifier is activated
 *
 * @return boolean
 */
if( ! function_exists( 'is_yith_zoom_magnifier_activated' ) ) {
	function is_yith_zoom_magnifier_activated() {
		return is_woocommerce_extension_activated( 'YITH_WooCommerce_Zoom_Magnifier' );
	}
}

/**
 * Checks if WPML is activated
 *
 * @return  boolean
 */
if( ! function_exists( 'is_wpml_activated' ) ) {
	function is_wpml_activated() {
		return function_exists( 'icl_object_id' );
	}
}

if ( ! function_exists( 'is_yith_wcan_activated' ) ) {
	function is_yith_wcan_activated() {
		return function_exists( 'YITH_WCAN' );
	}
}

/**
 * Checks if Revslider is activated
 *
 * @return  boolean
 */
if( ! function_exists( 'is_revslider_activated' ) ) {
	function is_revslider_activated() {
		return function_exists( 'putRevSlider' );
	}
}

/**
 * Clean variables using sanitize_text_field.
 * @param string|array $var
 * @return string|array
 */
function electro_clean( $var ) {
	return is_array( $var ) ? array_map( 'electro_clean', $var ) : sanitize_text_field( $var );
}

/**
 * Clean variables using wp_kses_post.
 * @param string|array $var
 * @return string|array
 */
function electro_clean_kses_post( $var ) {
	return is_array( $var ) ? array_map( 'electro_clean_kses_post', $var ) : wp_kses_post( stripslashes( $var ) );
}

if ( ! function_exists( 'pr' ) ) {
	function pr( $var ) {
		echo '<pre>' . print_r( $var, 1 ) . '</pre>';
	}
}

/*function electro_x_kses_allow_data_attributes() {
  global $allowedposttags;
	$tags = array( 'a' );
	$new_attributes = array(
		'data-product_sku'	=> true,
		'data-product_id'	=> true,
		'data-product-id'	=> true,
		'data-product-type'	=> true,
		'data-quantity'		=> true,
	);
	foreach ( $tags as $tag ) {
		if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) ) {
			$allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
		}
	}
}*/

add_filter( 'wp_kses_allowed_html', 'electro_add_data_attr', 10, 2 );

function electro_add_data_attr( $allowed, $context ) {
	
	if ( is_array( $context ) ) {
		return $allowed;
	}

	if ( $context === 'post' ) {
		$allowed['a']['data-product_sku']	= true;
		$allowed['a']['data-product_id']	= true;
		$allowed['a']['data-product-id']	= true;
		$allowed['a']['data-product-type']	= true;
		$allowed['a']['data-quantity']	    = true;
	}
	return $allowed;
}