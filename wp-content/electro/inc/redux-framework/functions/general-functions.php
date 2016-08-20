<?php
/**
 * Filter functions for General Section of Theme Options
 */

if( ! function_exists( 'redux_toggle_scrollup' ) ) {
	function redux_toggle_scrollup() {
		global $electro_options;

		if( isset( $electro_options['scrollup'] ) && $electro_options['scrollup'] == '1' ) {
			$scrollup = true;
		} else {
			$scrollup = false;
		}

		return $scrollup;
	}
}

if( ! function_exists( 'redux_toggle_register_image_size' ) ) {
	function redux_toggle_register_image_size() {
		global $electro_options;

		if( isset( $electro_options['reg_image_size'] ) && $electro_options['reg_image_size'] == '1' ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_toggle_electro_child_style' ) ) {
	function redux_toggle_electro_child_style() {
		global $electro_options;

		if ( isset( $electro_options['load_child_theme'] ) && $electro_options['load_child_theme'] == '1' ) {
			$load = true;
		} else {
			$load = false;
		}

		return $load;
	}
}