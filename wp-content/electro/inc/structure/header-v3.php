<?php
/**
 * Functions used in Header v3
 */

if ( ! function_exists( 'electro_primary_navbar' ) ) {
	/**
	 *
	 */
	function electro_primary_navbar() {

		if ( apply_filters( 'show_electro_primary_navbar', true ) ) : ?>
		<nav class="navbar navbar-primary navbar-full yamm">
			<div class="container">
				<div class="clearfix">
					  <button class="navbar-toggler hidden-sm-up pull-right flip" type="button" data-toggle="collapse" data-target="#header-v3">
					    	&#9776;
					  </button>
				  </div>

			   <div class="collapse navbar-toggleable-xs" id="header-v3">
					<?php
						wp_nav_menu( array(
							'theme_location'	=> 'navbar-primary',
							'container'			=> false,
							'menu_class'		=> 'nav navbar-nav',
							'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
							'walker'            => new wp_bootstrap_navwalker()
						) );
					?>
				</div>
			</div>
		</nav>
		<?php
		endif;
	}
}
