<?php
/**
 * Electro breadcrumb
 *
 * @package 	Electro/Templates
 * @see         electro_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo wp_kses_post( $wrap_before );

	foreach ( $breadcrumb as $key => $crumb ) {

		echo wp_kses_post( $before );

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}

		echo wp_kses_post( $after );

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo wp_kses_post( $delimiter );
		}

	}

	echo wp_kses_post( $wrap_after );

}