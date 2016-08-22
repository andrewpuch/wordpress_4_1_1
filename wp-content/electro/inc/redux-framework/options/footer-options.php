<?php
/**
 * Options available for Footer sub menu in Theme Options
 */

$footer_options = apply_filters( 'electro_footer_options_args', array(
	'title' 	=> esc_html__( 'Footer', 'electro' ),
	'desc'		=> esc_html__( 'Options related to the footer section. The Footer has : Brands Slider, Footer Widgets, Footer Newsletter Section, Footer Contact Block, Footer Bottom Wigets', 'electro' ),
	'icon' 		=> 'fa fa-arrow-circle-o-down',
	'fields' 	=> array(
		array(
			'title'		=> esc_html__( 'Brands Slider', 'electro' ),
			'id'		=> 'brands_slider_start',
			'type'		=> 'section',
			'indent'	=> true
		),

		array(
			'title'		=> esc_html__( 'Show Brands Slider in Footer ?', 'electro' ),
			'id'		=> 'show_footer_brands_slider',
			'type'		=> 'switch',
			'default'	=> 0,
		),

		array(
			'id'        => 'footer_footer_brands_slider_number',
			'type'      => 'text',
			'validate'  => 'numeric',
			'title'     => esc_html__( 'No of brands to show in brands slider', 'electro' ),
			'default'   => 12,
			'required'  => array( 'show_footer_brands_slider', 'equals', 1 )
		),

		array(
			'id'		=> 'brands_slider_end',
			'type'		=> 'section',
			'indent'	=> false
		),

		array(
			'id'		=> 'footer_widgets_start',
			'type'		=> 'section',
			'title'		=> esc_html__( 'Footer Widgets', 'electro' ),
			'subtitle'	=> esc_html__( 'Options related to Footer Widgets. Please add widgets in Appearance > Widgets > Footer Widgets widget area. If the widget area is empty without any widgets, the theme loads default widgets.', 'electro' ),
			'indent'	=> true,
		),

		array(
			'title'		=> esc_html__( 'Show Footer Widgets ?', 'electro' ),
			'id'		=> 'show_footer_widgets',
			'type'		=> 'switch',
			'default'	=> 1,
		),

		array(
			'id'		=> 'footer_widgets_end',
			'type'		=> 'section',
			'indent'	=> false
		),

		array(
			'id'		=> 'footer_newsletter_start',
			'type'		=> 'section',
			'title'		=> esc_html__( 'Footer Newsletter Section', 'electro' ),
			'subtitle'	=> esc_html__( 'Please use this section to add a subscription form to your mailing list.', 'electro' ),
			'indent'	=> true,
		),

		array(
			'title'		=> esc_html__( 'Show Footer Newsletter block ?', 'electro' ),
			'id'		=> 'show_footer_newsletter',
			'type'		=> 'switch',
			'default'	=> 1,
		),

		array(
			'title'		=> esc_html__( 'Newsletter title', 'electro' ),
			'id'		=> 'footer_newsletter_title',
			'type'		=> 'text',
			'default'	=> 'Sign up to Newsletter',
			'required'	=> array( 'show_footer_newsletter', 'equals', true )
		),

		array(
			'title'		=> esc_html__( 'Newsletter marketing text', 'electro' ),
			'id'		=> 'footer_newsletter_marketing_text',
			'type'		=> 'text',
			'default'	=> '...and receive <strong>$20 coupon for first shopping</strong>',
			'required'	=> array( 'show_footer_newsletter', 'equals', true )
		),

		array(
			'title'		=> esc_html__( 'Newsletter signup form', 'electro' ),
			'id'		=> 'footer_newsletter_signup_form',
			'type'		=> 'textarea',
			'subtitle'	=> esc_html__( 'Paste your newsletter signup form or shortcode', 'electro' ),
			'required'	=> array( 'show_footer_newsletter', 'equals', true )
		),

		array(
			'id'		=> 'footer_newsletter_end',
			'type'		=> 'section',
			'indent'	=> false
		),

		array(
			'id'		=> 'footer_contact_block_start',
			'type'		=> 'section',
			'indent'	=> true,
			'title'		=> esc_html__( 'Footer Contact Block', 'electro' ),
			'subtitle'	=> esc_html__( 'The Footer Contact Block is part of Footer widgets. However it is not available as a separate widget but are fully customizable with the options given below.', 'electro' ),
		),

		array(
			'id'		=> 'show_footer_contact_block',
			'type'		=> 'switch',
			'title'		=> esc_html__( 'Show Footer Contact Block', 'electro' ),
			'default'	=> 1,
		),

		array(
			'id'		=> 'show_footer_logo',
			'type'		=> 'switch',
			'title'		=> esc_html__( 'Show Footer logo', 'electro' ),
			'default'	=> 1,
			'required'	=> array( 'show_footer_contact_block', 'equals', 1 ),
		),

		array(
			'title'		=> esc_html__( 'Your Logo', 'electro' ),
			'subtitle'	=> esc_html__( 'Upload your footer logo image.', 'electro' ),
			'id'		=> 'site_footer_logo',
			'type'		=> 'media',
			'required'	=> array( 'show_footer_logo', 'equals', 1 ),
		),

		array(
			'id'		=> 'show_footer_call_us',
			'type'		=> 'switch',
			'title'		=> esc_html__( 'Show Footer Call Us section', 'electro' ),
			'default'	=> 1,
			'required'	=> array( 'show_footer_contact_block', 'equals', 1 ),	
		),

		array(
			'id'		=> 'footer_call_us_text',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Call us text', 'electro' ),
			'default'	=> esc_html__( 'Got Questions ? Call us 24/7!', 'electro' ),
			'required'	=> array( 'show_footer_call_us', 'equals', 1 ),
		),

		array(
			'id'		=> 'footer_call_us_icon',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Call us icon', 'electro' ),
			'default'	=> 'ec ec-support',
			'required'	=> array( 'show_footer_call_us', 'equals', 1 ),
		),

		array(
			'id'		=> 'footer_call_us_number',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Call us number', 'electro' ),
			'default'	=> '(800) 8001-8588, (0600) 874 548',
			'required'	=> array( 'show_footer_call_us', 'equals', 1 ),
		),

		array(
			'id'		=> 'show_footer_address',
			'type'		=> 'switch',
			'title'		=> esc_html__( 'Show Footer address', 'electro' ),
			'default'	=> 1,
			'required'	=> array( 'show_footer_contact_block', 'equals', 1 ),
		),

		array(
			'id'		=> 'footer_address_title',
			'type'		=> 'text',
			'title'		=> esc_html__( 'Footer address title', 'electro' ),
			'default'	=> esc_html__( 'Contact Info', 'electro' ),
			'required'	=> array( 'show_footer_address', 'equals', 1 ),
		),

		array(
			'id'		=> 'footer_address',
			'type'		=> 'textarea',
			'title'		=> esc_html__( 'Footer address', 'electro' ),
			'default'	=> '17 Princess Road, London, Greater London NW1 8JR, UK',
			'required'	=> array( 'show_footer_address', 'equals', 1 ),
		),

		array(
			'id'		=> 'show_footer_social_icons',
			'type'		=> 'switch',
			'title'		=> esc_html__( 'Show Footer Social Icons', 'electro' ),
			'desc'		=> esc_html__( 'On enabling footer social icons, please make sure to add all social URLs to Electro > Social Media', 'electro' ),
			'default'	=> 1,
			'required'	=> array( 'show_footer_contact_block', 'equals', 1 ),
		),

		array(
			'id'		=> 'footer_contact_block_end',
			'type'		=> 'section',
			'indent'	=> false
		),

		array(
			'id'		=> 'footer_bottom_widgets_start',
			'type'		=> 'section',
			'indent'	=> true,
			'title'		=> esc_html__( 'Footer Bottom Widgets', 'electro' ),
			'subtitle'	=> esc_html__( 'Options related to Footer Bottom Widgets. Add your widgets to Appearance > Widgets > Footer Bottom Widgets. If the widget area is empty, it loads the default widgets.', 'electro' ),
		),

		array(
			'id'		=> 'show_footer_bottom_widgets',
			'type'		=> 'switch',
			'title'		=> esc_html__( 'Show Footer Bottom Widgets ?', 'electro' ),
			'default'	=> 1,
		),

		array(
			'id'        => 'footer_bottom_widgets_column_spacing',
			'type'      => 'text',
			'title'     => esc_html__( 'Spacing between columns in Footer Widgets', 'electro' ),
			'default'   => '5.357em',
		),

		array(
			'id'        => 'footer_bottom_widgets_width_auto',
			'type'      => 'switch',
			'title'     => esc_html__( 'Auto-width footer bottom widget columns ?', 'electro' ),
			'default'   => 1,
		),

		array(
			'id'        => 'footer_bottom_widgets_column_width',
			'type'      => 'text',
			'title'     => esc_html__( 'Width of each footer bottom widget column', 'electro' ),
			'output'    => '.footer-bottom-widgets .columns',
			'default'   => 'auto',
			'required'  => array( 'footer_bottom_widgets_width_auto', 'equals', 0 )
		),

		array(
			'id'		=> 'footer_bottom_widgets_end',
			'type'		=> 'section',
			'indent'	=> false
		),

		array(
			'id'		=> 'footer_credit_block_start',
			'type'		=> 'section',
			'indent'	=> true,
			'title'		=> esc_html__( 'Footer Credit Block', 'electro' ),
			'subtitle'	=> esc_html__( 'The Footer Credit Block is available bottom of Footer.', 'electro' ),
		),

		array(
			'id'        => 'footer_credit_block_enable',
			'type'      => 'switch',
			'title'     => esc_html__( 'Enable Footer Credit Block ?', 'electro' ),
			'default'   => 1,
		),

		array(
			'id'		=> 'footer_credit',
			'type'		=> 'textarea',
			'title'		=> esc_html__( 'Footer Credit', 'electro' ),
			'default'	=> '&copy; <a href="' . esc_url( home_url( '/' ) ) . '">' .  get_bloginfo( 'name' ) . '</a> - All Rights Reserved',
			'required'  => array( 'footer_credit_block_enable', 'equals', 1 ),
		),

		array(
			'id'		=> 'footer_credit_icons',
			'type'		=> 'gallery',
			'title'		=> esc_html__( 'Footer Payment Icons', 'electro' ),
			'required'  => array( 'footer_credit_block_enable', 'equals', 1 ),
		),

		array(
			'id'		=> 'footer_credit_block_end',
			'type'		=> 'section',
			'indent'	=> false
		),
	)
) );
