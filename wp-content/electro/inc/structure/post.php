<?php
/**
 * Template functions used for posts.
 *
 * @package electro
 */

if ( ! function_exists( 'electro_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 * @since 1.0.0
	 */
	function electro_post_header() { ?>
		<header class="entry-header">
		<?php
		if ( is_single() ) {
			$comments_link = '';
			ob_start();
			electro_comment_meta();
			$comments_link = ob_get_clean();

			the_title( '<h1 class="entry-title">', sprintf( '%s</h1>', $comments_link ) );
			electro_post_meta();
		} else {

			the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
			
			if ( 'post' == get_post_type() ) {
				electro_post_meta();
			}
		}
		?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'electro_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function electro_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		$posted_on = sprintf(
			_x( '%s', 'post date', 'electro' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
		echo wp_kses( apply_filters( 'electro_single_post_posted_on_html', '<span class="posted-on">' . $posted_on . '</span>', $posted_on ), array(
			'span' => array(
				'class'  => array(),
			),
			'a'    => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
			),
			'time' => array(
				'datetime' => array(),
				'class'    => array(),
			),
		 ) );
	}
}

if ( ! function_exists( 'electro_post_meta' ) ) {
	/**
	 * Display the post meta
	 *
	 * @since 1.0.0
	 */
	function electro_post_meta() {
		?>
		<div class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search.

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'electro' ) );
			if ( $categories_list ) : ?>
				<span class="cat-links">
					<?php
					echo wp_kses_post( $categories_list );
					?>
				</span>
			<?php endif; // End if categories. ?> 

			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'electro' ) );
			if ( $tags_list && apply_filters( 'electro_is_single_post_tags_list', false ) ) : ?>
				<span class="tags-links">
					<?php
					echo wp_kses_post( $tags_list );
					?>
				</span>
			<?php endif; // End if $tags_list. ?>

			<?php electro_posted_on(); ?>

			<?php if( is_multi_author() ) : ?>
				<span class="author">
					<?php
						the_author_posts_link();
					?>
				</span>
			<?php endif; ?>

			<?php endif; // End if 'post' == get_post_type(). ?>
			
		</div>
		<?php
	}
}

if ( ! function_exists( 'electro_comment_meta' ) ) {
	/**
	 * Display the comment meta
	 *
	 * @since 1.0.0
	 */
	function electro_comment_meta() {
		if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'electro' ), '1', '%' ); ?></span>
		<?php endif;
	}
}

if ( ! function_exists( 'electro_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function electro_post_content() {
		?>
		<div class="entry-content">
		<?php
		the_content(
			sprintf(
				__( 'Continue reading %s', 'electro' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);
		wp_link_pages( array(
			'before' => '<p class="page-links"><span class="page-links-label">' . __( 'Pages:', 'electro' ) . '</span>',
			'pagelink' => '<span>%</span>',
			'after'  => '</p>',
		) );
		?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'electro_post_excerpt' ) ) {
	/**
	 * Display the post excerpt with a link to the single post
	 * @since 1.0.0
	 */
	function electro_post_excerpt() {
		?>
		<div class="entry-content">
		
		<?php
		the_excerpt();
		wp_link_pages( array(
			'before' => '<p class="page-links"><span class="page-links-label">' . __( 'Pages:', 'electro' ) . '</span>',
			'pagelink' => '<span>%</span>',
			'after'  => '</p>',
		) );
		?>

		</div><!-- .post-excerpt -->
		<?php
	}
}

if ( ! function_exists( 'electro_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function electro_paging_nav() {
		global $wp_query;
		$args = array(
			'type' 	    => 'list',
			'next_text' => _x( 'Next', 'Next post', 'electro' ) . '&nbsp;<span class="meta-nav">&rarr;</span>',
			'prev_text' => '<span class="meta-nav">&larr;</span>&nbsp' . _x( 'Previous', 'Previous post', 'electro' ),
			);
		the_posts_pagination( $args );
	}
}


if ( ! function_exists( 'electro_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function electro_post_nav() {
		$args = array(
			'next_text' => '%title &nbsp;<span class="meta-nav">&rarr;</span>',
			'prev_text' => '<span class="meta-nav">&larr;</span>&nbsp;%title',
			);
		the_post_navigation( $args );
	}
}

if( ! function_exists( 'electro_author_info' ) ) {
	/**
	 * Display Author Info
	 */
	function electro_author_info() {
		if( apply_filters( 'electro_show_author_info', true ) ) :
			?>
			<div class="post-author-info">
				<div class="media">
					<div class="media-left media-middle">
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
							<?php echo get_avatar( get_the_author_meta( 'ID' ) , 160 ); ?>
						</a>
					</div>
					<div class="media-body">
						<h4 class="media-heading"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author(); ?></a></h4>
						<p><?php echo get_the_author_meta( 'description' );?></p>
					</div>
				</div>
			</div>
			<?php
		endif;
	}
}

if( ! function_exists( 'electro_post_loop_media' ) ) {
	function electro_post_loop_media() {
		$blog_style = electro_get_blog_style();
		
		if( $blog_style != 'blog-list' && $blog_style != 'blog-grid' ) {
			electro_post_media_attachment();
		} else {
			echo '<div class="media-attachment">';
			electro_post_thumbnail();
			echo '</div>';
		}
	}
}

if( ! function_exists( 'electro_post_loop_content' ) ) {
	function electro_post_loop_content() {
		electro_post_excerpt();
		electro_post_readmore();
		electro_comment_meta();
	}
}

if ( ! function_exists( 'electro_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @since 1.0.0
	 */
	function electro_post_thumbnail() {
		
		$image_size 			= electro_get_post_thumbnail_size();
		$post_format 			= get_post_format();
		$post_icon 				= electro_get_post_icon( $post_format );
		$should_link 			= is_single() ? false : true;
		$enable_placeholder_img = is_single() ? false : apply_filters( 'electro_loop_post_placeholder_img', true );

		echo electro_get_thumbnail( get_the_ID(), $image_size, $enable_placeholder_img, $should_link, $post_icon );
	}
}

if( ! function_exists( 'electro_get_post_thumbnail_size' ) ) {
	/**
	 * Return the post thumbnail size of the post
	 *
	 * @var $image_size thumbnail size. thumbnail|medium|large|full|$custom
	 * @param string $image_size the post thumbnail size.
	 * @since 1.0.0
	 */
	function electro_get_post_thumbnail_size( $image_size = 'full' ) {

		$image_size = 'electro_blog_medium';
		
		if( is_single() ) {
		
			$image_size = 'electro_blog_medium';
		
		} else {
			
			$blog_style 	= electro_get_blog_style();
			$blog_layout 	= electro_get_blog_layout();
			
			if( $blog_layout == 'full-width' && $blog_style != 'blog-list' && $blog_style != 'blog-grid' ) {
				$image_size = 'electro_blog_large';
			} elseif( $blog_style == 'blog-list' || $blog_style == 'blog-grid' ) {
				$image_size = 'electro_blog_small';
			} elseif( $blog_style == 'blog-default' ) {
				$image_size = 'electro_blog_medium';
			}
		}

		return apply_filters( 'electro_get_post_thumbnail_size', $image_size );
	}
}

if( ! function_exists( 'electro_excerpt_length' ) ) {
	function electro_excerpt_length() {
		return apply_filters( 'electro_excerpt_length', 30 );
	}
}

if( ! function_exists( 'electro_excerpt_more' ) ) {
	function electro_excerpt_more() {
		return apply_filters( 'electro_excerpt_more', '' );
	}
}

if( ! function_exists( 'electro_post_readmore' ) ) {
	/**
	 * Display the loop post read more link
	 * @since 1.0.0
	 */
	function electro_post_readmore() {
		?>
		<div class="post-readmore"><a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php echo apply_filters( 'electro_blog_post_readmore_text', esc_html__( 'Read More', 'electro' ) ); ?></a></div>
		<?php
	}
}

if( ! function_exists( 'electro_post_media_attachment' ) ) {
	/**
	 * Displays the media attachment of the post
	 * @since 1.0.0
	 */
	function electro_post_media_attachment() { 
		
		$post_format = get_post_format();
		
		ob_start();

		if( $post_format == 'gallery' ){
			electro_gallery_slideshow( get_the_ID() );	
		} else if ( $post_format == 'video' ){
			electro_video_player( get_the_ID() );
		} else if ( $post_format == 'audio' ){
			electro_audio_player( get_the_ID() );
		} else if ( $post_format == 'image' || has_post_thumbnail() ){
			electro_post_thumbnail();
		} else {
		}

		$media_attachment = ob_get_clean();

		if( ! empty( $media_attachment ) ) {
			echo '<div class="media-attachment">' . $media_attachment . '</div>';
		}

	}
}

if ( !function_exists( 'electro_gallery_slideshow' ) ) :
	/**
	 * Output Gallery (slide show) for Post Format.
	 */
	function electro_gallery_slideshow($post_id , $thumbnail = 'post-thumbnail') {
		global $post, $electro_version;
		
		$post_id = esc_attr( ( $post_id ? $post_id : $post->ID ) );

		// Get the media ID's
		$ids = esc_attr( get_post_meta($post_id, 'postformat_gallery_ids', true) );

		// Query the media data
		$attachments = get_posts( array(
			'post__in' 			=> explode(",", $ids),
			'orderby' 			=> 'post__in',
			'post_type' 		=> 'attachment',
			'post_mime_type' 	=> 'image',
			'post_status' 		=> 'any',
			'numberposts' 		=> -1
		));

		// Create the media display
		if ($attachments) : 
			wp_enqueue_script( 'owl-carousel-js', 	get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), $electro_version, true );
		?>
		<div class="media-attachment-gallery">
			<div id="owl-carousel-<?php echo esc_attr( $post_id ); ?>" class="owl-carousel owl-inner-pagination owl-inner-nav owl-blog-post-gallery">
			<?php foreach ($attachments as $attachment): ?>
				<div class="item">
					<figure>
						<?php echo wp_get_attachment_image($attachment->ID, $thumbnail); ?>
					</figure>
				</div><!-- /.item -->
			<?php endforeach; ?>
			</div>
			
		</div><!-- /.media-attachment-gallery -->
		<script type="text/javascript">
	
			jQuery(document).ready(function(){
				if(jQuery().owlCarousel) {
					jQuery("#owl-carousel-<?php echo esc_attr( $post_id ); ?>").owlCarousel({
						items : 1,
						nav : false,
						slideSpeed : 300,
						dots: true,
						paginationSpeed : 400,
						navText: ["", ""],
						autoHeight: true,
						responsive:{
							0:{
								items:1
							},
							600:{
								items:1
							},
							1000:{
								items:1
							}
						}
					});

					jQuery(".slider-next").on( 'click', function () {
						var owl = jQuery(jQuery(this).data('target'));
						owl.trigger('next.owl.carousel');
						return false;
					});

					jQuery(".slider-prev").on( 'click', function () {
						var owl = jQuery(jQuery(this).data('target'));
						owl.trigger('prev.owl.carousel');
						return false;
					});
				}
			});

		</script>
		<?php endif;
	}
endif;

if ( !function_exists( 'electro_audio_player' ) ) :
	/**
	 *  Output Audio Player for Post Format
	 */
    function electro_audio_player($post_id, $width = 1200) {
    	global $post;

    	$post_id = esc_attr( ( $post_id ? $post_id : $post->ID ) );

    	// Get the player media
		$mp3    = get_post_meta($post_id, 'postformat_audio_mp3', 		TRUE);
		$ogg    = get_post_meta($post_id, 'postformat_audio_ogg', 		TRUE);
		$embed  = get_post_meta($post_id, 'postformat_audio_embedded', 	TRUE);
		$height = get_post_meta($post_id, 'postformat_poster_height', 	TRUE);

		if ( isset($embed) && $embed != '' ) {
			// Embed Audio
			if( !empty($embed) ) {
				// run oEmbed for known sources to generate embed code from audio links
				echo $GLOBALS['wp_embed']->autoembed( stripslashes( htmlspecialchars_decode( $embed ) ) );

				return; // and.... Done!
			}

		} else if( ! empty( $mp3 ) || ! empty ( $ogg ) ) {

			wp_enqueue_script( 'jplayer', get_template_directory_uri() . '/assets/js/jquery.jplayer.min.js', array( 'jquery' ), '1.10.2', true );
		    
		    // Other audio formats ?>

			<script type="text/javascript">
		
				jQuery(document).ready(function(){

					if(jQuery().jPlayer) {
						jQuery("#jquery_jplayer_<?php echo esc_attr( $post_id ); ?>").jPlayer({
							ready: function (event) {

								// set media
								jQuery(this).jPlayer("setMedia", {
								    <?php 
								    if($mp3 != '') :
										echo 'mp3: "'. $mp3 .'",';
									endif;
									if($ogg != '') :
										echo 'oga: "'. $ogg .'",';
									endif; ?>
									end: ""
								});
							},
							<?php if( !empty($poster) ) { ?>
							size: {
	        				    width: "<?php echo esc_js( $width ); ?>px",
	        				    height: "<?php echo esc_js( $height . 'px' ); ?>"
	        				},
	        				<?php } ?>
							swfPath: "<?php echo get_template_directory_uri(); ?>/assets/js",
							cssSelectorAncestor: "#jp_interface_<?php echo esc_attr( $post_id ); ?>",
							supplied: "<?php if($ogg != '') : ?>oga,<?php endif; ?><?php if($mp3 != '') : ?>mp3, <?php endif; ?> all"
						});
					
					}
				});
			</script>

			<div id="jquery_jplayer_<?php echo esc_attr( $post_id ); ?>" class="jp-jplayer jp-jplayer-audio"></div>

			<div class="jp-audio-container">
				<div class="jp-audio">
					<div class="jp-type-single">
						<div id="jp_interface_<?php echo esc_attr( $post_id ); ?>" class="jp-interface">
							<ul class="jp-controls">
								<li><div class="seperator-first"></div></li>
								<li><div class="seperator-second"></div></li>
								<li><a href="#" class="jp-play" tabindex="1"><i class="fa fa-play"></i><span>play</span></a></li>
								<li><a href="#" class="jp-pause" tabindex="1"><i class="fa fa-pause"></i><span>pause</span></a></li>
								<li><a href="#" class="jp-mute" tabindex="1"><i class="fa fa-volume-up"></i><span>mute</span></a></li>
								<li><a href="#" class="jp-unmute" tabindex="1"><i class="fa fa-volume-off"></i><span>unmute</span></a></li>
							</ul>
							<div class="jp-progress-container">
								<div class="jp-progress">
									<div class="jp-seek-bar">
										<div class="jp-play-bar"></div>
									</div>
								</div>
							</div>
							<div class="jp-volume-bar-container">
								<div class="jp-volume-bar">
									<div class="jp-volume-bar-value"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 
		} // End if embedded/else
    }
endif;

if ( !function_exists( 'electro_video_player' ) ) :
	/**
	 * Video Player / Embeds (self-hosted, jPlayer)
	 */
    function electro_video_player($post_id, $width = 1200) {
    	global $post;

    	$post_id = esc_attr( ( $post_id ? $post_id : $post->ID ) );
	
    	// Get the player media options
    	$embed 		= get_post_meta($post_id, 'postformat_video_embed', 	true);
    	$height 	= get_post_meta($post_id, 'postformat_video_height', 	true);
    	$m4v 		= get_post_meta($post_id, 'postformat_video_m4v', 		true);
    	$ogv 		= get_post_meta($post_id, 'postformat_video_ogv', 		true);
    	$webm 		= get_post_meta($post_id, 'postformat_video_webm', 		true);
    	$poster 	= get_post_meta($post_id, 'postformat_video_poster', 	true);

		if( !empty($embed) ) {
			$embed = do_shortcode( $embed );
			// run oEmbed for known sources to generate embed code from video links
			echo '<div class="video-container"><div class="embed-responsive embed-responsive-16by9">'. $GLOBALS['wp_embed']->autoembed( stripslashes(htmlspecialchars_decode($embed)) ) .'</div></div>';

			return; // and.... Done!
		} else if( ! empty( $m4v ) || ! empty ( $ogv ) || ! empty ( $webm ) || ! empty ( $poster ) ) {
			wp_enqueue_script( 'jplayer', get_template_directory_uri() . '/assets/js/jquery.jplayer.min.js', array( 'jquery' ), '1.10.2', true );
		
			?>
		    <script type="text/javascript">
		    	jQuery(document).ready(function(){
				
		    		if(jQuery().jPlayer) {
		    			jQuery("#jquery_jplayer_<?php echo esc_attr( $post_id ); ?>").jPlayer({
		    				ready: function (event) {
								// mobile display helper
								// if(event.jPlayer.status.noVolume) {	$('#jp_interface_<?php echo esc_attr( $post_id ); ?>').addClass('no-volume'); }
								// set media
		    					jQuery(this).jPlayer("setMedia", {
		    						<?php if($m4v != '') : ?>
		    						m4v: "<?php echo esc_js( $m4v ); ?>",
		    						<?php endif; ?>
		    						<?php if($ogv != '') : ?>
		    						ogv: "<?php echo esc_js( $ogv ); ?>",
		    						<?php endif; ?>
		    						<?php if($webm != '') : ?>
		    						webmv: "<?php echo esc_js( $webm ); ?>",
		    						<?php endif; ?>
		    						<?php if ($poster != '') : ?>
		    						poster: "<?php echo esc_js( $poster ); ?>"
		    						<?php endif; ?>
		    					});
		    				},
		    				size: {
		    				    width: "<?php echo esc_js( $width ); ?>px",
		    				},
		    				swfPath: "<?php echo get_template_directory_uri(); ?>/assets/js",
		    				cssSelectorAncestor: "#jp_interface_<?php echo esc_attr( $post_id ); ?>",
		    				supplied: "<?php if($m4v != '') : ?>m4v, <?php endif; ?><?php if($ogv != '') : ?>ogv, <?php endif; ?> all"
		    			});
		    		}
		    	});
		    </script>

		    <div id="jquery_jplayer_<?php echo esc_attr( $post_id ); ?>" class="jp-jplayer jp-jplayer-video"></div>

		    <div class="jp-video-container">
		        <div class="jp-video">
		            <div class="jp-type-single">
		                <div id="jp_interface_<?php echo esc_attr( $post_id ); ?>" class="jp-interface">
		                    <ul class="jp-controls">
		                    	<li><div class="seperator-first"></div></li>
		                        <li><div class="seperator-second"></div></li>
		                        <li><a href="#" class="jp-play" tabindex="1"><i class="fa fa-play"></i><span>play</span></a></li>
		                        <li><a href="#" class="jp-pause" tabindex="1"><i class="fa fa-pause"></i><span>pause</span></a></li>
		                        <li><a href="#" class="jp-mute" tabindex="1"><i class="fa fa-volume-up"></i><span>mute</span></a></li>
		                        <li><a href="#" class="jp-unmute" tabindex="1"><i class="fa fa-volume-off"></i><span>unmute</span></a></li>
		                    </ul>
		                    <div class="jp-progress-container">
		                        <div class="jp-progress">
		                            <div class="jp-seek-bar">
		                                <div class="jp-play-bar"></div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="jp-volume-bar-container">
		                        <div class="jp-volume-bar">
		                            <div class="jp-volume-bar-value"></div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		    <?php
		}
	}
endif;

if ( ! function_exists( 'electro_blog_navigation' ) ) {
	/**
	 * Display Blog Navigation
	 * @since  1.0.0
	 * @return void
	 */
	function electro_blog_navigation() {
		$blog_layout 	= electro_get_blog_layout();
		$blog_style 	= electro_get_blog_style();

		if( apply_filters( 'electro_enable_blog_navigation', true ) && $blog_layout == 'full-width' ) {
			?>
			<nav id="blog-navigation" class="blog-navigation navbar yamm" aria-label="<?php esc_attr_e( 'Blog Navigation', 'electro' ); ?>">
				<div class="navbar-header">
					<button class="navbar-toggle collapsed" data-target="#nav-blog-horizontal-menu-collapse" data-toggle="collapse" type="button">
						<span class="sr-only"><?php echo esc_html__( 'Toggle navigation', 'electro' ); ?></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="nav-bg-class">
					<div class="collapse navbar-collapse" id="nav-blog-horizontal-menu-collapse">
						<div class="nav-outer">
							<?php
								wp_nav_menu(
									array(
										'theme_location'	=> 'blog-menu',
										'container'			=> 'false',
										'menu_class'        => 'nav list-unstyled blog-nav-menu',
										'fallback_cb'		=> 'wp_bootstrap_navwalker::fallback',
										'walker'			=> new wp_bootstrap_navwalker()
									)
								);
							?>
						</div>
						<div class="clearfix"></div>
					</div><!-- /.navbar-collapse -->
				</div>
			</nav><!-- #blog-navigation -->
			<?php
		}
	}
}

if ( ! function_exists( 'electro_post_body_wrap_start' ) ) {
	function electro_post_body_wrap_start() {
		?>
		<div class="content-body">
		<?php
	}
}

if ( ! function_exists( 'electro_post_body_wrap_end' ) ) {
	function electro_post_body_wrap_end() {
		?>
		</div>
		<?php
	}
}