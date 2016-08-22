<?php
/**
 * Creates a Product Brand Carousel Widget which can be placed in sidebar
 *
 * @class       Electro_Product_Brand_Carousel_Widget
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
	 * Electro Product Brand Carousel widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Product_Brand_Carousel_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add products brand carousel widgets to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_products_brand_carousel_widget', esc_html__( 'Electro Product Brand Carousel', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {

			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$limit = isset( $instance['limit'] ) ? $instance['limit'] : 12;
			$has_no_products = isset( $instance['has_no_products'] ) ? $instance['has_no_products'] : 0;
			$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'title';
			$order = isset( $instance['order'] ) ? $instance['order'] : 'ASC';
			$include = isset( $instance['include'] ) ? $instance['include'] : '';
			$is_touchdrag = isset( $instance['is_touchdrag'] ) ? $instance['is_touchdrag'] : 0;

			$section_args = array(
				'section_title'		=> $title
			);

			$taxonomy_args = array(
				'orderby'		=> $orderby,
				'order'			=> $order,
				'number'		=> $limit,
				'hide_empty'	=> $has_no_products
			);

			if( ! empty( $include ) ) {
				$include = explode( ",", $include );
				$taxonomy_args['include'] = $include;
			}

			$carousel_args 	= array(
				'touchDrag'			=> $is_touchdrag,
			);

			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_brands_carousel' ) ) {
				electro_brands_carousel( $section_args, $taxonomy_args, $carousel_args );
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
			if ( ! empty( $new_instance['is_touchdrag'] ) ) {
				$instance['is_touchdrag'] = strip_tags( stripslashes($new_instance['is_touchdrag']) );
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
			$is_touchdrag = isset( $instance['is_touchdrag'] ) ? $instance['is_touchdrag'] : 0;

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
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'is_touchdrag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_touchdrag' ) ); ?>" type="checkbox" value="1" <?php checked( $is_touchdrag, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'is_touchdrag' ) ); ?>"><?php esc_html_e( 'Enable Touch Drag:', 'electro' ) ?></label>
			</p>
			<?php
		}
	}
endif;