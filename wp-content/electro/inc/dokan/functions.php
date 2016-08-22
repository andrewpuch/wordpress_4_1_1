<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'electro_dokan_scripts' ) ) {
	function electro_dokan_scripts() {
		global $electro_version;

		if ( apply_filters( 'electro_use_predefined_colors', true ) ) {
			wp_dequeue_style( 'electro-color' );
		}

		// Dequeue Fontawesome
		wp_dequeue_style( 'fontawesome' );
		wp_register_style( 'ec-fontawesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );
		wp_enqueue_style( 'ec-fontawesome' );
		
		wp_enqueue_style( 'electro-dokan-style', get_template_directory_uri() . '/assets/css/dokan.css', '', $electro_version );

		if ( apply_filters( 'electro_use_predefined_colors', true ) ) {
			$color_css_file = apply_filters( 'electro_primary_color', 'yellow' );
			wp_enqueue_style( 'electro-color', get_template_directory_uri() . '/assets/css/colors/' . $color_css_file . '.min.css', '', $electro_version );
		}
	}
}

if( ! function_exists( 'electro_get_dokan_store_sidebar' ) ) {
	function electro_get_dokan_store_sidebar() {
		$store_user   = get_userdata( get_query_var( 'author' ) );
		$store_info   = dokan_get_store_info( $store_user->ID );
		$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';

		if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) { ?>
			<div role="complementary" class="sidebar" id="sidebar">
				<div id="dokan-secondary" class="dokan-clearfix dokan-store-sidebar" role="complementary">
					<div class="dokan-widget-area widget-collapse">
						<?php do_action( 'dokan_sidebar_store_before', $store_user, $store_info ); ?>
						<?php
						if ( ! dynamic_sidebar( 'sidebar-store' ) ) {

							$args = array(
								'before_widget' => '<aside class="widget">',
								'after_widget'  => '</aside>',
								'before_title'  => '<h3 class="widget-title">',
								'after_title'   => '</h3>',
							);

							if ( class_exists( 'Dokan_Store_Location' ) ) {
								the_widget( 'Dokan_Store_Category_Menu', array( 'title' => __( 'Store Category', 'electro' ) ), $args );

								if ( dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on' ) {
									the_widget( 'Dokan_Store_Location', array( 'title' => __( 'Store Location', 'electro' ) ), $args );
								}

								if ( dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
									the_widget( 'Dokan_Store_Contact_Form', array( 'title' => __( 'Contact Seller', 'electro' ) ), $args );
								}
							}

						}
						?>

						<?php do_action( 'dokan_sidebar_store_after', $store_user, $store_info ); ?>
					</div>
				</div>
			</div><!-- #secondary .widget-area -->
		<?php
		} else {
			get_sidebar( 'store' );
		}
	}
}

if ( ! function_exists( 'electro_dokan_after_wc_content' ) ) {
	function electro_dokan_after_wc_content() {
		if( dokan_is_store_page() ){
			electro_get_dokan_store_sidebar();
		}
	}
}

if ( ! function_exists( 'electro_dokan_toggle_shop_sidebar' ) ) {
	function electro_dokan_toggle_shop_sidebar( $has_sidebar ) {
		if( dokan_is_store_page() ){
			$has_sidebar = false;
		}

		return $has_sidebar;
	}
}

if ( ! function_exists( 'electro_setup_dokan_sidebars' ) ) {
	/**
	 * Setup Sidebars available in Electro
	 */
	function electro_setup_dokan_sidebars() {
		// Store Sidebar
		register_sidebar( apply_filters( 'electro_register_store_sidebar_args', array(
			'name'          => esc_html__( 'Store Sidebar', 'electro' ),
			'id'            => 'store-sidebar-widgets',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) ) );
	}
}

if( ! function_exists( 'electro_dokan_body_classes' ) ) {
	function electro_dokan_body_classes( $classes ) {
		if( dokan_is_store_page() ) {
			$layout = electro_get_blog_layout();
			if( ( $key = array_search( $layout, $classes ) ) !== false ) {
				unset($classes[$key]);
			}

			$classes[] = apply_filters( 'electro_dokan_sidebar_layout_class', 'left-sidebar' );
		}

		return $classes;
	}
}