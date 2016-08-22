<?php
/**
 * Electro WPML Class
 *
 * @package  electro
 * @author   chethemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Electro_WPML' ) ) :
	/**
	 * Electro WPML Integration Class
	 */
	class Electro_WPML {

		/**
		 * Setup Class
		 */
		public function __construct() {
			global $woocommerce_wpml;

			add_action( 'after_setup_theme', array( $this, 'remove_wp_nav_item_filter' ) );
			add_filter( 'wp_nav_menu_items', array( $this, 'language_switcher' ), 10, 2 );
			add_filter( 'wp_nav_menu_items', array( $this, 'currency_switcher' ), 10, 2 );
		}

		public function remove_wp_nav_item_filter() {
			global $icl_language_switcher;
			remove_filter( 'wp_nav_menu_items', array( $icl_language_switcher, 'wp_nav_menu_items_filter' ), 10, 2 );
		}

		public function currency_switcher( $items, $args ) {
			global $woocommerce_wpml;

			if ( apply_filters( 'electro_currency_switcher_enable', false ) && class_exists( 'WCML_Currency_Switcher' ) && isset( $woocommerce_wpml->multi_currency ) ) {
				if ( $args->theme_location == apply_filters( 'electro_currency_switcher_theme_location', 'topbar-right' ) ) {
					$items .= $this->get_menu_cs_html( $args );
				}
			}
			return $items;
		}

		public function get_menu_cs_html( $args ) {
			global $woocommerce_wpml;

			$wc_currencies = get_woocommerce_currencies();
			$wcml_settings = $woocommerce_wpml->get_settings();

			if ( ! ( isset( $wcml_settings['currency_switcher_product_visibility'] ) && $wcml_settings['currency_switcher_product_visibility'] === 1 ) ) {
				return;
			}
			
			if( isset( $wcml_settings['wcml_curr_template'] ) && $wcml_settings['wcml_curr_template'] != '' ) {
				$format = $wcml_settings['wcml_curr_template'];
			} else {
				$format = '%name% (%symbol%) - %code%';
			}

	        if ( ! isset( $wcml_settings['currencies_order'] ) ) {
	            $currencies = $woocommerce_wpml->multi_currency->get_currency_codes();
	        } else {
	            $currencies = $wcml_settings['currencies_order'];
	        }

	        $preview = '';

	        if ( count( $currencies ) > 1 ) {

                $preview .= '<li class="menu-item menu-item-has-children dropdown wcml_currency_switcher">';

                $sub_menu = '';

	            foreach ( $currencies as $currency ) {
	                $currency_format = preg_replace( array('#%name%#', '#%symbol%#', '#%code%#'),
                    array( $wc_currencies[$currency], get_woocommerce_currency_symbol( $currency ), $currency), $format );

                    $selected = $currency == $woocommerce_wpml->multi_currency->get_client_currency() ? ' class="wcml-active-currency"' : '';

                    if ( ! empty( $selected ) ) {
                    	$preview .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . $currency_format . '</a>';
                    } else {
                    	$submenu .= '<li rel="' . $currency . '" ' . $selected . ' class="menu-item"><a>' . $currency_format . '</a></li>';
                    }
	            }

	            $preview .= '<ul class="dropdown-menu">' . $submenu . '</ul>';

                $preview .= '</li>';
	        }

	        return $preview;
		}

		/**
		 * Filter on the 'wp_nav_menu_items' hook, that potentially adds a language switcher to the item of some menus.
		 *
		 * @param string $items
		 * @param object $args
		 *
		 * @return string
		 */
		public function language_switcher( $items, $args ) {
			if ( $this->must_filter_menus() && $this->menu_has_ls( $args ) ) {
				$items .= $this->get_menu_ls_html( $args );
			}

			return $items;
		}

		/**
		 * Returns the HTML string of the language switcher for a given menu.
		 *
		 * @param object $args
		 *
		 * @return string
		 */
		private function get_menu_ls_html( $args ) {
			global $sitepress, $wpml_post_translations, $wpml_term_translations, $icl_language_switcher;

			$current_language = $sitepress->get_current_language();
			$languages_helper = new WPML_Languages( $wpml_term_translations, $sitepress, $wpml_post_translations );
			$languages        = $sitepress->get_ls_languages();

			if ( empty( $languages ) ) {
				return '';
			}

			$items = '';
			$items .= '<li class="menu-item menu-item-language menu-item-language-current menu-item-has-children dropdown">';
			$items .= isset( $args->before ) ? $args->before : '';
			$items .= '<a href="#" onclick="return false" data-toggle="dropdown" class="dropdown-toggle">';
			$items .= isset( $args->link_before ) ? $args->link_before : '';

			$lang           = isset( $languages[ $current_language ] )
				? $languages[ $current_language ]
				: $languages_helper->get_ls_language( $current_language, $current_language );
			$native_lang    = $sitepress->get_setting( 'icl_lso_native_lang' );
			$displayed_lang = $sitepress->get_setting( 'icl_lso_display_lang' );
			$language_name  = $icl_language_switcher->language_display( $lang[ 'native_name' ],
													   $lang[ 'translated_name' ],
													   $native_lang,
													   $displayed_lang,
													   false );
			$language_name  = $this->maybe_render_flag( $lang, $language_name );

			$items .= $language_name;
			$items .= isset( $args->link_after ) ? $args->link_after : '';
			$items .= '</a>';
			$items .= isset( $args->after ) ? $args->after : '';
			unset( $languages[ $current_language ] );
			$items .= $this->render_ls_sub_items( $languages );

			return $items;
		}

		private function maybe_render_flag( $language, $rendered_name ) {
			global $sitepress;

			$html = $rendered_name;
			if ( $sitepress->get_setting( 'icl_lso_flags' ) ) {
				$alt_title_lang = $rendered_name ? esc_attr( $rendered_name ) : esc_attr( $language[ 'native_name' ] );
				$html           = '<img class="iclflag" src="' . $language[ 'country_flag_url' ] . '" width="18" height="12" alt="' . $language[ 'language_code' ] . '" title="' . $alt_title_lang . '" />' . $html;
			}

			return $html;
		}

		private function render_ls_sub_items( $languages ) {
			global $sitepress, $icl_language_switcher;

			$ls_type   = $sitepress->get_setting( 'icl_lang_sel_type' );
			$ls_orientation   = ($ls_type == 'list') && $sitepress->get_setting( 'icl_lang_sel_orientation' );
			$menu_is_vertical = ! $ls_orientation || $ls_orientation === 'vertical';

			$sub_items = '';
			foreach ( (array) $languages as $lang ) {
				$sub_items .= '<li class="menu-item menu-item-language">';
				$sub_items .= '<a href="' . $lang[ 'url' ] . '">';

				$native_lang    = $sitepress->get_setting( 'icl_lso_native_lang' );
				$displayed_lang = $sitepress->get_setting( 'icl_lso_display_lang' );
				$language_name = $icl_language_switcher->language_display($lang[ 'native_name' ], $lang[ 'translated_name' ], $native_lang, $displayed_lang, false);
				$language_name = $this->maybe_render_flag( $lang, $language_name );

				$sub_items .= $language_name;
				$sub_items .= '</a></li>';
			}

			$sub_items = $sub_items && $menu_is_vertical ? '<ul class="sub-menu submenu-languages dropdown-menu">' . $sub_items . '</ul>' : $sub_items;
			$sub_items = $menu_is_vertical ? $sub_items . '</li>' : '</li>' . $sub_items;

			return $sub_items;
		}

		/**
		 * Checks if a given menu has a language_switcher displayed in it
		 *
		 * @param object $args
		 *
		 * @return bool
		 */
		private function menu_has_ls( $args ) {
			list( $abs_menu_id, $settings_menu_id, $menu_locations ) = $this->get_menu_locations_and_ids( $args );

			return $abs_menu_id == $settings_menu_id
				   || ( (bool) $abs_menu_id === false
						&& isset( $args->theme_location )
						&& in_array( $args->theme_location, $menu_locations ) );
		}

		/**
		 * Gets the menu locations that display a language switcher, the id of the menu to which the switcher is assigned
		 * and translation of this id into the default language.
		 *
		 * @param object $args
		 *
		 * @return array
		 */
		private function get_menu_locations_and_ids( $args ) {
			global $sitepress;

			$abs_menu_id = false;
			$settings_menu_id = false;
			$menu_locations = array();

			if(isset($args->menu)) {
				$default_language = $sitepress->get_default_language();
				$args->menu       = isset( $args->menu->term_id ) ? $args->menu->term_id : $args->menu;
				$abs_menu_id      = apply_filters( 'translate_object_id', $args->menu, 'nav_menu', false, $default_language );
				$settings_menu_id = apply_filters( 'translate_object_id', $sitepress->get_setting( 'menu_for_ls' ), 'nav_menu', false, $default_language );
				$menu_locations   = get_nav_menu_locations();
				if ( ! $abs_menu_id && $settings_menu_id ) {
					foreach ( $menu_locations as $location => $id ) {
						if ( $id != $settings_menu_id ) {
							unset( $menu_locations[ $location ] );
						}
					}
				}
			}

			return array( $abs_menu_id, $settings_menu_id, array_keys( $menu_locations ) );
		}

		private function must_filter_menus() {
			global $sitepress_settings;

			return ! empty( $sitepress_settings[ 'display_ls_in_menu' ] ) && ( ! function_exists( 'wpml_home_url_ls_hide_check' ) || ! wpml_home_url_ls_hide_check() );
		}
	}

endif;

return new Electro_WPML();