<?php
/**
 * Filter functions for Shop Section of Theme Options
 */

if( ! function_exists( 'redux_toggle_shop_catalog_mode' ) ) {
	function redux_toggle_shop_catalog_mode() {
		global $electro_options;

		if( isset( $electro_options['catalog_mode'] ) && $electro_options['catalog_mode'] == '1' ) {
			$catalog_mode = true;
		} else {
			$catalog_mode = false;
		}

		return $catalog_mode;
	}
}

function redux_apply_catalog_mode_for_product_loop( $product_link, $product ) {
	global $electro_options;

	if( isset( $electro_options['catalog_mode'] ) && $electro_options['catalog_mode'] == '1' ) {
		$product_link = sprintf( '<a href="%s" class="button product_type_%s">%s</a>',
			get_permalink( $product->ID ),
			esc_attr( $product->product_type ),
			apply_filters( 'electro_catalog_mode_button_text', esc_html__( 'View Product', 'electro' ) )
		);
	}

	return $product_link;
}

if( ! function_exists( 'redux_apply_product_brand_taxonomy' ) ) {
	function redux_apply_product_brand_taxonomy( $brand_taxonomy ) {
		global $electro_options;

		if( isset( $electro_options['product_brand_taxonomy'] ) ) {
			$brand_taxonomy = $electro_options['product_brand_taxonomy'];
		}

		return $brand_taxonomy;
	}
}

if( ! function_exists( 'redux_apply_product_comparison_page_id' ) ) {
	function redux_apply_product_comparison_page_id( $compare_page_id ) {
		global $electro_options;

		if( isset( $electro_options['compare_page_id'] ) ) {
			$compare_page_id = $electro_options['compare_page_id'];
		}

		return $compare_page_id;
	}
}

if( ! function_exists( 'redux_apply_shop_jumbotron_id' ) ) {
	function redux_apply_shop_jumbotron_id( $static_block_id ) {
		global $electro_options;

		if( isset( $electro_options['shop_jumbotron_id'] ) ) {
			$static_block_id = $electro_options['shop_jumbotron_id'];
		}

		return $static_block_id;
	}
}

if ( ! function_exists( 'redux_apply_shop_loop_subcategories_columns' ) ) {
	function redux_apply_shop_loop_subcategories_columns( $columns ) {
		global $electro_options;

		if( isset( $electro_options['subcategory_columns'] ) ) {
			$columns = $electro_options['subcategory_columns'];
		}

		return $columns;
	}
}

if ( ! function_exists( 'redux_apply_shop_loop_products_columns' ) ) {
	function redux_apply_shop_loop_products_columns( $columns ) {
		global $electro_options;

		if( isset( $electro_options['product_columns'] ) ) {
			$columns = $electro_options['product_columns'];
		}

		return $columns;
	}
}

if ( ! function_exists( 'redux_apply_shop_loop_per_page' ) ) {
	function redux_apply_shop_loop_per_page( $per_page ) {
		global $electro_options;

		if( isset( $electro_options['products_per_page'] ) ) {
			$per_page = $electro_options['products_per_page'];
		}

		return $per_page;
	}
}

if ( ! function_exists( 'redux_set_shop_view_args' ) ) {
	function redux_set_shop_view_args( $shop_view_args ) {
		global $electro_options;

		if ( isset( $electro_options['product_archive_enabled_views'] ) ) {
			$shop_views = $electro_options['product_archive_enabled_views']['enabled'];

			if ( $shop_views ) {
				$new_shop_view_args = array();
				$count = 0;
				
				foreach( $shop_views as $key => $shop_view ) {
					
					if ( isset( $shop_view_args[ $key ] ) ) {
						$new_shop_view_args[ $key ] = $shop_view_args[ $key ];

						if ( 0 == $count ) {
							$new_shop_view_args[ $key ]['active'] = true;
						} else {
							$new_shop_view_args[ $key ]['active'] = false;
						}

						$count++;
					}
				}

				return $new_shop_view_args;
			}
		}

		return $shop_view_args;
	}
}

if ( ! function_exists( 'redux_apply_shop_layout' ) ) {
	function redux_apply_shop_layout( $shop_layout ) {
		global $electro_options;

		if( isset( $electro_options['shop_layout'] ) ) {
			$shop_layout = $electro_options['shop_layout'];
		}

		return $shop_layout;
	}
}

if ( ! function_exists( 'redux_apply_single_product_layout' ) ) {
	function redux_apply_single_product_layout( $single_product_layout ) {
		global $electro_options;

		if( isset( $electro_options['single_product_layout'] ) ) {
			$single_product_layout = $electro_options['single_product_layout'];
		}

		return $single_product_layout;
	}
}

if ( ! function_exists( 'redux_toggle_related_products_output' ) ) {
	function redux_toggle_related_products_output( $enable ) {
		global $electro_options;

		if ( ! isset( $electro_options['enable_related_products'] ) ) {
			$electro_options['enable_related_products'] = true;
		}

		if ( $electro_options['enable_related_products'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_apply_single_product_layout_style' ) ) {
	function redux_apply_single_product_layout_style( $single_product_style ) {
		global $electro_options;

		if( isset( $electro_options['single_product_style'] ) ) {
			$single_product_style = $electro_options['single_product_style'];
		}

		return $single_product_style;
	}
}

if ( ! function_exists( 'redux_toggle_sticky_payment_box' ) ) {
	function redux_toggle_sticky_payment_box() {
		global $electro_options;

		if( isset( $electro_options['sticky_payment_box'] ) && $electro_options['sticky_payment_box'] == '1' ) {
			$sticky_payment_box = true;
		} else {
			$sticky_payment_box = false;
		}

		return $sticky_payment_box;
	}
}