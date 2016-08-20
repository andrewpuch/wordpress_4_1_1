<?php
/**
 * Display single product advanced reviews (comments)
 *
 */
global $product;

$review_count 		= $product->get_review_count();
$avg_rating_number 	= number_format( $product->get_average_rating(), 1 );
$rating_counts 		= Electro_WC_Helper::get_ratings_counts( $product );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="electro-advanced-reviews">
	<div class="advanced-review row">
		<div class="col-xs-12 col-md-6">
			<h2 class="based-title"><?php echo esc_html( sprintf( _n( 'Based on %s review', 'Based on %s reviews', $review_count, 'electro' ), $review_count ) ); ?></h2>
			<div class="avg-rating">
				<?php 
					$avg_rating_html = '<span class="avg-rating-number">' . $avg_rating_number . '</span>';
					echo wp_kses_post( sprintf( __( '%s overall', 'electro' ), $avg_rating_html ) ); ?>
			</div>
			<div class="rating-histogram">
				<?php for( $rating = 5; $rating > 0; $rating-- ) : ?>
				<div class="rating-bar">
					<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'electro' ), $rating ); ?>">
						<span style="width:<?php echo ( ( $rating / 5 ) * 100 ); ?>%"></span>
					</div>
					<?php 
						$rating_percentage = 0;
						if ( isset( $rating_counts[$rating] ) ) {
							$rating_percentage = (round( $rating_counts[$rating] / $review_count, 2 ) * 100 );
						}
					?>
					<div class="rating-percentage-bar">
						<span style="width:<?php echo esc_attr( $rating_percentage ); ?>%" class="rating-percentage"></span>
					</div>
					<?php if ( isset( $rating_counts[$rating] ) ) : ?>
					<div class="rating-count"><?php echo esc_html( $rating_counts[$rating] ); ?></div>
					<?php else : ?>
					<div class="rating-count zero">0</div>
					<?php endif; ?>
				</div>
				<?php endfor; ?>
			</div>
		</div>
		<div class="col-xs-12 col-md-6">
			
			<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

			<div id="review_form_wrapper">
				<div id="review_form">
					<?php
						$commenter = wp_get_current_commenter();

						$comment_form = array(
							'title_reply'          => have_comments() ? __( 'Add a review', 'electro' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'electro' ), get_the_title() ),
							'title_reply_to'       => __( 'Leave a Reply to %s', 'electro' ),
							'comment_notes_before' => '',
							'comment_notes_after'  => '',
							'fields'               => array(
								'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'electro' ) . ' <span class="required">*</span></label> ' .
								            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
								'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'electro' ) . ' <span class="required">*</span></label> ' .
								            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
							),
							'label_submit'  => __( 'Add Review', 'electro' ),
							'logged_in_as'  => '',
							'comment_field' => ''
						);

						if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
							$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'electro' ), esc_url( $account_page_url ) ) . '</p>';
						}

						if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
							$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'electro' ) .'</label><select name="rating" id="rating">
								<option value="">' . __( 'Rate&hellip;', 'electro' ) . '</option>
								<option value="5">' . __( 'Perfect', 'electro' ) . '</option>
								<option value="4">' . __( 'Good', 'electro' ) . '</option>
								<option value="3">' . __( 'Average', 'electro' ) . '</option>
								<option value="2">' . __( 'Not that bad', 'electro' ) . '</option>
								<option value="1">' . __( 'Very Poor', 'electro' ) . '</option>
							</select></p>';
						}

						$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'electro' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

						comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
					?>
				</div>
			</div>

		<?php else : ?>

			<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'electro' ); ?></p>

		<?php endif; ?>
		</div>
	</div>
	
	<div id="comments">
		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'electro' ); ?></p>

		<?php endif; ?>
	</div>

	<div class="clear"></div>
</div>