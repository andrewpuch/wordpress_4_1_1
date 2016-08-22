<?php
/**
 * Redux Framework functions
 *
 * @package Electro/ReduxFramework
 */

/**
 * Setup functions for theme options
 */

/**
 * Enqueues font awesome for Redux Theme Options
 * 
 * @return void
 */
function redux_queue_font_awesome() {
    wp_register_style(
		'redux-font-awesome',
		get_template_directory_uri() . '/assets/css/font-awesome.min.css',
		array(),
		time(),
		'all'
    );
    wp_enqueue_style( 'redux-font-awesome' );
}

/**
 * Disables Demo mode of Redux Framework
 * 
 * @return void
 */
function redux_remove_demo_mode() { // Be sure to rename this function to something more unique
    remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
}

/**
 * Gets product attribute taxonomies
 * 
 * @return array
 */
function redux_get_product_attr_taxonomies() {

	$product_attr_taxonomies = array();

	if( function_exists( 'electro_get_product_attr_taxonomies' ) ) {
		$product_attr_taxonomies = electro_get_product_attr_taxonomies();
	}

	return $product_attr_taxonomies;
}

require_once get_template_directory() . '/inc/redux-framework/functions/general-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/blog-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/header-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/footer-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/shop-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/navigation-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/style-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/typography-functions.php';
require_once get_template_directory() . '/inc/redux-framework/functions/custom-code-functions.php';