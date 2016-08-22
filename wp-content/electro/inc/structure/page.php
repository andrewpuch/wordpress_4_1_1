<?php
/**
 * Template functions used for pages.
 *
 * @package electro
 */

if ( ! function_exists( 'electro_page_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 * @since 1.0.0
	 * @return void
	 */
	function electro_page_header() {
		global $post;
		$page_meta_values = get_post_meta( $post->ID, '_electro_page_metabox', true );
		
		if ( isset( $page_meta_values['page_title'] ) && ! empty( $page_meta_values['page_title'] ) ) {
			$page_title = $page_meta_values['page_title'];
		} else {
			$page_title = get_the_title();
		}


		if( apply_filters( 'electro_show_page_header', true ) ) {
			$header_image_url = electro_get_page_header_image();
			if( $header_image_url != '' ) {
				?>
				<header class="entry-header header-with-cover-image" style="background-image: url(<?php echo esc_url( $header_image_url ) ?>);">
					<div class="caption">
						<h1 class="entry-title"><?php echo apply_filters( 'electro_page_title', wp_kses_post( $page_title ) ); ?></h1>
						<?php electro_page_subtitle(); ?>
					</div>
				</header><!-- .entry-header -->
				<?php
			} else {
				?>
				<header class="entry-header">
					<h1 class="entry-title"><?php echo apply_filters( 'electro_page_title', wp_kses_post( $page_title ) ); ?></h1>
					<?php electro_page_subtitle(); ?>
				</header><!-- .entry-header -->
				<?php
			}
		}
	}
}

if ( ! function_exists( 'electro_page_subtitle' ) ) {
	function electro_page_subtitle() {
		global $post;
		$page_meta_values = get_post_meta( $post->ID, '_electro_page_metabox', true );

		if ( isset( $page_meta_values['page_subtitle'] ) && ! empty( $page_meta_values['page_subtitle'] ) ) {
			?>
			<p class="entry-subtitle"><?php echo apply_filters( 'electro_page_subtitle', wp_kses_post( $page_meta_values['page_subtitle'] ), $post ); ?></p>
			<?php
		}
	}
}

if ( ! function_exists( 'electro_page_template_content' ) ) {
	/**
	 * Display the post content for a page template
	 * @since 1.0.0
	 */
	function electro_page_template_content() {
		while ( have_posts() ) : the_post();
			?>
			<div class="entry-content">
				<?php
					the_content();
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'electro' ),
						'after'  => '</div>',
					) );
				?>
			</div>
			<?php
		endwhile; // end of the loop.
	}
}

if ( ! function_exists( 'electro_page_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 * @since 1.0.0
	 */
	function electro_page_content() {
		?>
		<div class="entry-content">
			<?php
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'electro' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'electro_hide_page_header' ) ) {
	/**
	 * 
	 */
	function electro_hide_page_header() {

		$should_show_page_header = true;

		global $post;
		$page_meta_values = get_post_meta( $post->ID, '_electro_page_metabox', true );
		
		if ( isset( $page_meta_values['hide_page_header'] ) && $page_meta_values['hide_page_header'] == '1' ) {
			$should_show_page_header = false;
		}

		if( is_woocommerce_activated() && is_account_page() && !is_user_logged_in() ) {
			$should_show_page_header = false;

			if( is_wc_endpoint_url() ) {
				$should_show_page_header = true;
			}
		}

		if ( is_woocommerce_activated() && is_cart() && WC()->cart->is_empty() ) {
			$should_show_page_header = false;
		}

		return $should_show_page_header;
	}
}

if ( ! function_exists( 'electro_toggle_breadcrumb' ) ) {
	/**
	 * 
	 */
	function electro_toggle_breadcrumb( $show_breadcrumb ) {
		global $post;

		if ( isset( $post->ID ) ){
			$page_meta_values = get_post_meta( $post->ID, '_electro_page_metabox', true );
			
			if ( isset( $page_meta_values['hide_breadcrumb'] ) && $page_meta_values['hide_breadcrumb'] == '1' ) {
				$show_breadcrumb = false;
			}
		}
		return $show_breadcrumb;
	}
}

if( ! function_exists( 'electro_get_page_header_image' ) ) {
	/**
	 * Display the page header image
	 * @since 1.0.0
	 * @return void
	 */
	function electro_get_page_header_image() {
		global $post;

		$image_url = apply_filters( 'electro_default_page_header_image', '' );

		if( ! is_front_page() ) {

			$image_width = apply_filters( 'electro_page_header_image_width', 1170 );

			if( $post ){
				$image_id = get_post_thumbnail_id( $post->ID );
				$image = wp_get_attachment_image_src( $image_id, array( $image_width, $image_width ) );
				if ( is_page() && has_post_thumbnail( $post->ID ) && $image[1] >= $image_width ) {
					$image_url = $image[0];
				}
			}
		}

		return $image_url;
	}
}