<?php
/**
 * Creates a Onsale Product Carousel Widget which can be placed in sidebar
 *
 * @class       Electro_Onsale_Product_Carousel_Widget
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
	 * Electro Onsale Product Carousel Widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Onsale_Product_Carousel_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add onsale product carousel widget to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_onsale_products_carousel_widget', esc_html__( 'Electro Onsale Product Carousel', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {

			$title = isset( $instance['title'] ) ? $instance['title'] : esc_html__( 'Deals of the week', 'electro' );
			$show_savings = isset( $instance['show_savings'] ) ? $instance['show_savings'] : 0;
			$savings_in = isset( $instance['savings_in'] ) ? $instance['savings_in'] : 'amount';
			$savings_text = isset( $instance['savings_text'] ) ? $instance['savings_text'] : esc_html__( 'Save', 'electro' );
			$limit = isset( $instance['limit'] ) ? $instance['limit'] : 12;
			$product_id = isset( $instance['product_id'] ) ? $instance['product_id'] : '';
			$show_custom_nav = !empty( $instance['show_custom_nav'] ) ? $instance['show_custom_nav'] : false;
			$is_dots = !empty( $instance['is_dots'] ) ? $instance['is_dots'] : false;
			$is_touchdrag = !empty( $instance['is_touchdrag'] ) ? $instance['is_touchdrag'] : false;
			$nav_next = !empty( $instance['nav_next'] ) ? $instance['nav_next'] : '';
			$nav_prev = !empty( $instance['nav_prev'] ) ? $instance['nav_prev'] : '';
			$margin = !empty( $instance['margin'] ) ? $instance['margin'] : 0;

			$section_args = apply_filters( 'electro_onsale_products_carousel_widget_section_args', array(
					'section_title'		=> $title,
					'show_savings'		=> $show_savings,
					'savings_in'		=> $savings_in,
					'savings_text'		=> $savings_text,
					'limit'				=> $limit,
					'show_custom_nav'	=> $show_custom_nav
				)
			);

			if( ! empty( $product_id ) ) {
				$product_id = explode( ",", $product_id );
				$section_args['post__in'] = $product_id;
			}

			$carousel_args = apply_filters( 'electro_onsale_products_carousel_widget_carousel_args', array(
				'dots'				=> $is_dots,
				'touchDrag'			=> $is_touchdrag,
				'navText'			=> array( $nav_next, $nav_prev ),
				'margin'			=> $margin,
			) );
			
			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_onsale_product_carousel' ) ) {
				electro_onsale_product_carousel( $section_args, $carousel_args );
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
			if ( ! empty( $new_instance['limit'] ) ) {
				$instance['limit'] = strip_tags( stripslashes($new_instance['limit']) );
			}
			if ( ! empty( $new_instance['product_id'] ) ) {
				$instance['product_id'] = strip_tags( stripslashes($new_instance['product_id']) );
			}
			if ( ! empty( $new_instance['show_custom_nav'] ) ) {
				$instance['show_custom_nav'] = strip_tags( stripslashes($new_instance['show_custom_nav']) );
			}
			if ( ! empty( $new_instance['is_dots'] ) ) {
				$instance['is_dots'] = strip_tags( stripslashes($new_instance['is_dots']) );
			}
			if ( ! empty( $new_instance['is_touchdrag'] ) ) {
				$instance['is_touchdrag'] = strip_tags( stripslashes($new_instance['is_touchdrag']) );
			}
			if ( ! empty( $new_instance['nav_next'] ) ) {
				$instance['nav_next'] = strip_tags( stripslashes($new_instance['nav_next']) );
			}
			if ( ! empty( $new_instance['nav_prev'] ) ) {
				$instance['nav_prev'] = strip_tags( stripslashes($new_instance['nav_prev']) );
			}
			if ( ! empty( $new_instance['margin'] ) ) {
				$instance['margin'] = strip_tags( stripslashes($new_instance['margin']) );
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$show_savings = isset( $instance['show_savings'] ) ? $instance['show_savings'] : 0;
			$savings_in = isset( $instance['savings_in'] ) ? $instance['savings_in'] : '';
			$savings_text = isset( $instance['savings_text'] ) ? $instance['savings_text'] : '';
			$limit = isset( $instance['limit'] ) ? $instance['limit'] : '';
			$product_id = isset( $instance['product_id'] ) ? $instance['product_id'] : '';
			$show_custom_nav = isset( $instance['show_custom_nav'] ) ? $instance['show_custom_nav'] : false;
			$is_dots = isset( $instance['is_dots'] ) ? $instance['is_dots'] : false;
			$is_touchdrag = isset( $instance['is_touchdrag'] ) ? $instance['is_touchdrag'] : false;
			$nav_next = isset( $instance['nav_next'] ) ? $instance['nav_next'] : '';
			$nav_prev = isset( $instance['nav_prev'] ) ? $instance['nav_prev'] : '';
			$margin = isset( $instance['margin'] ) ? $instance['margin'] : '';

			// If no sidebars exists.
			if ( !$wp_registered_sidebars ) {
				echo '<p>'. esc_html__('No sidebars are available.', 'electro' ) .'</p>';
				return;
			}
			?>
			<h2><?php esc_html_e( 'Product Options', 'electro' ) ?></h2>
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
				<label for="<?php echo esc_attr( $this->get_field_id('limit') ); ?>"><?php esc_html_e( 'Limit:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('limit') ); ?>" name="<?php echo esc_attr( $this->get_field_name('limit') ); ?>" value="<?php echo esc_attr( $limit ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('product_id') ); ?>"><?php esc_html_e( 'Product ID:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('product_id') ); ?>" name="<?php echo esc_attr( $this->get_field_name('product_id') ); ?>" value="<?php echo esc_attr( $product_id ); ?>" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'show_custom_nav' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_custom_nav' ) ); ?>" type="checkbox" value="1" <?php checked( $show_custom_nav, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_custom_nav' ) ); ?>"><?php esc_html_e( 'Show Custom Navigation:', 'electro' ) ?></label>
			</p>
			<h2><?php esc_html_e( 'Carousel Options', 'electro' ) ?></h2>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'is_dots' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_dots' ) ); ?>" type="checkbox" value="1" <?php checked( $is_dots, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'is_dots' ) ); ?>"><?php esc_html_e( 'Show Dots:', 'electro' ) ?></label>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'is_touchdrag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_touchdrag' ) ); ?>" type="checkbox" value="1" <?php checked( $is_touchdrag, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'is_touchdrag' ) ); ?>"><?php esc_html_e( 'Enable Touch Drag:', 'electro' ) ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('nav_next') ); ?>"><?php esc_html_e( 'Nav Next Text:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('nav_next') ); ?>" name="<?php echo esc_attr( $this->get_field_name('nav_next') ); ?>" value="<?php echo esc_attr( $nav_next ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('nav_prev') ); ?>"><?php esc_html_e( 'Nav Prev Text:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('nav_prev') ); ?>" name="<?php echo esc_attr( $this->get_field_name('nav_prev') ); ?>" value="<?php echo esc_attr( $nav_prev ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('margin') ); ?>"><?php esc_html_e( 'Margin:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('margin') ); ?>" name="<?php echo esc_attr( $this->get_field_name('margin') ); ?>" value="<?php echo esc_attr( $margin ); ?>" />
			</p>
			<?php
		}
	}
endif;