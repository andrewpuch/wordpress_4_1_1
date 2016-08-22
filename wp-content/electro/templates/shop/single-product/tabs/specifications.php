<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( $product->specifications_display_attributes && ( $product->has_attributes() || ( $product->enable_dimensions_display() && ( $product->has_dimensions() || $product->has_weight() ) ) ) ) {
	$attributes_title = isset( $product->specifications_attributes_title ) ? $product->specifications_attributes_title : '';
	if ( $attributes_title ) {
		echo wp_kses_post( '<h2>' . $attributes_title . '</h2>' );
	}

	$product->list_attributes();
}

echo wp_kses_post( $product->specifications );