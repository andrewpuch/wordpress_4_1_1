<?php
/**
 * Creates a Ads Block Widget which can be placed in sidebar
 *
 * @class       Electro_Ads_Block_Widget
 * @version     1.0.0
 * @package     Widgets
 * @category    Class
 * @author      Transvelo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( class_exists( 'WP_Widget' ) ) :
	/**
	 * Electro Ads Block widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Ads_Block_Widget extends WP_Widget {

		public $max_entries = 5;

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add ads block widgets to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_ads_block_widget', esc_html__( 'Electro Ads Block', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {
			
			$atts = array();
			for( $i =0; $i<$this->max_entries; $i++ ) {
				if( isset( $instance['block-' . $i] ) && $instance['block-' . $i] != "" ) {
					$ad_text = isset( $instance['ad_text-' . $i] ) ? $instance['ad_text-' . $i] : '';
					$action_text = isset( $instance['action_text-' . $i] ) ? $instance['action_text-' . $i] : '';
					$action_link = isset( $instance['action_link-' . $i] ) ? $instance['action_link-' . $i] : '';
					$ad_image = isset( $instance['ad_image-' . $i] ) ? $instance['ad_image-' . $i] : '';
					$el_class = isset( $instance['el_class-' . $i] ) ? $instance['el_class-' . $i] : '';

					$atts[] = array(
						'ad_text'		=> $ad_text,
						'action_text'	=> $action_text,
						'action_link'	=> $action_link,
						'ad_image'		=> $ad_image,
						'el_class'		=> $el_class,
					);
				}
			}

			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_ads_block' ) ) {
				electro_ads_block( $atts );
			}
			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			for( $i =0; $i<$this->max_entries; $i++ ) {
				if( $new_instance['block-' . $i] == 0 || $new_instance['block-' . $i] == "" ) {
					$instance['block-' . $i] = $new_instance['block-' . $i];
					if ( ! empty( $new_instance['ad_text-' . $i] ) ) {
						$instance['ad_text-' . $i] = $new_instance['ad_text-' . $i];
					}
					if ( ! empty( $new_instance['action_text-' . $i] ) ) {
						$instance['action_text-' . $i] = $new_instance['action_text-' . $i];
					}
					if ( ! empty( $new_instance['action_link-' . $i] ) ) {
						$instance['action_link-' . $i] = strip_tags( stripslashes($new_instance['action_link-' . $i]) );
					}
					if ( ! empty( $new_instance['ad_image-' . $i] ) ) {
						$instance['ad_image-' . $i] = strip_tags( stripslashes($new_instance['ad_image-' . $i]) );
					}
					if ( ! empty( $new_instance['el_class-' . $i] ) ) {
						$instance['el_class-' . $i] = strip_tags( stripslashes($new_instance['el_class-' . $i]) );
					}
				} else {
					$count = $new_instance['block-' . $i] - 1;
					$instance['block-' . $count] = $new_instance['block-' . $i];
					if ( ! empty( $new_instance['ad_text-' . $i] ) ) {
						$instance['ad_text-' . $count] = $new_instance['ad_text-' . $i];
					}
					if ( ! empty( $new_instance['action_text-' . $i] ) ) {
						$instance['action_text-' . $count] = $new_instance['action_text-' . $i];
					}
					if ( ! empty( $new_instance['action_link-' . $i] ) ) {
						$instance['action_link-' . $count] = strip_tags( stripslashes($new_instance['action_link-' . $i]) );
					}
					if ( ! empty( $new_instance['ad_image-' . $i] ) ) {
						$instance['ad_image-' . $count] = strip_tags( stripslashes($new_instance['ad_image-' . $i]) );
					}
					if ( ! empty( $new_instance['el_class-' . $i] ) ) {
						$instance['el_class-' . $count] = strip_tags( stripslashes($new_instance['el_class-' . $i]) );
					}
				}
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			// If no sidebars exists.
			if ( !$wp_registered_sidebars ) {
				echo '<p>'. esc_html__('No sidebars are available.', 'electro' ) .'</p>';
				return;
			}

			?>
			<div class="widget-ads-block-container">
				<div class="widget-ads-block-input-containers">
					<?php
					for( $i =0; $i<$this->max_entries; $i++ ) {
						$block = isset( $instance['block-' . $i] ) ? $instance['block-' . $i] : '';
						$ad_text = isset( $instance['ad_text-' . $i] ) ? $instance['ad_text-' . $i] : '';
						$action_text = isset( $instance['action_text-' . $i] ) ? $instance['action_text-' . $i] : '';
						$action_link = isset( $instance['action_link-' . $i] ) ? $instance['action_link-' . $i] : '';
						$ad_image = isset( $instance['ad_image-' . $i] ) ? $instance['ad_image-' . $i] : '';
						$el_class = isset( $instance['el_class-' . $i] ) ? $instance['el_class-' . $i] : '';
						
						$display = '';
						if( ! isset($instance['block-' . $i]) || ($instance['block-' . $i] == "") ) {
							$display = 'style="display:none;"';
							unset($instance);
						}
						?>
						<div id="ads-input-block-<?php echo esc_attr( $i+1 ); ?>" class="ads-input-block" <?php echo ( $display ); ?>>
							<h3 class="entry-title"><?php echo esc_html__( 'Block', 'electro' ); ?></h3>
							<div class="entry-desc">
								<input id="<?php echo esc_attr( $this->get_field_id('block-' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('block-' . $i ) ); ?>" type="hidden" value="<?php echo esc_attr( $block ); ?>">
								<p>
									<label for="<?php echo esc_attr( $this->get_field_id('ad_text-' . $i) ); ?>"><?php esc_html_e( 'Ad Text:', 'electro' ) ?></label>
									<textarea rows="1" cols="28" id="<?php echo esc_attr( $this->get_field_id('ad_text-' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name('ad_text-' . $i) ); ?>"><?php echo wp_kses_post( $ad_text ); ?></textarea>
								</p>
								<p>
									<label for="<?php echo esc_attr( $this->get_field_id('action_text-' . $i) ); ?>"><?php esc_html_e( 'Action Text:', 'electro' ) ?></label>
									<textarea rows="1" cols="28" id="<?php echo esc_attr( $this->get_field_id('action_text-' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name('action_text-' . $i) ); ?>"><?php echo wp_kses_post( $action_text ); ?></textarea>
								</p>
								<p>
									<label for="<?php echo esc_attr( $this->get_field_id('action_link-' . $i) ); ?>"><?php esc_html_e( 'Action Link:', 'electro' ) ?></label>
									<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('action_link-' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name('action_link-' . $i) ); ?>" value="<?php echo esc_attr( $action_link ); ?>" />
								</p>
								<p>
									<label for="<?php echo esc_attr( $this->get_field_id('ad_image-' . $i) ); ?>"><?php esc_html_e( 'Ad Image:', 'electro' ) ?></label>
									<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('ad_image-' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name('ad_image-' . $i) ); ?>" value="<?php echo esc_attr( $ad_image ); ?>" />
								</p>
								<p>
									<label for="<?php echo esc_attr( $this->get_field_id('el_class-' . $i) ); ?>"><?php esc_html_e( 'Extra Class:', 'electro' ) ?></label>
									<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('el_class-' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name('el_class-' . $i) ); ?>" value="<?php echo esc_attr( $el_class ); ?>" />
								</p>
								<p><a href="#"><span class="delete-block"><?php esc_html_e( 'Delete', 'electro' ) ?></span></a></p>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<div class="message"><p><?php echo esc_html__( 'Reached the maximum block. Cannot add more block.', 'electro' ) ?></p></div>
				<div class="add-new-block" style="display:none;"><?php echo esc_html__( 'Add New Block', 'electro' ) ?></div>
			</div>
			<script type="text/javascript">
				(function($) {
					$(document).ready(function($) {
						$.each($(".widget-ads-block-input-containers").children(), function(){
							if($(this).find('input').val() != ''){
								$(this).show();
							}
						});
						$('.widget-ads-block-container').off('click', '.add-new-block');
						$(".widget-ads-block-container").on("click", ".add-new-block", function(e) {
							var rows = 0;
							$.each($(".widget-ads-block-input-containers").children(), function(){
								if($(this).find('input').val() == ''){
									$(this).find(".entry-title").addClass("active");
									$(this).find(".entry-desc").slideDown();
									$(this).find('input').first().val('0');
									$(this).show();
									return false;
								} else {
									rows++;
									$(this).show()
									$(this).find(".entry-title").removeClass("active");
									$(this).find(".entry-desc").slideUp();
								}
							});
							if( rows == '<?php echo esc_js( $this->max_entries ); ?>' ) {
								$(".widget-ads-block-container .message").show();
							}
						});
						$(".widget-ads-block-container").on("click", ".delete-block", function(e) {
							var count = 1;
							var current = $(this).closest('.ads-input-block').attr('id');
							$.each($("#"+current+" .entry-desc").children(), function(){
								$(this).val('');
							});
							$.each($("#"+current+" .entry-desc p").children(), function(){
								$(this).val('');
							});
							$('#'+current+" .entry-title").removeClass('active');
							$('#'+current+" .entry-desc").hide();
							$('#'+current).remove();
							$.each($(".widget-ads-block-input-containers").children(), function(){
								if($(this).find('input').val() != ''){
									$(this).find('input').first().val(count);
								}
								count++;
							});
						});
						$('.ads-input-block').off('click', '.entry-title');
						$(".ads-input-block").on("click", ".entry-title", function(e) {
							if($(this).hasClass("active")){
								$(this).removeClass("active");
								$(this).next(".entry-desc").slideUp();
							} else {
								$(".widget-ads-block-input-containers .entry-title").removeClass("active");
								$(".widget-ads-block-input-containers .entry-desc").slideUp();
								$(this).addClass("active");
								$(this).next(".entry-desc").slideDown();
							}
						});
					});
				})(jQuery);
			</script>
			<style type="text/css">
				.widget-ads-block-container .add-new-block{
					background: #ccc none repeat scroll 0 0;font-weight: bold;margin: 20px 0px 9px;padding: 6px;text-align: center;display:block!important;cursor:pointer;
				}
				.widget-ads-block-container .delete-block{
					text-decoration: underline;color:red;
				}
				.widget-ads-block-container{
					padding:10px 0 0;
				}
				.widget-ads-block-container .ads-input-block{ padding:0; border:1px solid #e5e5e5; margin:10px 0 0; clear:both;}
				.widget-ads-block-container .ads-input-block:first-child{
					margin:0;
				}
				.widget-ads-block-container .entry-title{
					display:block; font-size:14px; line-height:18px; font-weight:600; background:#f1f1f1; padding:7px 5px; position:relative; margin:0;
				}
				.widget-ads-block-container .entry-title:after{
					content: '\f140'; font: 400 20px/1 dashicons; position:absolute; right:10px; top:6px; color:#a0a5aa;
				}
				.widget-ads-block-container .entry-title.active:after{
					content: '\f142';
				}
				.widget-ads-block-container .entry-desc{
					display:none; padding:0 10px 10px; border-top:1px solid #e5e5e5;
				}
				.widget-ads-block-container .message{
					padding:6px;display:none;color:red;font-weight:bold;
				}
			</style>
			<?php
		}
	}
endif;