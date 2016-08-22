<?php
/**
 * Redux Framworks hooks
 *
 * @package Electro/ReduxFramework
 */
add_action( 'init', 									'redux_remove_demo_mode' );
add_action( 'redux/page/electro_options/enqueue', 		'redux_queue_font_awesome' );

//General Filters
add_filter( 'electro_enable_scrollup',					'redux_toggle_scrollup',						10 );
add_filter( 'electro_register_image_sizes',				'redux_toggle_register_image_size',				10 );
add_filter( 'electro_load_child_theme',                 'redux_toggle_electro_child_style',             10 );

// Shop Filters
add_filter( 'electro_shop_catalog_mode',				'redux_toggle_shop_catalog_mode',				10 );
add_filter( 'woocommerce_loop_add_to_cart_link',		'redux_apply_catalog_mode_for_product_loop',	10, 2 );
add_filter( 'electro_shop_views_args',                  'redux_set_shop_view_args',                     10 );
add_filter( 'electro_shop_layout',						'redux_apply_shop_layout',						10 );
add_filter( 'electro_shop_loop_subcategories_columns',	'redux_apply_shop_loop_subcategories_columns',	10 );
add_filter( 'electro_shop_loop_products_columns',		'redux_apply_shop_loop_products_columns',		10 );
add_filter( 'electro_loop_shop_per_page',				'redux_apply_shop_loop_per_page',				10 );
add_filter( 'electro_single_product_layout',			'redux_apply_single_product_layout',			10 );
add_filter( 'electro_single_product_layout_style',		'redux_apply_single_product_layout_style',		10 );
add_filter( 'electro_enable_related_products',          'redux_toggle_related_products_output',         10 );
add_filter( 'electro_product_brand_taxonomy',			'redux_apply_product_brand_taxonomy',			10 );
add_filter( 'electro_product_comparison_page_id',		'redux_apply_product_comparison_page_id',		10 );
add_filter( 'electro_shop_jumbotron_id',				'redux_apply_shop_jumbotron_id',				10 );
add_filter( 'electro_sticky_order_review',				'redux_toggle_sticky_payment_box',				10 );

// Header Filters
add_filter( 'electro_enable_top_bar',                   'redux_toggle_top_bar',                         10 );
add_filter( 'electro_header_logo_html',					'redux_apply_header_logo',						10 );
add_filter( 'electro_logo_image_src',                   'redux_apply_logo_image_src',                   10 );
add_filter( 'electro_header_style',						'redux_apply_header_style',						10 );
add_filter( 'electro_vertical_menu_title', 				'redux_apply_header_vertical_menu_title',       10 );
add_filter( 'electro_vertical_menu_icon',               'redux_apply_header_vertical_menu_icon',        10 );
add_filter( 'electro_departments_menu_title',           'redux_apply_departments_menu_title',           10 );
add_filter( 'electro_navbar_search_placeholder',        'redux_apply_navbar_search_placeholder',        10 );
add_filter( 'electro_enable_search_categories_filter',  'redux_toggle_header_search_dropdown',          10 );
add_filter( 'electro_search_categories_filter_args',    'redux_modify_search_dropdown_categories_args', 10 );
add_filter( 'electro_navbar_search_dropdown_text',      'redux_apply_navbar_search_dropdown_text',      10 );
add_filter( 'electro_show_header_support_info',         'redux_toggle_header_support_block',            10 );
add_filter( 'electro_header_support_number',			'redux_apply_header_support_number',			10 );
add_filter( 'electro_header_support_email',				'redux_apply_header_support_email',				10 );
add_filter( 'electro_enable_sticky_header',				'redux_toggle_sticky_header',					10 );
add_filter( 'electro_enable_live_search',				'__return_true' );

// Footer Filters
add_filter( 'electro_footer_brands_carousel',			'redux_toggle_footer_brands_carousel',			10 );
add_filter( 'electro_footer_brands_number',             'redux_apply_footer_brands_number',             10 );
add_filter( 'electro_footer_widgets',					'redux_toggle_footer_widgets',					10 );
add_filter( 'electro_footer_newsletter',				'redux_toggle_footer_newsletter',				10 );
add_filter( 'electro_footer_newsletter_title',			'redux_apply_footer_newsletter_title',			10 );
add_filter( 'electro_footer_newsletter_marketing_text',	'redux_apply_footer_newsletter_marketing_text',	10 );
add_filter( 'electro_footer_newsletter_form',			'redux_apply_footer_newsletter_form',			10 );
add_filter( 'electro_footer_logo',						'redux_toggle_footer_logo',						10 );
add_filter( 'electro_footer_logo_html',					'redux_apply_footer_logo',						10 );
add_filter( 'electro_footer_call_us',					'redux_toggle_electro_footer_call_us',			10 );
add_filter( 'electro_call_us_text',						'redux_apply_footer_call_us_text',				10 );
add_filter( 'electro_call_us_number',					'redux_apply_footer_call_us_number',			10 );
add_filter( 'electro_call_us_icon',						'redux_apply_footer_call_us_icon',				10 );
add_filter( 'electro_footer_address',					'redux_toggle_footer_address',					10 );
add_filter( 'electro_footer_address_title',				'redux_apply_footer_address_title',				10 );
add_filter( 'electro_footer_address_content',			'redux_apply_footer_address_content',			10 );
add_filter( 'electro_footer_copyright_text',			'redux_apply_footer_copyright_text',			10 );
add_filter( 'electro_footer_credit_card_icons',			'redux_apply_footer_credit_icons',				10 );
add_filter( 'electro_footer_social_icons',				'redux_toggle_footer_social_icons',				10 );
add_filter( 'electro_get_social_networks',				'redux_apply_social_networks',					10 );
add_filter( 'electro_enable_footer_contact_block',      'redux_toggle_footer_contact_block',            10 );
add_filter( 'electro_show_footer_bottom_widgets',       'redux_toggle_footer_bottom_widgets',           10 );
add_filter( 'electro_enable_footer_credit_block',       'redux_toggle_footer_credit_block',             10 );

add_filter( 'wp_head',                              'redux_apply_footer_bottom_widgets_column_spacing', 10 );

// Navigation Filters
add_filter( 'electro_primary-nav_dropdown_trigger',		'redux_apply_dropdown_trigger',					10, 2 );
add_filter( 'electro_navbar-primary_dropdown_trigger',	'redux_apply_dropdown_trigger',					10, 2 );
add_filter( 'electro_topbar-left_dropdown_trigger',		'redux_apply_dropdown_trigger',					10, 2 );
add_filter( 'electro_topbar-right_dropdown_trigger',	'redux_apply_dropdown_trigger',					10, 2 );

// Blog Filters
add_filter( 'electro_blog_style',						'redux_apply_blog_page_view',					10 );
add_filter( 'electro_blog_layout',						'redux_apply_blog_page_layout',					10 );
add_filter( 'electro_single_post_layout',				'redux_apply_single_post_layout',				10 );
add_filter( 'electro_loop_post_placeholder_img',		'redux_toggle_post_placeholder_img',			10 );

// Style Filters
add_filter( 'electro_use_predefined_colors',			'redux_toggle_use_predefined_colors',			10 );
add_action( 'electro_primary_color',					'redux_apply_primary_color', 					10 );
add_action( 'wp_head',									'redux_apply_custom_color_css',                 100 );
add_action( 'wp_enqueue_scripts',                       'redux_load_external_custom_css',               20 );
add_filter( 'electro_should_add_custom_css_page',       'redux_toggle_custom_css_page',                 10 );

// Typography Filters
add_filter( 'electro_load_default_fonts',				'redux_has_google_fonts',						10 );
add_action( 'wp_head',									'redux_apply_custom_fonts',						100 );

// Custom Code Filters
add_action( 'wp_head',									'redux_apply_custom_css', 						200 );