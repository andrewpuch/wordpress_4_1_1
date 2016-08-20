<?php
/**
 * Creates a Banner Ad Widget which can be placed in sidebar
 *
 * @class       Electro_Banner_Ad_Widget
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
	 * Electro Banner Ad Widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Banner_Ad_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add banner ad widget to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_banner_ad_widget', esc_html__( 'Electro Banner Ad', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {

			$image = isset( $instance['image'] ) ? $instance['image'] : '';
			$link = isset( $instance['link'] ) ? $instance['link'] : '';
			$el_class = isset( $instance['el_class'] ) ? $instance['el_class'] : '';

			$atts = array(
				'image'		=> $image,
				'link'		=> $link,
				'el_class'	=> $el_class,
			);
			
			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_fullbanner_ad' ) ) {
				electro_fullbanner_ad( $atts );
			}
			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['image'] ) ) {
				$instance['image'] = strip_tags( stripslashes($new_instance['image']) );
			}
			if ( ! empty( $new_instance['link'] ) ) {
				$instance['link'] = strip_tags( stripslashes($new_instance['link']) );
			}
			if ( ! empty( $new_instance['el_class'] ) ) {
				$instance['el_class'] = strip_tags( stripslashes($new_instance['el_class']) );
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			$image = isset( $instance['image'] ) ? $instance['image'] : '';
			$link = isset( $instance['link'] ) ? $instance['link'] : '';
			$el_class = isset( $instance['el_class'] ) ? $instance['el_class'] : '';

			// If no sidebars exists.
			if ( !$wp_registered_sidebars ) {
				echo '<p>'. esc_html__('No sidebars are available.', 'electro' ) .'</p>';
				return;
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('image') ); ?>"><?php esc_html_e( 'Image:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('image') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image') ); ?>" value="<?php echo esc_attr( $image ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('link') ); ?>"><?php esc_html_e( 'Link:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('link') ); ?>" name="<?php echo esc_attr( $this->get_field_name('link') ); ?>" value="<?php echo esc_attr( $link ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('el_class') ); ?>"><?php esc_html_e( 'Extra Class:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('el_class') ); ?>" name="<?php echo esc_attr( $this->get_field_name('el_class') ); ?>" value="<?php echo esc_attr( $el_class ); ?>" />
			</p>
			<?php
		}
	}
endif;