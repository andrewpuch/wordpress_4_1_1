<?php
/**
 * Creates a Features Block Widget which can be placed in sidebar
 *
 * @class       Electro_Features_Block_Widget
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
	 * Electro Features Block widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Features_Block_Widget extends WP_Widget {

		public $max_entries = 6;

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add features block widgets to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_features_block_widget', esc_html__( 'Electro Features Block', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {
			
			$columns = isset( $instance['columns'] ) ? $instance['columns'] : 0;
			$features = array();
			for( $i =0; $i<$this->max_entries; $i++ ) {
				if( isset( $instance['block-' . $i] ) && $instance['block-' . $i] != "" ) {
					$icon_class = isset( $instance['icon_class-' . $i] ) ? $instance['icon_class-' . $i] : '';
					$feature = isset( $instance['feature-' . $i] ) ? $instance['feature-' . $i] : '';

					$features[] = array(
						'icon'		=> $icon_class,
						'text'		=> $feature,
					);
				}
			}

			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_features_list' ) ) {
				electro_features_list( $features, $columns );
			}
			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['columns'] ) ) {
				$instance['columns'] = strip_tags( stripslashes($new_instance['columns']) );
			}
			for( $i =0; $i<$this->max_entries; $i++ ) {
				if( $new_instance['block-' . $i] == 0 || $new_instance['block-' . $i] == "" ) {
					$instance['block-' . $i] = $new_instance['block-' . $i];
					if ( ! empty( $new_instance['icon_class-' . $i] ) ) {
						$instance['icon_class-' . $i] = strip_tags( stripslashes($new_instance['icon_class-' . $i]) );
					}
					if ( ! empty( $new_instance['feature-' . $i] ) ) {
						$instance['feature-' . $i] = $new_instance['feature-' . $i];
					}
				} else {
					$count = $new_instance['block-' . $i] - 1;
					$instance['block-' . $count] = $new_instance['block-' . $i];
					if ( ! empty( $new_instance['icon_class-' . $i] ) ) {
						$instance['icon_class-' . $count] = strip_tags( stripslashes($new_instance['icon_class-' . $i]) );
					}
					if ( ! empty( $new_instance['feature-' . $i] ) ) {
						$instance['feature-' . $count] = $new_instance['feature-' . $i];
					}
				}
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			$columns = isset( $instance['columns'] ) ? $instance['columns'] : '';

			// If no sidebars exists.
			if ( !$wp_registered_sidebars ) {
				echo '<p>'. esc_html__('No sidebars are available.', 'electro' ) .'</p>';
				return;
			}

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('columns') ); ?>"><?php esc_html_e( 'Columns:', 'electro' ) ?></label>
				<input type="number" max="6" min="1" step="1" class="widefat" id="<?php echo esc_attr( $this->get_field_id('columns') ); ?>" name="<?php echo esc_attr( $this->get_field_name('columns') ); ?>" value="<?php echo esc_attr( $columns ); ?>" />
			</p>
			<div class="widget-features-block-container">
				<div class="widget-features-block-input-containers">
					<?php
					for( $i =0; $i<$this->max_entries; $i++ ) {
						$block = isset( $instance['block-' . $i] ) ? $instance['block-' . $i] : '';
						$icon_class = isset( $instance['icon_class-' . $i] ) ? $instance['icon_class-' . $i] : '';
						$feature = isset( $instance['feature-' . $i] ) ? $instance['feature-' . $i] : '';
						$el_class = isset( $instance['el_class-' . $i] ) ? $instance['el_class-' . $i] : '';
						
						$display = '';
						if( ! isset($instance['block-' . $i]) || ($instance['block-' . $i] == "") ) {
							$display = 'style="display:none;"';
							unset($instance);
						}
						?>
						<div id="features-input-block-<?php echo esc_attr( $i+1 ); ?>" class="features-input-block" <?php echo ( $display ); ?>>
							<h3 class="entry-title"><?php echo esc_html__( 'Block', 'electro' ); ?></h3>
							<div class="entry-desc">
								<input id="<?php echo esc_attr( $this->get_field_id('block-' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('block-' . $i ) ); ?>" type="hidden" value="<?php echo esc_attr( $block ); ?>">
								<p>
									<label for="<?php echo esc_attr( $this->get_field_id('icon_class-' . $i) ); ?>"><?php esc_html_e( 'Icon Class:', 'electro' ) ?></label>
									<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('icon_class-' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name('icon_class-' . $i) ); ?>" value="<?php echo esc_attr( $icon_class ); ?>" />
								</p>
								<p>
									<label for="<?php echo esc_attr( $this->get_field_id('feature-' . $i) ); ?>"><?php esc_html_e( 'Feature:', 'electro' ) ?></label>
									<textarea rows="1" cols="28" id="<?php echo esc_attr( $this->get_field_id('feature-' . $i) ); ?>" name="<?php echo esc_attr( $this->get_field_name('feature-' . $i) ); ?>"><?php echo wp_kses_post( $feature ); ?></textarea>
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
						$.each($(".widget-features-block-input-containers").children(), function(){
							if($(this).find('input').val() != ''){
								$(this).show();
							}
						});
						$('.widget-features-block-container').off('click', '.add-new-block');
						$(".widget-features-block-container").on("click", ".add-new-block", function(e) {
							var rows = 0;
							$.each($(".widget-features-block-input-containers").children(), function(){
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
								$(".widget-features-block-container .message").show();
							}
						});
						$(".widget-features-block-container").on("click", ".delete-block", function(e) {
							var count = 1;
							var current = $(this).closest('.features-input-block').attr('id');
							$.each($("#"+current+" .entry-desc").children(), function(){
								$(this).val('');
							});
							$.each($("#"+current+" .entry-desc p").children(), function(){
								$(this).val('');
							});
							$('#'+current+" .entry-title").removeClass('active');
							$('#'+current+" .entry-desc").hide();
							$('#'+current).remove();
							$.each($(".widget-features-block-input-containers").children(), function(){
								if($(this).find('input').val() != ''){
									$(this).find('input').first().val(count);
								}
								count++;
							});
						});
						$('.features-input-block').off('click', '.entry-title');
						$(".features-input-block").on("click", ".entry-title", function(e) {
							if($(this).hasClass("active")){
								$(this).removeClass("active");
								$(this).next(".entry-desc").slideUp();
							} else {
								$(".widget-features-block-input-containers .entry-title").removeClass("active");
								$(".widget-features-block-input-containers .entry-desc").slideUp();
								$(this).addClass("active");
								$(this).next(".entry-desc").slideDown();
							}
						});
					});
				})(jQuery);
			</script>
			<style type="text/css">
				.widget-features-block-container .add-new-block{
					background: #ccc none repeat scroll 0 0;font-weight: bold;margin: 20px 0px 9px;padding: 6px;text-align: center;display:block!important;cursor:pointer;
				}
				.widget-features-block-container .delete-block{
					text-decoration: underline;color:red;
				}
				.widget-features-block-container{
					padding:10px 0 0;
				}
				.widget-features-block-container .features-input-block{ padding:0; border:1px solid #e5e5e5; margin:10px 0 0; clear:both;}
				.widget-features-block-container .features-input-block:first-child{
					margin:0;
				}
				.widget-features-block-container .entry-title{
					display:block; font-size:14px; line-height:18px; font-weight:600; background:#f1f1f1; padding:7px 5px; position:relative; margin:0;
				}
				.widget-features-block-container .entry-title:after{
					content: '\f140'; font: 400 20px/1 dashicons; position:absolute; right:10px; top:6px; color:#a0a5aa;
				}
				.widget-features-block-container .entry-title.active:after{
					content: '\f142';
				}
				.widget-features-block-container .entry-desc{
					display:none; padding:0 10px 10px; border-top:1px solid #e5e5e5;
				}
				.widget-features-block-container .message{
					padding:6px;display:none;color:red;font-weight:bold;
				}
			</style>
			<?php
		}
	}
endif;