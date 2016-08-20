<?php
/**
 * Filter functions for Header Section of Theme Options
 */

if ( ! function_exists ( 'redux_toggle_top_bar' ) ) {
	function redux_toggle_top_bar( $enable ) {
		global $electro_options;

		if ( ! isset( $electro_options['header_top_bar_show'] ) ) {
			$electro_options['header_top_bar_show'] = true;
		}

		if ( $electro_options['header_top_bar_show'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}	
}

if ( ! function_exists( 'redux_apply_header_logo' ) ) {
	function redux_apply_header_logo( $logo ) {
		global $electro_options;

		if ( ! empty( $electro_options['site_header_logo']['url'] ) ) {
			ob_start();
			?>
			<div class="header-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header-logo-link">
					<img src="<?php echo esc_url( $electro_options['site_header_logo']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="img-header-logo" width="<?php echo esc_attr( $electro_options['site_header_logo']['width'] ); ?>" height="<?php echo esc_attr( $electro_options['site_header_logo']['height'] ); ?>" />
				</a>
			</div>
			<?php
			$logo = ob_get_clean();
		}

		return $logo;
	}
}

if ( ! function_exists( 'redux_apply_logo_image_src' ) ) {
	function redux_apply_logo_image_src( $logo_image_src ) {
		global $electro_options;

		if ( ! empty( $electro_options['site_header_logo']['url'] ) ) {
			$logo_image_src = $electro_options['site_header_logo'];
		}

		return $logo_image_src;
	}
}

if ( ! function_exists( 'redux_apply_header_style' ) ) {
	function redux_apply_header_style( $header_style ) {
		global $electro_options;

		if( isset( $electro_options['header_style'] ) ) {
			$header_style = $electro_options['header_style'];
		}

		return $header_style;
	}
}

if ( ! function_exists( 'redux_apply_header_vertical_menu_title' ) ) {
	function redux_apply_header_vertical_menu_title( $title ) {
		global $electro_options;

		if ( ! isset( $electro_options['header_vertical_menu_title'] ) ) {
			$electro_options['header_vertical_menu_title'] = esc_html__( 'All Departments', 'electro' );
		}

		return $electro_options['header_vertical_menu_title'];
	}
}

if ( ! function_exists( 'redux_apply_header_vertical_menu_icon' ) ) {
	function redux_apply_header_vertical_menu_icon( $icon ) {
		global $electro_options;

		if ( ! isset( $electro_options['header_vertical_menu_icon'] ) ) {
			$electro_options['header_vertical_menu_icon'] = 'fa fa-list-ul';
		}

		return $electro_options['header_vertical_menu_icon'];
	}
}

if ( ! function_exists( 'redux_apply_departments_menu_title' ) ) {
	function redux_apply_departments_menu_title( $title ) {
		global $electro_options;

		if ( ! isset( $electro_options['header_departments_menu_title'] ) ) {
			$electro_options['header_departments_menu_title'] = esc_html__( 'Shop by Department', 'electro' );
		}

		return $electro_options['header_departments_menu_title'];
	}
}

if ( ! function_exists( 'redux_apply_navbar_search_placeholder' ) ) {
	function redux_apply_navbar_search_placeholder( $placeholder ) {
		global $electro_options;

		if ( ! isset( $electro_options['header_navbar_search_placeholder'] ) ) {
			$electro_options['header_navbar_search_placeholder'] = esc_html__( 'Search for products', 'electro' );
		}

		return $electro_options['header_navbar_search_placeholder'];
	}
}

if ( ! function_exists( 'redux_toggle_header_search_dropdown' ) ) {
	function redux_toggle_header_search_dropdown( $enable ) {
		global $electro_options;

		if ( ! isset( $electro_options['enable_header_navbar_search_dropdown'] ) ) {
			$electro_options['enable_header_navbar_search_dropdown'] = true;
		}

		if ( $electro_options['enable_header_navbar_search_dropdown'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if( ! function_exists( 'redux_modify_search_dropdown_categories_args' ) ) {
	/**
	 * Implements top level or all categories option
	 */
	function redux_modify_search_dropdown_categories_args( $args ) {
		global $electro_options;

		if ( ! isset( $electro_options['header_navbar_search_dropdown_categories'] ) ) {
			$electro_options['header_navbar_search_dropdown_categories'] = 'show_only_top_level';
		}

		if ( $electro_options['header_navbar_search_dropdown_categories'] == 'show_only_top_level' ) {
			$args[ 'hierarchical' ] = 1;
			$args[ 'depth' ] 		= 1;
		} else {
			$args[ 'hierarchical']  = 1;
		}

		return $args;
	}
}

if ( ! function_exists( 'redux_apply_navbar_search_dropdown_text' ) ) {
	function redux_apply_navbar_search_dropdown_text( $title ) {
		global $electro_options;

		if ( ! isset( $electro_options['header_navbar_search_dropdown_text'] ) ) {
			$electro_options['header_navbar_search_dropdown_text'] = esc_html__( 'All Categories', 'electro' );
		}

		return $electro_options['header_navbar_search_dropdown_text'];
	}
}

if ( ! function_exists( 'redux_toggle_header_support_block' ) ) {
	function redux_toggle_header_support_block( $enable ) {
		global $electro_options;

		if ( ! isset( $electro_options['header_support_block_show'] ) ) {
			$electro_options['header_support_block_show'] = true;
		}

		if ( $electro_options['header_support_block_show'] ) {
			$enable = true;
		} else {
			$enable = false;
		}

		return $enable;
	}
}

if ( ! function_exists( 'redux_apply_header_support_number' ) ) {
	function redux_apply_header_support_number( $support_number ) {
		global $electro_options;

		if( isset( $electro_options['header_support_number'] ) ) {
			$support_number = $electro_options['header_support_number'];
		}

		return $support_number;
	}
}

if ( ! function_exists( 'redux_apply_header_support_email' ) ) {
	function redux_apply_header_support_email( $support_email ) {
		global $electro_options;

		if( isset( $electro_options['header_support_email'] ) ) {
			$support_email = $electro_options['header_support_email'];
		}

		return $support_email;
	}
}

if ( ! function_exists( 'redux_toggle_live_search' ) ) {
	function redux_toggle_live_search( $is_enabled ) {
		return true;
	}
}

if( ! function_exists( 'redux_toggle_sticky_header' ) ) {
	function redux_toggle_sticky_header() {
		global $electro_options;

		if( isset( $electro_options['sticky_header'] ) && $electro_options['sticky_header'] == '1' ) {
			$sticky_header = true;
		} else {
			$sticky_header = false;
		}

		return $sticky_header;
	}
}