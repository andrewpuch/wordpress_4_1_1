<?php
/**
 * Filter functions for Footer Section of Theme Options
 */

if ( ! function_exists( 'redux_toggle_footer_brands_carousel' ) ) {
	function redux_toggle_footer_brands_carousel( $enable ) {
		global $electro_options;

		if( isset( $electro_options['show_footer_brands_slider'] ) && $electro_options['show_footer_brands_slider'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}


if ( ! function_exists( 'redux_apply_footer_brands_number' ) ) {
	function redux_apply_footer_brands_number( $number ) {
		global $electro_options;

		if ( !isset( $electro_options['footer_footer_brands_slider_number'] ) || empty( $electro_options['footer_footer_brands_slider_number'] ) || ! is_numeric( $electro_options['footer_footer_brands_slider_number'] ) ) {
			$electro_options['footer_footer_brands_slider_number'] = 12;
		}

		return absint( $electro_options['footer_footer_brands_slider_number'] );
	}
}

if ( ! function_exists( 'redux_toggle_footer_widgets' ) ) {
	function redux_toggle_footer_widgets( $enable ) {
		global $electro_options;

		if( isset( $electro_options['show_footer_widgets'] ) && $electro_options['show_footer_widgets'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_toggle_footer_newsletter' ) ) {
	function redux_toggle_footer_newsletter( $enable ) {
		global $electro_options;

		if( isset( $electro_options['show_footer_newsletter'] ) && $electro_options['show_footer_newsletter'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_apply_footer_newsletter_title' ) ) {
	function redux_apply_footer_newsletter_title( $icon ) {
		global $electro_options;

		if( isset( $electro_options['footer_newsletter_title'] ) ) {
			$icon = $electro_options['footer_newsletter_title'];
		}

		return $icon;
	}
}

if ( ! function_exists( 'redux_apply_footer_newsletter_marketing_text' ) ) {
	function redux_apply_footer_newsletter_marketing_text( $address ) {
		global $electro_options;

		if( isset( $electro_options['footer_newsletter_marketing_text'] ) ) {
			$address = $electro_options['footer_newsletter_marketing_text'];
		}

		return $address;
	}
}

if ( ! function_exists( 'redux_apply_footer_newsletter_form' ) ) {
	function redux_apply_footer_newsletter_form( $form ) {
		global $electro_options;

		if( isset( $electro_options['footer_newsletter_signup_form'] ) && $electro_options['footer_newsletter_signup_form'] != '' ) {
			$form = do_shortcode( $electro_options['footer_newsletter_signup_form'] );
		}

		return $form;
	}
}

if ( ! function_exists( 'redux_toggle_footer_logo' ) ) {
	function redux_toggle_footer_logo( $enable ) {
		global $electro_options;

		if( isset( $electro_options['show_footer_logo'] ) && $electro_options['show_footer_logo'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_apply_footer_logo' ) ) {
	function redux_apply_footer_logo( $logo ) {
		global $electro_options;

		if ( ! empty( $electro_options['site_footer_logo']['url'] ) ) {
			ob_start();
			?>
			<div class="footer-logo">
				<img src="<?php echo esc_url( $electro_options['site_footer_logo']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="<?php echo esc_attr( $electro_options['site_footer_logo']['width'] ); ?>" height="<?php echo esc_attr( $electro_options['site_footer_logo']['height'] ); ?>" />
			</div>
			<?php
			$logo = ob_get_clean();
		}

		return $logo;
	}
}

if ( ! function_exists( 'redux_toggle_electro_footer_call_us' ) ) {
	function redux_toggle_electro_footer_call_us( $enable ) {
		global $electro_options;

		if( isset( $electro_options['show_footer_call_us'] ) && $electro_options['show_footer_call_us'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}


if ( ! function_exists( 'redux_apply_footer_call_us_text' ) ) {
	function redux_apply_footer_call_us_text( $text ) {
		global $electro_options;

		if( isset( $electro_options['footer_call_us_text'] ) ) {
			$text = $electro_options['footer_call_us_text'];
		}

		return $text;
	}
}

if ( ! function_exists( 'redux_apply_footer_call_us_number' ) ) {
	function redux_apply_footer_call_us_number( $number ) {
		global $electro_options;

		if( isset( $electro_options['footer_call_us_number'] ) ) {
			$number = $electro_options['footer_call_us_number'];
		}

		return $number;
	}
}

if ( ! function_exists( 'redux_apply_footer_call_us_icon' ) ) {
	function redux_apply_footer_call_us_icon( $icon ) {
		global $electro_options;

		if( isset( $electro_options['footer_call_us_icon'] ) ) {
			$icon = $electro_options['footer_call_us_icon'];
		}

		return $icon;
	}
}

if ( ! function_exists( 'redux_toggle_footer_address' ) ) {
	function redux_toggle_footer_address( $enable ) {
		global $electro_options;

		if( isset( $electro_options['show_footer_address'] ) && $electro_options['show_footer_address'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_apply_footer_address_title' ) ) {
	function redux_apply_footer_address_title( $address ) {
		global $electro_options;

		if( isset( $electro_options['footer_address_title'] ) ) {
			$address = $electro_options['footer_address_title'];
		}

		return $address;
	}
}

if ( ! function_exists( 'redux_apply_footer_address_content' ) ) {
	function redux_apply_footer_address_content( $address ) {
		global $electro_options;

		if( isset( $electro_options['footer_address'] ) ) {
			$address = $electro_options['footer_address'];
		}

		return $address;
	}
}

if ( ! function_exists( 'redux_toggle_footer_social_icons' ) ) {
	function redux_toggle_footer_social_icons( $enable ) {
		global $electro_options;

		if( isset( $electro_options['show_footer_social_icons'] ) && $electro_options['show_footer_social_icons'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_apply_footer_copyright_text' ) ) {
	function redux_apply_footer_copyright_text( $text ) {
		global $electro_options;

		if( isset( $electro_options['footer_credit'] ) ) {
			$text = $electro_options['footer_credit'];
		}

		return $text;
	}
}

if ( ! function_exists( 'redux_apply_footer_credit_icons' ) ) {
	function redux_apply_footer_credit_icons( $content ) {
		global $electro_options;

		if( !empty( $electro_options['footer_credit_icons'] ) ) :
		$credit_card_icons = explode( ',', $electro_options['footer_credit_icons'] );
		ob_start(); ?>
		<div class="footer-payment-logo">
			<ul class="cash-card card-inline">
				<?php foreach ( $credit_card_icons as $credit_card_icon ): ?>
				<?php $credit_card_image_atts = wp_get_attachment_image_src( $credit_card_icon ); ?>
				<li class="card-item"><img src="<?php echo esc_attr( $credit_card_image_atts[0] ); ?>" alt="" width="<?php echo esc_attr( $credit_card_image_atts[1] ); ?>" height="<?php echo esc_attr( $credit_card_image_atts[2] ); ?>"></li>
				<?php endforeach; ?>
			</ul>
		</div><!-- /.payment-methods -->
		<?php
		$content = ob_get_clean();
		endif;

		return $content;
	}
}

if ( ! function_exists( 'redux_apply_social_networks' ) ) {
	function redux_apply_social_networks( $social_icons ) {
		global $electro_options;

		$social_icons = array(
			'facebook' 		=> array(
				'label'	=> esc_html__( 'Facebook', 'electro' ),
				'icon'	=> 'fa fa-facebook',
				'id'	=> 'facebook_link',
			),
			'twitter' 		=> array(
				'label'	=> esc_html__( 'Twitter', 'electro' ),
				'icon'	=> 'fa fa-twitter',
				'id'	=> 'twitter_link',
			),
			'pinterest' 	=> array(
				'label'	=> esc_html__( 'Pinterest', 'electro' ),
				'icon'	=> 'fa fa-pinterest',
				'id'	=> 'pinterest_link',
			),
			'linkedin' 		=> array(
				'label'	=> esc_html__( 'LinkedIn', 'electro' ),
				'icon'	=> 'fa fa-linkedin',
				'id'	=> 'linkedin_link',
			),
			'googleplus' 	=> array(
				'label'	=> esc_html__( 'Google+', 'electro' ),
				'icon'	=> 'fa fa-google-plus',
				'id'	=> 'googleplus_link',
			),
			'tumblr' 	=> array(
				'label'	=> esc_html__( 'Tumblr', 'electro' ),
				'icon'	=> 'fa fa-tumblr',
				'id'	=> 'tumblr_link'
			),
			'instagram' 	=> array(
				'label'	=> esc_html__( 'Instagram', 'electro' ),
				'icon'	=> 'fa fa-instagram',
				'id'	=> 'instagram_link'
			),
			'youtube' 		=> array(
				'label'	=> esc_html__( 'Youtube', 'electro' ),
				'icon'	=> 'fa fa-youtube',
				'id'	=> 'youtube_link'
			),
			'vimeo' 		=> array(
				'label'	=> esc_html__( 'Vimeo', 'electro' ),
				'icon'	=> 'fa fa-vimeo-square',
				'id'	=> 'vimeo_link'
			),
			'dribbble' 		=> array(
				'label'	=> esc_html__( 'Dribbble', 'electro' ),
				'icon'	=> 'fa fa-dribbble',
				'id'	=> 'dribbble_link',
			),
			'stumbleupon' 	=> array(
				'label'	=> esc_html__( 'StumbleUpon', 'electro' ),
				'icon'	=> 'fa fa-stumbleupon',
				'id'	=> 'stumble_upon_link'
			),
			'soundcloud'	=> array(
				'label'	=> esc_html__('Sound Cloud', 'electro'),
				'icon'	=> 'fa fa-soundcloud',
				'id'	=> 'soundcloud',
			),
			'vine'			=> array(
				'label'	=> esc_html__('Vine', 'electro'),
				'icon'	=> 'fa fa-vine',
				'id'	=> 'vine',
			),
			'vk'			=> array(
				'label'	=> esc_html__('VKontakte', 'electro'),
				'icon'	=> 'fa fa-vk',
				'id'	=> 'vk',
			),
			'rss'			=> array(
				'label'	=> __( 'RSS', 'electro' ),
				'icon'	=> 'fa fa-rss',
				'id'	=> 'rss_link',
			)
		);

		foreach( $social_icons as $key => $social_icon ) {
			if( ! empty( $electro_options[$key] ) ) {
				$social_icons[$key]['link'] = $electro_options[$key];
			}
		}

		if( isset( $electro_options['show_footer_rss_icon'] ) && $electro_options['show_footer_rss_icon'] ) {
			$social_icons['rss']['link'] = get_bloginfo( 'rss2_url' );
		}

		return $social_icons;
	}
}

if ( ! function_exists( 'redux_toggle_footer_contact_block') ) {
	function redux_toggle_footer_contact_block( $enable ) {
		global $electro_options;

		$electro_options['show_footer_contact_block'] = isset( $electro_options['show_footer_contact_block'] ) ? $electro_options['show_footer_contact_block'] : true;

		if( $electro_options['show_footer_contact_block'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_toggle_footer_bottom_widgets' ) ) {
	function redux_toggle_footer_bottom_widgets( $enable ) {
		global $electro_options;

		$electro_options['show_footer_bottom_widgets'] = isset( $electro_options['show_footer_bottom_widgets'] ) ? $electro_options['show_footer_bottom_widgets'] : true;

		if( $electro_options['show_footer_bottom_widgets'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_apply_footer_bottom_widgets_column_spacing' ) ) {
	function redux_apply_footer_bottom_widgets_column_spacing() {
		global $electro_options;

		if ( ! isset( $electro_options['footer_bottom_widgets_column_spacing'] ) ) {
			$electro_options['footer_bottom_widgets_column_spacing'] = '5.357em';
		}

		if ( ! isset( $electro_options['footer_bottom_widgets_column_width'] ) ) {
			$electro_options['footer_bottom_widgets_column_width'] = 'auto';
		}

		$custom_css = '';

		if ( '5.357em' != $electro_options['footer_bottom_widgets_column_spacing'] ) {
			$custom_css .= '.footer-bottom-widgets .columns+.columns { margin-left: ' . esc_attr( $electro_options['footer_bottom_widgets_column_spacing'] ) . ';}';
		}

		if ( ! $electro_options['footer_bottom_widgets_width_auto'] && 'auto' != $electro_options['footer_bottom_widgets_column_width'] ) {
			$custom_css .= '.footer-bottom-widgets .columns { width: ' . esc_attr( $electro_options['footer_bottom_widgets_column_width'] ) . '; }';
		}

		if ( ! empty( $custom_css ) ): ?>
		<style type="text/css"><?php echo esc_html( $custom_css ); ?></style>
		<?php endif;
	}
}

if ( ! function_exists( 'redux_toggle_footer_credit_block' ) ) {
	function redux_toggle_footer_credit_block( $enable ) {
		global $electro_options;

		$electro_options['footer_credit_block_enable'] = isset( $electro_options['footer_credit_block_enable'] ) ? $electro_options['footer_credit_block_enable'] : true;

		if( $electro_options['footer_credit_block_enable'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}