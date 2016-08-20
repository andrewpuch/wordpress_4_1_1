<?php
/**
 * General Theme Options
 * 
 */

$general_options 	= apply_filters( 'electro_general_options_args', array(
	'title'		=> esc_html__( 'General', 'electro' ),
	'icon'		=> 'fa fa-dot-circle-o',
	'fields'	=> array(
		array(
			'title'		=> esc_html__( 'Scroll To Top', 'electro' ),
			'id'		=> 'scrollup',
			'type'		=> 'switch',
			'on'		=> esc_html__('Enabled', 'electro'),
			'off'		=> esc_html__('Disabled', 'electro'),
			'default'	=> 1,
		),
		array(
			'title'		=> esc_html__( 'Register Image Size', 'electro' ),
			'subtitle'	=> esc_html__( 'Enable and regenerate thumbnails to enable theme registered image sizes.', 'electro' ),
			'id'		=> 'reg_image_size',
			'type'		=> 'switch',
			'on'		=> esc_html__('Enabled', 'electro'),
			'off'		=> esc_html__('Disabled', 'electro'),
			'default'	=> 0,
		),
	)
) );

if ( is_child_theme() ) {
	$general_options['fields'][] = array(
		'title'   => esc_html__( 'Load child theme style.css', 'electro' ),
		'id'      => 'load_child_theme',
		'type'    => 'switch',
		'default' => 0
	);
}