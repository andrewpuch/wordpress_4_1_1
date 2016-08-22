<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts',					'electro_dokan_scripts', 				11 );

add_action( 'woocommerce_after_main_content', 		'electro_dokan_after_wc_content', 		11 );

add_filter( 'electro_show_shop_sidebar', 			'electro_dokan_toggle_shop_sidebar', 	100 );

add_action( 'widgets_init',							'electro_setup_dokan_sidebars',			10 );

add_filter( 'body_class',							'electro_dokan_body_classes',			100 );