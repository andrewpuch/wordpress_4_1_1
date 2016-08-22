<?php
/**
 * Options available for Blog sub menu of Theme Options
 * 
 */

$blog_options 	= apply_filters( 'electro_blog_options_args', array(
	'title'		=> esc_html__( 'Blog', 'electro' ),
	'icon'		=> 'fa fa-list-alt',
	'fields'	=> array(
		array(
			'title'     => esc_html__('Blog Page View', 'electro'),
			'subtitle'  => esc_html__('Select the view for the Blog Listing.', 'electro'),
			'id'        => 'blog_view',
			'type'      => 'select',
			'options'   => array(
				'blog-default'		=> esc_html__( 'Normal', 'electro' ),
				'blog-grid'			=> esc_html__( 'Grid', 'electro' ),
				'blog-list'			=> esc_html__( 'List', 'electro' ),
			),
			'default'   => 'blog-default',
		),

		array(
			'title'     => esc_html__('Blog Page Layout', 'electro'),
			'subtitle'  => esc_html__('Select the layout for the Blog Listing.', 'electro'),
			'id'        => 'blog_layout',
			'type'      => 'select',
			'options'   => array(
				'full-width'  	      => esc_html__( 'Full Width', 'electro' ),
				'left-sidebar'        => esc_html__( 'Left Sidebar', 'electro' ),
				'right-sidebar'       => esc_html__( 'Right Sidebar', 'electro' ),
			),
			'default'   => 'right-sidebar',
		),

		array(
			'title'     => esc_html__( 'Enable Placeholder Image', 'electro' ),
			'id'        => 'post_placeholder_img',
			'on'        => esc_html__('Yes', 'electro'),
			'off'       => esc_html__('No', 'electro'),
			'type'      => 'switch',
			'default'   => TRUE,
		),

		array(
			'title'     => esc_html__('Single Post Layout', 'electro'),
			'subtitle'  => esc_html__('Select the layout for the Single Post.', 'electro'),
			'id'        => 'single_post_layout',
			'type'      => 'select',
			'options'   => array(
				'full-width'  	      => esc_html__( 'Full Width', 'electro' ),
				'left-sidebar'        => esc_html__( 'Left Sidebar', 'electro' ),
				'right-sidebar'       => esc_html__( 'Right Sidebar', 'electro' ),
			),
			'default'   => 'right-sidebar',
		),
	)
) );