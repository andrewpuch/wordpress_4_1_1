<?php
/**
 * Options available for Social Media sub menu of Theme Options
 * 
 */

$social_options 	= apply_filters( 'electro_social_media_options_args', array(
	'title'     => esc_html__('Social Media', 'electro'),
	'icon'      => 'fa fa-share-square-o',
	'desc'      => esc_html__('Please type in your complete social network URL', 'electro' ),
	'fields'    => array(
		array(
			'title'     => esc_html__('Facebook', 'electro'),
			'id'        => 'facebook',
			'type'      => 'text',
			'icon'      => 'fa fa-facebook',
		),

		array(
			'title'     => esc_html__('Twitter', 'electro'),
			'id'        => 'twitter',
			'type'      => 'text',
			'icon'      => 'fa fa-twitter',
		),

		array(
			'title'     => esc_html__('Google+', 'electro'),
			'id'        => 'googleplus',
			'type'      => 'text',
			'icon'      => 'fa fa-google-plus',
		),

		array(
			'title'     => esc_html__('Pinterest', 'electro'),
			'id'        => 'pinterest',
			'type'      => 'text',
			'icon'      => 'fa fa-pinterest',
		),

		array(
			'title'     => esc_html__('LinkedIn', 'electro'),
			'id'        => 'linkedin',
			'type'      => 'text',
			'icon'      => 'fa fa-linkedin',
		),

		array(
			'title'     => esc_html__('Tumblr', 'electro'),
			'id'        => 'tumblr',
			'type'      => 'text',
			'icon'      => 'fa fa-tumblr',
		),

		array(
			'title'     => esc_html__('Instagram', 'electro'),
			'id'        => 'instagram',
			'type'      => 'text',
			'icon'      => 'fa fa-instagram',
		),

		array(
			'title'     => esc_html__('Youtube', 'electro'),
			'id'        => 'youtube',
			'type'      => 'text',
			'icon'      => 'fa fa-youtube',
		),

		array(
			'title'     => esc_html__('Vimeo', 'electro'),
			'id'        => 'vimeo',
			'type'      => 'text',
			'icon'      => 'fa fa-vimeo-square',
		),

		array(
			'title'     => esc_html__('Dribbble', 'electro'),
			'id'        => 'dribbble',
			'type'      => 'text',
			'icon'      => 'fa fa-dribbble',
		),

		array(
			'title'     => esc_html__('Stumble Upon', 'electro'),
			'id'        => 'stumbleupon',
			'type'      => 'text',
			'icon'      => 'fa fa-stumpleupon',
		),

		array(
			'title'     => esc_html__('Sound Cloud', 'electro'),
			'id'        => 'soundcloud',
			'type'      => 'text',
			'icon'      => 'fa fa-soundcloud',
		),

		array(
			'title'     => esc_html__('Vine', 'electro'),
			'id'        => 'vine',
			'type'      => 'text',
			'icon'      => 'fa fa-vine',
		),

		array(
			'title'     => esc_html__('VKontakte', 'electro'),
			'id'        => 'vk',
			'type'      => 'text',
			'icon'      => 'fa fa-vk',
		),
		array(
			'id'		=> 'show_footer_rss_icon',
			'type'		=> 'switch',
			'title'		=> esc_html__( 'RSS', 'electro' ),
			'desc'		=> esc_html__( 'On enabling footer rss icon.', 'electro' ),
			'default'	=> 1,
		),
	),
) );