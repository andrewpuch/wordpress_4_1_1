<?php
/**
 * Template functions that hook to electro_header_v1
 */

if ( ! function_exists( 'electro_vertical_menu' ) ) {
	/**
	 *
	 */
	function electro_vertical_menu() {
		?>
		<div class="col-xs-12 col-lg-3">
		<?php
			$vertical_menu_title = apply_filters( 'electro_vertical_menu_title', esc_html__( 'All Departments', 'electro' ) );
			$vertical_menu_icon  = apply_filters( 'electro_vertical_menu_icon', 'fa fa-list-ul' );

			if ( ( is_front_page() && ! is_home() ) || is_page_template( 'template-homepage-v1.php' ) ) :
				wp_nav_menu( array(
					'theme_location'	=> 'all-departments-menu',
					'container'			=> false,
					'items_wrap'     	=> '<ul class="list-group vertical-menu yamm make-absolute"><li class="list-group-item"><span><i class="' . esc_attr( $vertical_menu_icon ) . '"></i> ' . esc_html( $vertical_menu_title ). '</span></li>%3$s</ul>',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker(),
				) );
			else : ?>
				<ul class="list-group vertical-menu animate-dropdown">
					<li class="list-group-item dropdown">
						<a href="#" data-toggle="dropdown"><i class="<?php echo esc_attr( $vertical_menu_icon ); ?>"></i> <?php echo esc_html( $vertical_menu_title ); ?></a>
						<?php
						wp_nav_menu( array(
							'theme_location'	=> 'all-departments-menu',
							'container'			=> false,
							'menu_class'		=> 'dropdown-menu yamm',
							'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
							'walker'            => new wp_bootstrap_navwalker(),
						) );
						?>
					</li>
				</ul>
		<?php endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_secondary_nav' ) ) {
	/**
	 *
	 */
	function electro_secondary_nav() {
		?>
		<div class="col-xs-12 col-lg-9">
		<?php
			wp_nav_menu( array(
				'theme_location'	=> 'secondary-nav',
				'container'			=> false,
				'menu_class'		=> 'secondary-nav',
				'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
			) );
		?>
		</div>
		<?php
	}
}