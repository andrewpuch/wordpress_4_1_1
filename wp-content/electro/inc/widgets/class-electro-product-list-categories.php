<?php
/**
 * Creates a Products List Categories Widget which can be placed in sidebar
 *
 * @class       Electro_Product_List_Catgories_Widget
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
	 * Electro Product List Categories widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Product_List_Catgories_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add products list categories to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_product_list_catgories_widget', esc_html__( 'Electro Product List Categories', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {

			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$limit = isset( $instance['limit'] ) ? $instance['limit'] : '';
			$has_no_products = isset( $instance['has_no_products'] ) ? $instance['has_no_products'] : 0;
			$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
			$order = isset( $instance['order'] ) ? $instance['order'] : '';
			$include = isset( $instance['include'] ) ? $instance['include'] : '';

			$cat_args = array(
				'number'			=> $limit,
				'hide_empty'		=> $has_no_products,
				'orderby' 			=> $orderby,
				'order' 			=> $order,
			);

			if( ! empty( $include ) ) {
				$include = explode( ",", $include );
				$cat_args['include'] = $include;
			}

			$atts = array(
				'section_title'			=> $title,
				'category_args'			=> $cat_args,
			);

			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_home_list_categories' ) ) {
				electro_home_list_categories( $atts );
			}
			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['title'] ) ) {
				$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
			}
			if ( ! empty( $new_instance['limit'] ) ) {
				$instance['limit'] = strip_tags( stripslashes($new_instance['limit']) );
			}
			if ( ! empty( $new_instance['has_no_products'] ) ) {
				$instance['has_no_products'] = strip_tags( stripslashes($new_instance['has_no_products']) );
			}
			if ( ! empty( $new_instance['orderby'] ) ) {
				$instance['orderby'] = strip_tags( stripslashes($new_instance['orderby']) );
			}
			if ( ! empty( $new_instance['order'] ) ) {
				$instance['order'] = strip_tags( stripslashes($new_instance['order']) );
			}
			if ( ! empty( $new_instance['include'] ) ) {
				$instance['include'] = strip_tags( stripslashes($new_instance['include']) );
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$limit = isset( $instance['limit'] ) ? $instance['limit'] : '';
			$has_no_products = isset( $instance['has_no_products'] ) ? $instance['has_no_products'] : 0;
			$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
			$order = isset( $instance['order'] ) ? $instance['order'] : '';
			$include = isset( $instance['include'] ) ? $instance['include'] : '';

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
				<label for="<?php echo esc_attr( $this->get_field_id('limit') ); ?>"><?php esc_html_e( 'Limit:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('limit') ); ?>" name="<?php echo esc_attr( $this->get_field_name('limit') ); ?>" value="<?php echo esc_attr( $limit ); ?>" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'has_no_products' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'has_no_products' ) ); ?>" type="checkbox" value="1" <?php checked( $has_no_products, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'has_no_products' ) ); ?>"><?php esc_html_e( 'Has no products:', 'electro' ) ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Orderby:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
					<option value="name" <?php selected( 'name', $orderby ); ?>><?php esc_html_e( 'Name', 'electro' ) ?></option>
					<option value="slug" <?php selected( 'slug', $orderby ); ?>><?php esc_html_e( 'Slug', 'electro' ) ?></option>
					<option value="term_group" <?php selected( 'term_group', $orderby ); ?>><?php esc_html_e( 'Term Group', 'electro' ) ?></option>
					<option value="term_id" <?php selected( 'term_id', $orderby ); ?>><?php esc_html_e( 'Term ID', 'electro' ) ?></option>
					<option value="id" <?php selected( 'id', $orderby ); ?>><?php esc_html_e( 'ID', 'electro' ) ?></option>
					<option value="description" <?php selected( 'description', $orderby ); ?>><?php esc_html_e( 'Description', 'electro' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Order:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
					<option value="asc" <?php selected( 'asc', $order ); ?>><?php esc_html_e( 'ASC', 'electro' ) ?></option>
					<option value="desc" <?php selected( 'desc', $order ); ?>><?php esc_html_e( 'DESC', 'electro' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('include') ); ?>"><?php esc_html_e( 'Include:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('include') ); ?>" name="<?php echo esc_attr( $this->get_field_name('include') ); ?>" value="<?php echo esc_attr( $include ); ?>" />
			</p>
			<?php
		}
	}
endif;