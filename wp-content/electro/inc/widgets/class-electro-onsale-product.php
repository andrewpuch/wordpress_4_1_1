<?php
/**
 * Creates a Onsale Product Widget which can be placed in sidebar
 *
 * @class       Electro_Onsale_Product_Widget
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
	 * Electro Onsale Product Widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Onsale_Product_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add onsale product widget to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_onsale_product_widget', esc_html__( 'Electro Onsale Product', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {

			$title = isset( $instance['title'] ) ? $instance['title'] : wp_kses_post( __( '<span class="highlight">Special</span> Offer', 'electro' ) );
			$show_savings = isset( $instance['show_savings'] ) ? $instance['show_savings'] : 0;
			$savings_in = isset( $instance['savings_in'] ) ? $instance['savings_in'] : 'amount';
			$savings_text = isset( $instance['savings_text'] ) ? $instance['savings_text'] : esc_html__( 'Save', 'electro' );
			$product_id = isset( $instance['product_id'] ) ? $instance['product_id'] : '';

			$atts = apply_filters( 'electro_onsale_product_widget_args', array(
					'section_title'	=> $title,
					'show_savings'	=> $show_savings,
					'savings_in'	=> $savings_in,
					'savings_text'	=> $savings_text,
				)
			);

			if( ! empty( $product_id ) ) {
				$product_id = explode( ",", $product_id );
				$atts['post__in'] = $product_id;
			}
			
			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_onsale_product' ) ) {
				electro_onsale_product( $atts );
			}
			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['title'] ) ) {
				$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
			}
			if ( ! empty( $new_instance['show_savings'] ) ) {
				$instance['show_savings'] = strip_tags( stripslashes($new_instance['show_savings']) );
			}
			if ( ! empty( $new_instance['savings_in'] ) ) {
				$instance['savings_in'] = strip_tags( stripslashes($new_instance['savings_in']) );
			}
			if ( ! empty( $new_instance['savings_text'] ) ) {
				$instance['savings_text'] = strip_tags( stripslashes($new_instance['savings_text']) );
			}
			if ( ! empty( $new_instance['product_id'] ) ) {
				$instance['product_id'] = strip_tags( stripslashes($new_instance['product_id']) );
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$show_savings = isset( $instance['show_savings'] ) ? $instance['show_savings'] : 0;
			$savings_in = isset( $instance['savings_in'] ) ? $instance['savings_in'] : '';
			$savings_text = isset( $instance['savings_text'] ) ? $instance['savings_text'] : '';
			$product_id = isset( $instance['product_id'] ) ? $instance['product_id'] : '';

			// If no sidebars exists.
			if ( !$wp_registered_sidebars ) {
				echo '<p>'. esc_html__('No sidebars are available.', 'electro' ) .'</p>';
				return;
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'show_savings' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_savings' ) ); ?>" type="checkbox" value="1" <?php checked( $show_savings, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_savings' ) ); ?>"><?php esc_html_e( 'Show Savings:', 'electro' ) ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'savings_in' ) ); ?>"><?php esc_html_e( 'Savings in:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'savings_in' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'savings_in' ) ); ?>">
					<option value="amount" <?php selected( 'amount', $savings_in ); ?>><?php esc_html_e( 'Amount', 'electro' ) ?></option>
					<option value="percentage" <?php selected( 'percentage', $savings_in ); ?>><?php esc_html_e( 'Percentage', 'electro' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('savings_text') ); ?>"><?php esc_html_e( 'Savings Text:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('savings_text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('savings_text') ); ?>" value="<?php echo esc_attr( $savings_text ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('product_id') ); ?>"><?php esc_html_e( 'Product ID:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('product_id') ); ?>" name="<?php echo esc_attr( $this->get_field_name('product_id') ); ?>" value="<?php echo esc_attr( $product_id ); ?>" />
			</p>
			<?php
		}
	}
endif;