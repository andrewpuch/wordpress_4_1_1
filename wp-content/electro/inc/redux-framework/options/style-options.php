<?php
/**
 * Options available for Styling sub menu of Theme Options
 *
 */

$custom_css_page_link = '<a href="' . esc_url( add_query_arg( array( 'page' => 'custom-primary-color-css-page' ) ), admin_url( 'themes.php' ) ) . '">' . esc_html__( 'Custom Primary CSS', 'electro' ) . '</a>';

$style_options 	= apply_filters( 'electro_style_options_args', array(
	'title'		=> esc_html__( 'Styling', 'electro' ),
	'icon'		=> 'fa fa-pencil-square-o',
	'fields'	=> array(
		array(
			'id'		=> 'styling_general_info_start',
			'type'		=> 'section',
			'title'		=> esc_html__( 'General', 'electro' ),
			'subtitle'	=> esc_html__( 'General Theme Style Settings', 'electro' ),
			'indent'	=> TRUE,
		),

		array(
			'title'		=> esc_html__( 'Use a predefined color scheme', 'electro' ),
			'on'		=> esc_html__('Yes', 'electro'),
			'off'		=> esc_html__('No', 'electro'),
			'type'		=> 'switch',
			'default'	=> 1,
			'id'		=> 'use_predefined_color'
		),

		array(
			'title'		=> esc_html__( 'Main Theme Color', 'electro' ),
			'subtitle'	=> esc_html__( 'The main color of the site.', 'electro' ),
			'id'		=> 'main_color',
			'type'		=> 'select',
			'options'	=> array(
				'black'			=> esc_html__( 'Black', 'electro' ),
				'blue'			=> esc_html__( 'Blue', 'electro' ),
				'flat-blue'		=> esc_html__( 'Flat Blue', 'electro' ),
				'gold'			=> esc_html__( 'Gold', 'electro' ),
				'green'			=> esc_html__( 'Green', 'electro' ),
				'orange'		=> esc_html__( 'Orange', 'electro' ),
				'pink'			=> esc_html__( 'Pink', 'electro' ),
				'red'			=> esc_html__( 'Red', 'electro' ),
				'yellow'		=> esc_html__( 'Yellow', 'electro' ),
				'grey'          => esc_html__( 'Grey', 'electro' ),
			),
			'default'	=> 'yellow',
			'required'	=> array( 'use_predefined_color', 'equals', 1 ),
		),

		array(
			'id'		  => 'custom_primary_color',
			'title'		  => esc_html__( 'Custom Primary Color', 'electro' ),
			'type'		  => 'color',
			'transparent' => false,
			'default'	  => '#0787ea',
			'required'	  => array( 'use_predefined_color', 'equals', 0 ),
		),
		
		array(
			'id'		  => 'custom_primary_text_color',
			'title'		  => esc_html__( 'Custom Primary Text Color', 'electro' ),
			'type'		  => 'color',
			'transparent' => false,
			'default'     => '#fff',
			'required'	  => array( 'use_predefined_color', 'equals', 0 ),
		),

		array(
			'id'		  => 'include_custom_color',
			'title'		  => esc_html__( 'How to include custom color ?', 'electro' ),
			'type'		  => 'radio',
			'options'     => array(
				'1'  => esc_html__( 'Inline', 'electro' ),
				'2'  => esc_html__( 'External File', 'electro' )
			),
			'default'     => '1',
			'required'	  => array( 'use_predefined_color', 'equals', 0 ),
		),

		array(
			'id'		=> 'external_file_css',
			'type'      => 'raw',
			'title'		=> esc_html__( 'Custom Primary Color CSS', 'electro' ),
			'content'  	=> esc_html__( 'If you choose "External File", then please "Save Changes" and then click on ths link to get the custom color primary CSS: ', 'electro' ) . $custom_css_page_link,
			'required'	=> array( 'use_predefined_color', 'equals', 0 ),
		),

		array(
			'id'		=> 'styling_general_info_end',
			'type'		=> 'section',
			'indent'	=> FALSE,
		),
	)
) );
