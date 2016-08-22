<?php
/**
 * Options available for Shop sub menu of Theme Options
 * 
 */

$shop_options 	= apply_filters( 'electro_shop_options_args', array(
	'title'		=> esc_html__( 'Shop', 'electro' ),
	'icon'      => 'fa fa-shopping-cart',
	'fields'	=> array(
		array(
			'title'		=> esc_html__( 'General', 'electro' ),
			'id'		=> 'shop_general_info_start',
			'type'		=> 'section',
			'indent'	=> true
		),
		array(
			'title'		=> esc_html__( 'Catalog Mode', 'electro' ),
			'subtitle'	=> esc_html__( 'Enable / Disable the Catalog Mode.', 'electro' ),
			'id'		=> 'catalog_mode',
			'type'		=> 'switch',
			'on'		=> esc_html__('Enabled', 'electro'),
			'off'		=> esc_html__('Disabled', 'electro'),
			'default'	=> 0,
		),
		array(
			'title' 	=> esc_html__( 'Brand Attribute', 'electro' ),
			'subtitle' 	=> esc_html__( 'Choose a product attribute that will be used as brands', 'electro' ),
			'desc'  	=> esc_html__( 'Once you choose a brand attribute, you will be able to add brand images to the attributes', 'electro' ),
			'id' 		=> 'product_brand_taxonomy',
			'type' 		=> 'select',
			'options' 	=> redux_get_product_attr_taxonomies()
		),
		array(
			'id'		=> 'compare_page_id',
			'title'		=> __( 'Shop Comparison Page', 'electro' ),
			'subtitle'	=> __( 'Choose a page that will be the product compare page for shop.', 'electro' ),
			'type'		=> 'select',
			'data'		=> 'pages',
		),
		array(
			'id'		=> 'shop_jumbotron_id',
			'title'		=> __( 'Shop Page Jumbotron', 'electro' ),
			'subtitle'	=> __( 'Choose a static block that will be the jumbotron element for shop page', 'electro' ),
			'type'		=> 'select',
			'data'		=> 'posts',
			'args'		=> array(
				'post_type'	=> 'static_block',
			)
		),
		array(
			'title'		=> esc_html__( 'Checkout Sticky Payment', 'electro' ),
			'id'		=> 'sticky_payment_box',
			'type'		=> 'switch',
			'on'		=> esc_html__('Enabled', 'electro'),
			'off'		=> esc_html__('Disabled', 'electro'),
			'default'	=> 0,
		),
		array(
			'id'		=> 'shop_general_info_end',
			'type'		=> 'section',
			'indent'	=> false
		),
		
		array(
			'title'		=> esc_html__( 'Shop/Catalog Pages', 'electro' ),
			'id'		=> 'product_archive_page_start',
			'type'		=> 'section',
			'indent'	=> true
		),

		array(
			'id'        => 'product_archive_enabled_views',
			'type'      => 'sorter',
			'title'     => esc_html__( 'Product archive views', 'electro' ),
			'subtitle'  => esc_html__( 'Please drag and arrange the views. Top most view will be the default view', 'electro' ),
			'options'   => array(
				'enabled' => array(
					'grid'            => esc_html__( 'Grid', 'electro' ),
					'grid-extended'   => esc_html__( 'Grid Extended', 'electro' ),
					'list-view'       => esc_html__( 'List', 'electro' ),
					'list-view-small' => esc_html__( 'List View Small', 'electro' )
				),
				'disabled' => array()
			)
		),

		array(
			'title'     => esc_html__('Shop Page Layout', 'electro'),
			'subtitle'  => esc_html__('Select the layout for the Shop Listing.', 'electro'),
			'id'        => 'shop_layout',
			'type'      => 'select',
			'options'   => array(
				'full-width'  	      => esc_html__( 'Full Width', 'electro' ),
				'left-sidebar'        => esc_html__( 'Left Sidebar', 'electro' ),
				'right-sidebar'       => esc_html__( 'Right Sidebar', 'electro' ),
			),
			'default'   => 'left-sidebar',
		),
		array(
			'title'		=> esc_html__('Number of Product Sub-categories Columns', 'electro'),
			'subtitle'	=> esc_html__('Drag the slider to set the number of columns for displaying product sub-categories in shop and catalog pages.', 'electro' ),
			'id'		=> 'subcategory_columns',
			'min'		=> '2',
			'step'		=> '1',
			'max'		=> '6',
			'type'		=> 'slider',
			'default'	=> '3',
		),
		array(
			'title'		=> esc_html__('Number of Products Columns', 'electro'),
			'subtitle'	=> esc_html__('Drag the slider to set the number of columns for displaying products in shop and catalog pages.', 'electro' ),
			'id'		=> 'product_columns',
			'min'		=> '2',
			'step'		=> '1',
			'max'		=> '6',
			'type'		=> 'slider',
			'default'	=> '3',
		),
		array(
			'title'		=> esc_html__('Number of Products Per Page', 'electro'),
			'subtitle'	=> esc_html__('Drag the slider to set the number of products per page to be listed on the shop page and catalog pages.', 'electro' ),
			'id'		=> 'products_per_page',
			'min'		=> '3',
			'step'		=> '1',
			'max'		=> '48',
			'type'		=> 'slider',
			'default'	=> '15',
		),
		array(
			'id'		=> 'product_archive_page_end',
			'type'		=> 'section',
			'indent'	=> false
		),
		array(
			'title'		=> esc_html__( 'Single Product Page', 'electro' ),
			'id'		=> 'product_single_page_start',
			'type'		=> 'section',
			'indent'	=> true
		),
		array(
			'title'     => esc_html__('Single Product Layout', 'electro'),
			'subtitle'  => esc_html__('Select the layout for the Single Product.', 'electro'),
			'id'        => 'single_product_layout',
			'type'      => 'select',
			'options'   => array(
				'full-width'  	      => esc_html__( 'Full Width', 'electro' ),
				'left-sidebar'        => esc_html__( 'Left Sidebar', 'electro' ),
				'right-sidebar'       => esc_html__( 'Right Sidebar', 'electro' ),
			),
			'default'   => 'left-sidebar',
		),
		array(
			'title'     => esc_html__('Single Product Style', 'electro'),
			'subtitle'  => esc_html__('Select the style for Full Width layout.', 'electro'),
			'id'        => 'single_product_style',
			'type'      => 'select',
			'options'   => array(
				'normal'  	      => esc_html__( 'Normal', 'electro' ),
				'extended'        => esc_html__( 'Extended', 'electro' ),
			),
			'default'   => 'normal',
			'required'	=> array( 'single_product_layout', 'equals', 'full-width' )
		),

		array(
			'id'        => 'enable_related_products',
			'title'     => esc_html__( 'Enable Related Products', 'electro' ),
			'type'      => 'switch',
			'default'   => 1,
		),

		array(
			'id'		=> 'product_single_page_end',
			'type'		=> 'section',
			'indent'	=> false
		),
	)
) );