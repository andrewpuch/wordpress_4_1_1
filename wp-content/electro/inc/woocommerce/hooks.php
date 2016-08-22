<?php
/**
 * Electro WooCommerce Hooks
 *
 * @package  Electro/WooCommerce
 */

/**
 * Setup WooCommerce
 */
add_action( 'after_setup_theme', 							'electro_product_category_taxonomy_fields',		10 );
add_action( 'after_setup_theme', 							'electro_setup_brands_taxonomy',				10 );

/**
 * Layout
 */
remove_action( 'woocommerce_before_main_content', 			'woocommerce_breadcrumb', 						20, 0 );
remove_action( 'woocommerce_before_main_content', 			'woocommerce_output_content_wrapper', 			10 );
remove_action( 'woocommerce_after_main_content', 			'woocommerce_output_content_wrapper_end', 		10 );
remove_action( 'woocommerce_sidebar', 						'woocommerce_get_sidebar', 						10 );
add_action( 'woocommerce_before_main_content', 				'electro_before_wc_content', 					10 );
add_action( 'woocommerce_before_main_content', 				'electro_before_product_archive_content', 		20 );
add_action( 'woocommerce_before_main_content',				'electro_shop_archive_jumbotron',				50 );
add_action( 'woocommerce_after_main_content', 				'electro_after_wc_content', 					10 );

/**
 * Navbar
 */
add_action( 'electro_navbar', 								'electro_navbar_mini_cart', 					30 );

add_action( 'electro_header_v1',							'electro_navbar_mini_cart',						30 );
add_action( 'electro_header_v3',							'electro_navbar_mini_cart',						30 );

/**
 * Product Archive
 */
remove_action( 'woocommerce_before_shop_loop', 				'woocommerce_result_count', 					20 );
remove_action( 'woocommerce_before_shop_loop', 				'woocommerce_catalog_ordering', 				30 );
remove_action( 'woocommerce_after_shop_loop',				'woocommerce_pagination',						10 );
add_action( 'woocommerce_before_shop_loop', 				'electro_product_subcategories', 				0  );
add_action( 'woocommerce_before_shop_loop',					'electro_wc_loop_title',						10 );
add_action( 'woocommerce_before_shop_loop',					'electro_shop_control_bar',						11 );
add_action( 'woocommerce_before_shop_loop',					'electro_reset_woocommerce_loop', 				90 );
add_action( 'electro_before_product_archive_content',		'electro_featured_products_carousel',			10 );
add_action( 'electro_shop_control_bar',						'electro_shop_view_switcher',					10 );
add_action( 'electro_shop_control_bar',						'woocommerce_catalog_ordering',					20 );
add_action( 'electro_shop_control_bar',						'electro_wc_products_per_page',					30 );
add_action( 'electro_shop_control_bar',						'electro_advanced_pagination',					40 );
add_action( 'woocommerce_after_shop_loop',					'electro_shop_control_bar_bottom',				90 );
add_action( 'electro_shop_control_bar_bottom',				'electro_wc_products_per_page',					10 );
add_action( 'electro_shop_control_bar_bottom',				'woocommerce_result_count',						20 );
add_action( 'electro_shop_control_bar_bottom',				'woocommerce_pagination',						30 );

/**
 * Product Item
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 	'woocommerce_show_product_loop_sale_flash', 	10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 	'woocommerce_template_loop_product_thumbnail', 	10 );
remove_action( 'woocommerce_after_shop_loop_item_title',	'woocommerce_template_loop_rating',				5  );
remove_action( 'woocommerce_after_shop_loop_item_title', 	'woocommerce_template_loop_price', 				10 );
add_action( 'woocommerce_before_shop_loop_item',			'electro_wrap_product_outer',					0  );
add_action( 'woocommerce_before_shop_loop_item',			'electro_wrap_product_inner',					0  );
add_action( 'woocommerce_before_shop_loop_item',			'electro_template_loop_categories',				5  );
add_action( 'woocommerce_after_shop_loop_item_title', 		'electro_template_loop_product_thumbnail', 		5  );
add_action( 'woocommerce_after_shop_loop_item',				'electro_wrap_price_and_add_to_cart',			6  );
add_action( 'woocommerce_after_shop_loop_item',				'woocommerce_template_loop_price',				8  );
add_action( 'woocommerce_after_shop_loop_item',				'electro_wrap_price_and_add_to_cart_close',		15 );
add_action( 'woocommerce_after_shop_loop_item',				'electro_template_loop_hover',					20 );
add_action( 'woocommerce_after_shop_loop_item',				'electro_wrap_product_inner_close',				30 );
add_action( 'woocommerce_after_shop_loop_item',				'electro_wrap_product_outer_close',				40 );
add_action( 'electro_product_item_hover_area',				'electro_loop_action_buttons',					10 );

add_action( 'woocommerce_shop_loop',						'electro_shop_loop',							10 );

/**
 * Product Grid Extended
 */
add_action( 'electro_wc_before_grid_extended_shop_loop_item',			'electro_wrap_product_outer',					0  );
add_action( 'electro_wc_before_grid_extended_shop_loop_item',			'electro_wrap_product_inner',					0  );
add_action( 'electro_wc_before_grid_extended_shop_loop_item',			'electro_template_loop_categories',				5  );
add_action( 'electro_wc_before_grid_extended_shop_loop_item',			'woocommerce_template_loop_product_link_open',  10 );

add_action( 'electro_wc_grid_extended_shop_loop_item_title', 			'woocommerce_template_loop_product_title', 		10 );

add_action( 'electro_wc_after_grid_extended_shop_loop_item_title', 		'electro_template_loop_product_thumbnail', 		5  );

add_action( 'electro_wc_after_grid_extended_shop_loop_item', 			'electro_template_loop_rating', 				5  );
add_action( 'electro_wc_after_grid_extended_shop_loop_item', 			'electro_template_loop_product_excerpt', 		10 );
add_action( 'electro_wc_after_grid_extended_shop_loop_item', 			'electro_template_loop_product_sku', 			20 );
add_action( 'electro_wc_after_grid_extended_shop_loop_item',			'woocommerce_template_loop_product_link_close',	25 );


add_action( 'electro_wc_after_grid_extended_shop_loop_item',			'electro_wrap_price_and_add_to_cart',			30 );
add_action( 'electro_wc_after_grid_extended_shop_loop_item',			'woocommerce_template_loop_price',				40 );
add_action( 'electro_wc_after_grid_extended_shop_loop_item', 			'woocommerce_template_loop_add_to_cart', 		50 );
add_action( 'electro_wc_after_grid_extended_shop_loop_item',			'electro_wrap_price_and_add_to_cart_close',		60 );

add_action( 'electro_wc_after_grid_extended_shop_loop_item',			'electro_template_loop_hover',					70 );
add_action( 'electro_wc_after_grid_extended_shop_loop_item',			'electro_wrap_product_inner_close',				80 );
add_action( 'electro_wc_after_grid_extended_shop_loop_item',			'electro_wrap_product_outer_close',				90 );

/**
 * Product List View
 */


add_action( 'electro_wc_before_list_view_shop_loop_item_title',			'woocommerce_template_loop_product_link_open',  10 );
add_action( 'electro_wc_before_list_view_shop_loop_item_title',			'woocommerce_template_loop_product_thumbnail',	20 );
add_action( 'electro_wc_before_list_view_shop_loop_item_title',			'woocommerce_template_loop_product_link_close',	30 );

add_action( 'electro_wc_list_view_shop_loop_item_title',				'electro_template_loop_categories',				10 );
add_action( 'electro_wc_list_view_shop_loop_item_title',				'woocommerce_template_loop_product_link_open',	20 );
add_action( 'electro_wc_list_view_shop_loop_item_title', 				'woocommerce_template_loop_product_title', 		30 );
add_action( 'electro_wc_list_view_shop_loop_item_title', 				'electro_template_loop_rating', 				40 );
add_action( 'electro_wc_list_view_shop_loop_item_title', 				'electro_template_loop_product_excerpt', 		50 );
add_action( 'electro_wc_list_view_shop_loop_item_title',				'woocommerce_template_loop_product_link_close',	65 );

add_action( 'electro_wc_after_list_view_shop_loop_item_title',			'electro_template_loop_availability',			10 );
add_action( 'electro_wc_after_list_view_shop_loop_item_title',			'woocommerce_template_loop_price',				20 );
add_action( 'electro_wc_after_list_view_shop_loop_item_title', 			'woocommerce_template_loop_add_to_cart', 		30 );
add_action( 'electro_wc_after_list_view_shop_loop_item_title',			'electro_template_loop_hover', 					40 );

/**
 * Product List Small View
 */


add_action( 'electro_wc_before_list_small_view_shop_loop_item_title',		'woocommerce_template_loop_product_link_open',  10 );
add_action( 'electro_wc_before_list_small_view_shop_loop_item_title',		'woocommerce_template_loop_product_thumbnail',	20 );
add_action( 'electro_wc_before_list_small_view_shop_loop_item_title',		'woocommerce_template_loop_product_link_close',	30 );

add_action( 'electro_wc_list_small_view_shop_loop_item_title',				'electro_template_loop_categories',				10 );
add_action( 'electro_wc_list_small_view_shop_loop_item_title',				'woocommerce_template_loop_product_link_open',	20 );
add_action( 'electro_wc_list_small_view_shop_loop_item_title', 				'woocommerce_template_loop_product_title', 		30 );
add_action( 'electro_wc_list_small_view_shop_loop_item_title', 				'electro_template_loop_product_excerpt', 		40 );
add_action( 'electro_wc_list_small_view_shop_loop_item_title', 				'electro_template_loop_rating', 				50 );
add_action( 'electro_wc_list_small_view_shop_loop_item_title',				'woocommerce_template_loop_product_link_close',	65 );

add_action( 'electro_wc_after_list_small_view_shop_loop_item_title',		'electro_wrap_price_and_add_to_cart',			10 );
add_action( 'electro_wc_after_list_small_view_shop_loop_item_title',		'woocommerce_template_loop_price',				20 );
add_action( 'electro_wc_after_list_small_view_shop_loop_item_title', 		'woocommerce_template_loop_add_to_cart', 		30 );
add_action( 'electro_wc_after_list_small_view_shop_loop_item_title',		'electro_wrap_price_and_add_to_cart_close',		40 );
add_action( 'electro_wc_after_list_small_view_shop_loop_item_title',		'electro_template_loop_hover', 					50 );

/**
 * Product Card View
 */
add_action( 'electro_before_card_view',						'electro_wrap_product_outer', 					10 );
add_action( 'electro_before_product_card_view_body',		'electro_product_media_object', 				10 );
add_action( 'electro_product_card_view_body',				'electro_template_loop_categories',				10 );
add_action( 'electro_product_card_view_body',				'woocommerce_template_loop_product_link_open',	20 );
add_action( 'electro_product_card_view_body',				'woocommerce_template_loop_product_title',		30 );
add_action( 'electro_product_card_view_body',				'woocommerce_template_loop_product_link_close',	40 );
add_action( 'electro_product_card_view_body',				'electro_wrap_price_and_add_to_cart',			50 );
add_action( 'electro_product_card_view_body',				'woocommerce_template_loop_price',				60 );
add_action( 'electro_product_card_view_body',				'woocommerce_template_loop_add_to_cart',		70 );
add_action( 'electro_product_card_view_body',				'electro_wrap_price_and_add_to_cart_close',		80 );
add_action( 'electro_product_card_view_body',				'electro_template_loop_hover',					90 );
add_action( 'electro_after_card_view',						'electro_wrap_product_outer_close', 			10 );

/**
 * Single Product
 */
remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_price',			10 );
remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_add_to_cart',		30 );
remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_meta',				40 );
remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_sharing',			50 );
remove_action( 'woocommerce_before_single_product_summary',	'woocommerce_show_product_images',				20 );
remove_action( 'woocommerce_after_single_product_summary',  'woocommerce_output_related_products',          20 );

add_action( 'woocommerce_before_single_product',			'electro_toggle_single_product_hooks',			10 );

add_filter( 'electro_show_shop_sidebar',					'electro_toggle_shop_sidebar',					10 );
add_filter( 'woocommerce_product_thumbnails_columns',		'electro_product_thumbnails_columns',			10 );

add_action( 'woocommerce_before_single_product_summary',	'electro_wrap_single_product',					0  );
add_action( 'woocommerce_before_single_product_summary',	'electro_wrap_product_images',					5  );
add_action( 'woocommerce_before_single_product_summary',	'electro_show_product_images',					20 );
add_action( 'woocommerce_before_single_product_summary',	'electro_wrap_product_images_close',			30 );

add_action( 'woocommerce_single_product_summary', 			'electro_template_loop_categories',				1  );
add_action( 'woocommerce_single_product_summary',			'electro_template_single_brand',				10 );
add_action( 'woocommerce_single_product_summary',			'electro_template_loop_availability',			10 );
add_action( 'woocommerce_single_product_summary',			'electro_template_single_divider',				11 );
add_action( 'woocommerce_single_product_summary',			'electro_loop_action_buttons',					15 );
add_action( 'woocommerce_single_product_summary',			'woocommerce_template_single_sharing',			15 );
add_action( 'woocommerce_single_product_summary',			'woocommerce_template_single_price',			25 );
add_action( 'woocommerce_single_product_summary',			'electro_template_single_add_to_cart',			30 );

add_action( 'woocommerce_after_single_product_summary',		'electro_wrap_single_product_close',			1  );
add_action( 'woocommerce_after_single_product_summary',     'electro_output_related_products',              20 );
add_action( 'woocommerce_review_after_comment_text',		'electro_wc_review_meta',						10 );

/**
 * Product On Sale
 */
add_action( 'electro_onsale_product_content',				'woocommerce_template_loop_product_link_open',	10 );
add_action( 'electro_onsale_product_content',				'electro_template_loop_product_thumbnail',		20 );
add_action( 'electro_onsale_product_content',				'woocommerce_template_loop_product_title',		30 );
add_action( 'electro_onsale_product_content',				'woocommerce_template_loop_product_link_close',	40 );
add_action( 'electro_onsale_product_content',				'woocommerce_template_loop_price',				50 );
add_action( 'electro_onsale_product_content',				'electro_deal_progress_bar',					60 );
add_action( 'electro_onsale_product_content',				'electro_deal_countdown_timer',					70 );

/**
 * Product On Sale Carousel
 */

add_action( 'electro_onsale_product_carousel_content',		'woocommerce_template_loop_product_link_open',	10 );
add_action( 'electro_onsale_product_carousel_content',		'woocommerce_template_loop_product_title',		20 );
add_action( 'electro_onsale_product_carousel_content',		'woocommerce_template_loop_product_link_close',	30 );
add_action( 'electro_onsale_product_carousel_content',		'woocommerce_template_loop_price',				40 );
add_action( 'electro_onsale_product_carousel_content',		'electro_deal_progress_bar',					50 );
add_action( 'electro_onsale_product_carousel_content',		'electro_deal_countdown_timer',					60 );
add_action( 'electro_onsale_product_carousel_content',		'electro_deal_cart_button',						70 );

/**
 * Product Carousel Alt
 */

add_action( 'electro_product_carousel_alt_content',			'woocommerce_template_loop_product_link_open',	10 );
add_action( 'electro_product_carousel_alt_content',			'electro_template_loop_product_thumbnail',		20 );
add_action( 'electro_product_carousel_alt_content',			'woocommerce_template_loop_product_link_close',	25 );
add_action( 'electro_product_carousel_alt_content',			'electro_template_loop_categories',				30 );
add_action( 'electro_product_carousel_alt_content',			'woocommerce_template_loop_product_link_open',	35 );
add_action( 'electro_product_carousel_alt_content',			'woocommerce_template_loop_product_title',		40 );
add_action( 'electro_product_carousel_alt_content',			'woocommerce_template_loop_product_link_close',	50 );
add_action( 'electro_product_carousel_alt_content',			'woocommerce_template_loop_price',				60 );

/**
 * Cart Page
 */
add_action( 'woocommerce_cart_actions',						'electro_proceed_to_checkout' );

/**
 * Checkout Page
 */
add_action( 'woocommerce_checkout_shipping',				'electro_shipping_details_header',				0 );
add_action( 'woocommerce_checkout_before_order_review',     'electro_wrap_order_review',                    0 );
add_action( 'woocommerce_checkout_after_order_review',      'electro_wrap_order_review_close',              0 );

/**
 * My Account Page
 */
add_action( 'woocommerce_before_customer_login_form',		'electro_wrap_customer_login_form',				0  );
add_action( 'woocommerce_after_customer_login_form',		'electro_wrap_customer_login_form_close',		0  );
add_action( 'woocommerce_login_form_start',					'electro_before_login_text',					10 );
add_action( 'woocommerce_register_form_start',				'electro_before_register_text',					10 );
add_action( 'woocommerce_register_form_end',				'electro_register_benefits',					10 );

/**
 * Order Tracking
 */
add_action( 'woocommerce_track_order',						'electro_wrap_track_order',						0  );
add_action( 'woocommerce_view_order',						'electro_wrap_track_order_close',				PHP_INT_MAX );

/**
 * Products Live Search
 */
add_action( 'wp_ajax_nopriv_products_live_search',			'electro_products_live_search' );
add_action( 'wp_ajax_products_live_search',					'electro_products_live_search' );

/**
 * Footer
 */
add_action( 'electro_default_footer_widgets', 				'electro_default_wc_footer_widgets', 			10 );
add_action( 'electro_default_footer_bottom_widgets', 		'electro_default_wc_fb_widgets', 				10 );

/**
 * Filters
 */
add_filter( 'woocommerce_enqueue_styles', 					'__return_empty_array' );
add_filter( 'woocommerce_breadcrumb_defaults', 				'electro_change_breadcrumb_delimiter' );
add_filter( 'loop_shop_columns',							'electro_set_loop_shop_columns', 				10 );
add_filter( 'loop_shop_per_page', 							'electro_set_loop_shop_per_page', 				20 );
add_filter( 'woocommerce_pagination_args',					'electro_set_pagination_args',					10 );
add_filter( 'woocommerce_get_price_html_from_to',			'electro_get_price_html_from_to',				10, 4 );
add_filter( 'woocommerce_get_price_html',					'electro_wrap_price_html',						90 );
add_filter( 'woocommerce_add_to_cart_fragments',			'electro_mini_cart_fragment' );

/**
 * Structured Data
 *
 * @see electro_woocommerce_init_structured_data()
 */
add_action( 'woocommerce_before_shop_loop_item', 			'electro_woocommerce_init_structured_data' );