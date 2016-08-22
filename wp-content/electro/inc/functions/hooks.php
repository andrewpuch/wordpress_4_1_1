<?php
/**
 * Electro Hooks
 *
 * @package  Electro/Functions
 */

/**
 * Setup
 */
add_action( 'after_setup_theme', 	'electro_setup',							10 );
add_action( 'after_setup_theme',	'electro_register_image_sizes', 			10 );
//add_action( 'after_setup_theme',	'electro_add_retina_filters',				10 );
add_action( 'after_setup_theme', 	'electro_template_debug_mode',				20 );
//add_action( 'after_setup_theme',	'electro_x_kses_allow_data_attributes',		30 );
add_action( 'tgmpa_register', 		'electro_register_required_plugins',		10 );
//add_action( 'admin_init', 			'electro_add_editor_styles',				10 );
add_action( 'widgets_init',			'electro_setup_sidebars',					10 );
add_action( 'widgets_init',			'electro_register_widgets',					20 );
add_action( 'init',					'electro_remove_locale_stylesheet',			10 );

/**
 * Header
 */
add_action( 'wp_enqueue_scripts',		'electro_scripts',		10 );

add_action( 'electro_before_header',	'electro_skip_links', 	0  );
add_action( 'electro_before_header',	'electro_top_bar',		10 );

add_action( 'electro_header', 			'electro_row_wrap_start', 			0  );
add_action( 'electro_header', 			'electro_header_logo',				10 );
add_action( 'electro_header', 			'electro_primary_nav',				20 );
add_action( 'electro_header', 			'electro_header_support_info',		30 );
add_action( 'electro_header', 			'electro_row_wrap_end',				40 );

add_action( 'electro_before_content',	'electro_navbar',					10 );

/**
 * Navbar
 */
add_action( 'electro_navbar',			'electro_departments_menu',			10 );
add_action( 'electro_navbar',			'electro_navbar_search',			20 );
add_action( 'electro_navbar',			'electro_navbar_compare',			50 );
add_action( 'electro_navbar',			'electro_navbar_wishlist',			40 );

/**
 * Homepage
 */
add_action( 'homepage_v1',				'electro_page_template_content',			5 );
add_action( 'homepage_v1',				'electro_home_v1_slider',					10 );
add_action( 'homepage_v1',				'electro_home_v1_ads_block',				20 );
add_action( 'homepage_v1', 				'electro_home_v1_deal_and_tabs_block',		30 );
add_action( 'homepage_v1', 				'electro_home_v1_2_1_2_block',				40 );
add_action( 'homepage_v1',				'electro_home_v1_product_cards_carousel', 	50 );
add_action( 'homepage_v1',				'electro_home_v1_ad_banner',				60 );
add_action( 'homepage_v1',				'electro_home_v1_products_carousel',		70 );

add_action( 'homepage_v2',				'electro_page_template_content',					5 );
add_action( 'homepage_v2',				'electro_home_v2_slider',							10 );
add_action( 'homepage_v2',				'electro_home_v2_ads_block',						20 );
add_action( 'homepage_v2',				'electro_home_v2_products_carousel_tabs',			30 );
add_action( 'homepage_v2',				'electro_home_v2_onsale_product',					40 );
add_action( 'homepage_v2',				'electro_home_v2_product_cards_carousel', 			50 );
add_action( 'homepage_v2',				'electro_home_v2_ad_banner',						60 );
add_action( 'homepage_v2',				'electro_home_v2_products_carousel',				70 );

add_action( 'homepage_v3',				'electro_page_template_content',					5 );
add_action( 'homepage_v3',				'electro_home_v3_slider',							10 );
add_action( 'homepage_v3',				'electro_home_v3_features_list',					20 );
add_action( 'homepage_v3',				'electro_home_v3_ads_block',						30 );
add_action( 'homepage_v3',				'electro_home_v3_products_carousel_tabs',			40 );
add_action( 'homepage_v3',				'electro_products_carousel_with_image',				50 );
add_action( 'homepage_v3',				'electro_home_v3_product_cards_carousel',			60 );
add_action( 'homepage_v3',				'electro_home_v3_6_1_block',						70 );
add_action( 'homepage_v3',				'electro_home_v3_list_categories',					80 );

add_action( 'electro_before_homepage_v1',				'electro_home_v1_hook_control',						10 );
add_action( 'electro_before_homepage_v2',				'electro_home_v2_hook_control',						10 );
add_action( 'electro_before_homepage_v3',				'electro_home_v3_hook_control',						10 );

/**
 * Sidebar
 */
add_action( 'electro_sidebar',			'electro_get_sidebar',			10 );

/**
 * Footer
 */
add_action( 'electro_before_footer', 	'electro_footer_brands_carousel', 	10 );

add_action( 'electro_footer', 			'electro_footer_widgets', 			10 );
add_action( 'electro_footer',			'electro_footer_divider',			20 );
add_action( 'electro_footer',			'electro_footer_bottom_widgets',	30 );
add_action( 'electro_footer',			'electro_copyright_bar',			40 );

add_action( 'electro_footer_contact', 	'electro_footer_logo', 				10 );
add_action( 'electro_footer_contact', 	'electro_footer_call_us', 			20 );
add_action( 'electro_footer_contact', 	'electro_footer_address', 			30 );
add_action( 'electro_footer_contact', 	'electro_footer_social_icons', 		40 );

add_action( 'electro_footer_divider',	'electro_footer_newsletter',		10 );

add_action( 'electro_default_footer_bottom_widgets', 'electro_default_fb_widgets', 20 );
