<?php
/**
 * Filter functions for Blog Section of Theme Options
 */

if ( ! function_exists( 'redux_apply_blog_page_view' ) ) {
	function redux_apply_blog_page_view( $blog_view ) {
		global $electro_options;

		if( isset( $electro_options['blog_view'] ) ) {
			$blog_view = $electro_options['blog_view'];
		}

		return $blog_view;
	}
}

if ( ! function_exists( 'redux_apply_blog_page_layout' ) ) {
	function redux_apply_blog_page_layout( $blog_layout ) {
		global $electro_options;

		if( isset( $electro_options['blog_layout'] ) ) {
			$blog_layout = $electro_options['blog_layout'];
		}

		return $blog_layout;
	}
}

if ( ! function_exists( 'redux_toggle_post_placeholder_img' ) ) {
	function redux_toggle_post_placeholder_img( $enable_placeholder_img ) {
		global $electro_options;

		if( isset( $electro_options['post_placeholder_img'] ) ) {
			$enable_placeholder_img = $electro_options['post_placeholder_img'];
		}

		return $enable_placeholder_img;
	}
}

if ( ! function_exists( 'redux_apply_single_post_layout' ) ) {
	function redux_apply_single_post_layout( $single_post_layout ) {
		global $electro_options;

		if( isset( $electro_options['single_post_layout'] ) ) {
			$single_post_layout = $electro_options['single_post_layout'];
		}

		return $single_post_layout;
	}
}