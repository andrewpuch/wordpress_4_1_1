<?php
/**
 * Theme functions and template tags used in navbar
 */

if ( ! function_exists( 'electro_navbar' ) ) {
	/**
	 * Displays electro navbar
	 */
	function electro_navbar() {

		if ( apply_filters( 'show_electro_navbar', true ) ) : ?>
		<nav class="navbar navbar-primary navbar-full">
			<div class="container">
				<?php
				/**
				 * @hooked electro_departments_menu - 10
				 * @hooked electro_navbar_products_search - 20
				 * @hooked electro_navbar_compare - 30
				 * @hooked electro_navbar_wishlist - 40
				 * @hooked electro_navbar_mini_cart - 50
				 */
				do_action( 'electro_navbar' );
				?>
			</div>
		</nav>
		<?php
		endif;
	}
}

if ( ! function_exists( 'electro_departments_menu' ) ) {
	/**
	 * Displays Departments Menu
	 */
	function electro_departments_menu() {
		?>
		<ul class="nav navbar-nav departments-menu animate-dropdown">
			<li class="nav-item dropdown<?php if( is_page_template( 'template-homepage-v2.php' ) ) echo esc_attr( ' open' ); ?>">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="departments-menu-toggle" <?php if( !( is_page_template( 'template-homepage-v2.php' ) ) ) : ?>aria-haspopup="true" aria-expanded="false"<?php endif; ?>>
					<?php echo apply_filters( 'electro_departments_menu_title', esc_html__( 'Shop by Department', 'electro' ) ); ?>
				</a>
				<?php
					wp_nav_menu( array(
					'theme_location'	=> 'departments-menu',
					'container'			=> false,
					'menu_class'		=> 'dropdown-menu yamm departments-menu-dropdown',
					'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
					'walker'            => new wp_bootstrap_navwalker()
				) );
				?>
			</li>
		</ul>
		<?php
	}
}

if ( ! function_exists( 'electro_navbar_search' ) ) {
	/**
	 * Displays search box in navbar
	 */
	function electro_navbar_search() {
		electro_get_template( 'sections/navbar-search.php' );
	}
}

if ( ! function_exists( 'electro_navbar_compare' ) ) {
	/**
	 * Displays a link to compare page in navbar
	 */
	function electro_navbar_compare() {
		if( function_exists( 'electro_get_compare_page_url' ) ) {
			?>
			<ul class="navbar-compare nav navbar-nav pull-right flip">
				<li class="nav-item">
					<a href="<?php echo esc_attr( electro_get_compare_page_url() ); ?>" class="nav-link"><i class="ec ec-compare"></i></a>
				</li>
			</ul>
			<?php
		}
	}
}

if ( ! function_exists( 'electro_navbar_wishlist' ) ) {
	/**
	 * Displays a link to wishlist page in navbar
	 */
	function electro_navbar_wishlist() {
		if( function_exists( 'electro_get_wishlist_url' ) ) {
			?>
			<ul class="navbar-wishlist nav navbar-nav pull-right flip">
				<li class="nav-item">
					<a href="<?php echo esc_attr( electro_get_wishlist_url() ); ?>" class="nav-link"><i class="ec ec-favorites"></i></a>
				</li>
			</ul>
			<?php
		}
	}
}
