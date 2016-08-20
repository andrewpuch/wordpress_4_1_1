<?php
/**
 * Creates a Products Tabs Widget which can be placed in sidebar
 *
 * @class       Electro_Products_Tabs_Widget
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
	 * Electro Products Tabs widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Products_Tabs_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add products tabs widgets to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_products_tabs_widget', esc_html__( 'Electro Products Tabs', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {

			$tab_title_1 = isset( $instance['tab_title_1'] ) ? $instance['tab_title_1'] : '';
			$tab_content_1 = isset( $instance['tab_content_1'] ) ? $instance['tab_content_1'] : '';
			$tab_title_2 = isset( $instance['tab_title_2'] ) ? $instance['tab_title_2'] : '';
			$tab_content_2 = isset( $instance['tab_content_2'] ) ? $instance['tab_content_2'] : '';
			$tab_title_3 = isset( $instance['tab_title_3'] ) ? $instance['tab_title_3'] : '';
			$tab_content_3 = isset( $instance['tab_content_3'] ) ? $instance['tab_content_3'] : '';
			$product_items = isset( $instance['product_items'] ) ? $instance['product_items'] : '';
			$product_columns = isset( $instance['product_columns'] ) ? $instance['product_columns'] : '';

			$atts = array(
				'tabs' 		=> array(
					array(
						'title'			=> $tab_title_1,
						'shortcode_tag'	=> $tab_content_1
					),
					array(
						'title'			=> $tab_title_2,
						'shortcode_tag'	=> $tab_content_2
					),
					array(
						'title'			=> $tab_title_3,
						'shortcode_tag'	=> $tab_content_3
					)
				),
				'limit'		=> $product_items,
				'columns'	=> $product_columns, 
			);

			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_products_tabs' ) ) {
				electro_products_tabs( $atts );
			}
			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['tab_title_1'] ) ) {
				$instance['tab_title_1'] = strip_tags( stripslashes($new_instance['tab_title_1']) );
			}
			if ( ! empty( $new_instance['tab_content_1'] ) ) {
				$instance['tab_content_1'] = strip_tags( stripslashes($new_instance['tab_content_1']) );
			}
			if ( ! empty( $new_instance['tab_title_2'] ) ) {
				$instance['tab_title_2'] = strip_tags( stripslashes($new_instance['tab_title_2']) );
			}
			if ( ! empty( $new_instance['tab_content_2'] ) ) {
				$instance['tab_content_2'] = strip_tags( stripslashes($new_instance['tab_content_2']) );
			}
			if ( ! empty( $new_instance['tab_title_3'] ) ) {
				$instance['tab_title_3'] = strip_tags( stripslashes($new_instance['tab_title_3']) );
			}
			if ( ! empty( $new_instance['tab_content_3'] ) ) {
				$instance['tab_content_3'] = strip_tags( stripslashes($new_instance['tab_content_3']) );
			}
			if ( ! empty( $new_instance['product_items'] ) ) {
				$instance['product_items'] = strip_tags( stripslashes($new_instance['product_items']) );
			}
			if ( ! empty( $new_instance['product_columns'] ) ) {
				$instance['product_columns'] = strip_tags( stripslashes($new_instance['product_columns']) );
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			$tab_contents_list = array(
				'featured_products'		=> esc_html__( 'Featured Products', 'electro' ),
				'sale_products'			=> esc_html__( 'On Sale Products', 'electro' ),
				'top_rated_products'	=> esc_html__( 'Top Rated Products', 'electro' ),
				'recent_products'		=> esc_html__( 'Recent Products', 'electro' ),
				'best_selling_products'	=> esc_html__( 'Best Selling Products', 'electro' ),
			);

			$tab_title_1 = isset( $instance['tab_title_1'] ) ? $instance['tab_title_1'] : '';
			$tab_content_1 = isset( $instance['tab_content_1'] ) ? $instance['tab_content_1'] : '';
			$tab_title_2 = isset( $instance['tab_title_2'] ) ? $instance['tab_title_2'] : '';
			$tab_content_2 = isset( $instance['tab_content_2'] ) ? $instance['tab_content_2'] : '';
			$tab_title_3 = isset( $instance['tab_title_3'] ) ? $instance['tab_title_3'] : '';
			$tab_content_3 = isset( $instance['tab_content_3'] ) ? $instance['tab_content_3'] : '';
			$product_items = isset( $instance['product_items'] ) ? $instance['product_items'] : '';
			$product_columns = isset( $instance['product_columns'] ) ? $instance['product_columns'] : '';

			// If no sidebars exists.
			if ( !$wp_registered_sidebars ) {
				echo '<p>'. esc_html__('No sidebars are available.', 'electro' ) .'</p>';
				return;
			}
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('tab_title_1') ); ?>"><?php esc_html_e( 'Tab #1 title:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('tab_title_1') ); ?>" name="<?php echo esc_attr( $this->get_field_name('tab_title_1') ); ?>" value="<?php echo esc_attr( $tab_title_1 ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tab_content_1' ) ); ?>"><?php esc_html_e( 'Tab #1 Content, Show:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tab_content_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tab_content_1' ) ); ?>">
					<?php foreach ( $tab_contents_list as $option_key => $option_value ) : ?>
						<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $tab_content_1 ); ?>><?php echo esc_html( $option_value ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('tab_title_2') ); ?>"><?php esc_html_e( 'Tab #2 title:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('tab_title_2') ); ?>" name="<?php echo esc_attr( $this->get_field_name('tab_title_2') ); ?>" value="<?php echo esc_attr( $tab_title_2 ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tab_content_2' ) ); ?>"><?php esc_html_e( 'Tab #1 Content, Show:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tab_content_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tab_content_2' ) ); ?>">
					<?php foreach ( $tab_contents_list as $option_key => $option_value ) : ?>
						<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $tab_content_2 ); ?>><?php echo esc_html( $option_value ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('tab_title_3') ); ?>"><?php esc_html_e( 'Tab #3 title:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('tab_title_3') ); ?>" name="<?php echo esc_attr( $this->get_field_name('tab_title_3') ); ?>" value="<?php echo esc_attr( $tab_title_3 ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tab_content_3' ) ); ?>"><?php esc_html_e( 'Tab #1 Content, Show:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tab_content_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tab_content_3' ) ); ?>">
					<?php foreach ( $tab_contents_list as $option_key => $option_value ) : ?>
						<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $tab_content_3 ); ?>><?php echo esc_html( $option_value ); ?></option>
					<?php endforeach; ?>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('product_items') ); ?>"><?php esc_html_e( 'Enter Product Items:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('product_items') ); ?>" name="<?php echo esc_attr( $this->get_field_name('product_items') ); ?>" value="<?php echo esc_attr( $product_items ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('product_columns') ); ?>"><?php esc_html_e( 'Enter Product Columns:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('product_columns') ); ?>" name="<?php echo esc_attr( $this->get_field_name('product_columns') ); ?>" value="<?php echo esc_attr( $product_columns ); ?>" />
			</p>
			<?php
		}
	}
endif;