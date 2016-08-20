<?php
/**
 * Filter functions for Custom Code Section of Theme Options
 */

if ( ! function_exists( 'redux_apply_custom_css' ) ) {
	function redux_apply_custom_css() {
		global $electro_options;

		if( isset( $electro_options['custom_css'] ) && trim( $electro_options['custom_css'] ) != '' ) {
			?>
			<style type="text/css">
			<?php echo ( $electro_options['custom_css'] ); ?>
			</style>
			<?php
		}
	}
}