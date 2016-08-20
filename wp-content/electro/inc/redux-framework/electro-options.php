<?php
if ( ! class_exists( 'ReduxFramework' ) ) {
	return;
}

if ( ! class_exists( 'Electro_Options' ) ) {

	class Electro_Options {

		public function __construct( ) {
			add_action( 'after_setup_theme', array( $this, 'load_config' ) );
		}

		public function load_config() {

			$options 		= array( 'general', 'shop', 'header', 'footer', 'navigation', 'blog', 'social', 'style', 'typography', 'custom-code' );
			$options_dir 	= get_template_directory() . '/inc/redux-framework/options';

			foreach ( $options as $option ) {
				$options_file = $option . '-options.php';
				require_once $options_dir . '/' . $options_file ;
			}

			$sections 	= apply_filters( 'electro_options_sections_args', array( $general_options, $shop_options, $header_options, $footer_options, $navigation_options, $blog_options, $social_options, $style_options, $typography_options, $custom_code_options ) );
			$theme 		= wp_get_theme();
			$args 		= array(
				'opt_name'          => 'electro_options',
				'display_name'      => $theme->get( 'Name' ),
				'display_version'   => $theme->get( 'Version' ),
				'allow_sub_menu'    => true,
				'menu_title'        => esc_html__( 'Electro', 'electro' ),
				'google_api_key'    => 'AIzaSyDDZJO4F0d17RnFoi1F2qtw4wn6Wcaqxao',
				'page_priority'     => 3,
				'page_slug'         => 'theme_options',
				'intro_text'        => '',
				'dev_mode'          => false,
				'customizer'        => true,
				'footer_credit'     => '&nbsp;',
			);

			$ReduxFramework = new ReduxFramework( $sections, $args );
		}
	}

	new Electro_Options();
}

if( ! array_key_exists( 'electro_options' , $GLOBALS ) ) {
	$GLOBALS['electro_options'] = get_option( 'electro_options', array() );
}