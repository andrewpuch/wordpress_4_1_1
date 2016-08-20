<?php
/**
 * Options available for Header sub menu of Theme Options
 * 
 */

$header_options 	= apply_filters( 'electro_header_options_args', array(
	'title'		=> esc_html__( 'Header', 'electro' ),
	'icon'		=> 'fa fa-arrow-circle-o-up',
	'fields'	=> array(
		array(
			'id'        => 'header_top_bar_show',
			'title'     => esc_html__( 'Show Top Bar', 'electro' ),
			'type'      => 'switch',
			'default'   => 1,
		),

		array(
			'title'		=> esc_html__( 'Your Logo', 'electro' ),
			'subtitle'	=> esc_html__( 'Upload your header logo image.', 'electro' ),
			'id'		=> 'site_header_logo',
			'type'		=> 'media',
		),
		
		array(
			'title'		=> esc_html__('Header Style', 'electro'),
			'subtitle'	=> esc_html__('Select the header style.', 'electro'),
			'id'		=> 'header_style',
			'type'		=> 'select',
			'options'	=> array(
				'v1'		=> esc_html__( 'Header v1', 'electro' ),
				'v2'		=> esc_html__( 'Header v2', 'electro' ),
				'v3'		=> esc_html__( 'Header v3', 'electro' ),
				'v4'		=> esc_html__( 'Header v4', 'electro' ),
			),
			'default'   => 'v2',
		),

		array(
			'title'		=> esc_html__( 'Sticky Header', 'electro' ),
			'id'		=> 'sticky_header',
			'type'		=> 'switch',
			'on'		=> esc_html__('Enabled', 'electro'),
			'off'		=> esc_html__('Disabled', 'electro'),
			'default'	=> 0,
			'required'  => array( 'header_style', 'equals' , array( 'v2', 'v3', 'v4' ) ),
		),

		array(
			'id'		=> 'header_vertical_menu_title',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Vertical Menu Title', 'electro' ),
			'default'	=> esc_html__( 'All Departments', 'electro' ),
		),

		array(
			'id'		=> 'header_vertical_menu_icon',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Vertical Menu Icon', 'electro' ),
			'default'	=> 'fa fa-list-ul',
		),

		array(
			'id'		=> 'header_departments_menu_title',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Header v2 "All Departments" menu title', 'electro' ),
			'default'	=> esc_html__( 'Shop By Department', 'electro' ),
		),

		array(
			'id'		=> 'header_navbar_search_placeholder',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Navbar Search Placeholder', 'electro' ),
			'default'	=> esc_html__( 'Search for Products', 'electro' ),
		),

		array(
			'id'        => 'enable_header_navbar_search_dropdown',
			'type'      => 'switch',
			'title'     => esc_html__( 'Show Search Categories dropdown', 'electro' ),
			'default'   => 1,
		),

		array(
			'id'        => 'header_navbar_search_dropdown_categories',
			'type'      => 'select',
			'title'     => esc_html__( 'Search Category Dropdown', 'electro' ),
			'options'   => array(
				'show_only_top_level' => esc_html__( 'Include only top level categories', 'electro' ),
				'show_all'            => esc_html__( 'Include all categories', 'electro' ),
			),
			'default'   => 'show_only_top_level',
			'required'  => array( 'enable_header_navbar_search_dropdown', 'equals', 1 ),
		),

		array(
			'id'		=> 'header_navbar_search_dropdown_text',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Navbar Search default dropdown text', 'electro' ),
			'default'	=> esc_html__( 'All Categories', 'electro' ),
			'required'  => array( 'enable_header_navbar_search_dropdown', 'equals', 1 ),
		),

		array(
			'id'        => 'header_support_block_show',
			'title'     => esc_html__( 'Show Header Support Block', 'electro' ),
			'type'      => 'switch',
			'default'   => 1,
		),
		
		array(
			'id'		=> 'header_support_number',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Header Support Number', 'electro' ),
			'default'	=> '<strong>Support</strong> (+800) 856 800 604',
			'required'  => array( 'header_support_block_show', 'equals' , 1 ),
		),
		
		array(
			'id'		=> 'header_support_email',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Header Support Email', 'electro' ),
			'default'	=> 'Email: info@electro.com',
			'required'  => array( 'header_support_block_show', 'equals' , 1 ),
		),
	)
) );