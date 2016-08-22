<?php
/**
 * Load assets
 *
 * @author      Transvelo
 * @category    Admin
 * @package     Electro/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Electro_Admin_Assets' ) ) :

/**
 * Electro_Admin_Assets Class.
 */
class Electro_Admin_Assets {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function admin_styles() {
		global $wp_scripts, $electro_version;

		$screen         = get_current_screen();
		$screen_id      = $screen ? $screen->id : '';
		$jquery_version = isset( $wp_scripts->registered['jquery-ui-core']->ver ) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';

		// Register admin styles
		wp_register_style( 'electro_admin_styles', get_template_directory_uri() . '/assets/css/admin/electro-admin.css', array(), $electro_version );
		//wp_register_style( 'jquery-ui-style', '//code.jquery.com/ui/' . $jquery_version . '/themes/smoothness/jquery-ui.css', array(), $jquery_version );
		wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), $electro_version );
		
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'electro_admin_styles' );
	}

	/**
	 * Enqueue scripts.
	 */
	public function admin_scripts() {
		global $wp_query, $post, $electro_version;

		$screen       = get_current_screen();
		$screen_id    = $screen ? $screen->id : '';
		$ec_screen_id = sanitize_title( __( 'Electro', 'electro' ) );
		$suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$suffix = '';

		wp_register_script( 'electro-admin-meta-boxes', get_template_directory_uri() . '/assets/js/admin/meta-boxes' . $suffix . '.js', array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-sortable'), $electro_version );

		wp_enqueue_script( 'electro-admin-meta-boxes' );		
	}
}
endif;

return new Electro_Admin_Assets();