<?php
/**
 * Filter functions for Navigation Section of Theme Options
 */

if ( ! function_exists( 'redux_apply_dropdown_trigger' ) ) {
	function redux_apply_dropdown_trigger( $trigger, $theme_location ) {
		global $electro_options;

		if( isset( $electro_options[$theme_location . '_dropdown_trigger'] ) ) {
			$trigger = $electro_options[$theme_location . '_dropdown_trigger'];
		}

		return $trigger;
	}
}