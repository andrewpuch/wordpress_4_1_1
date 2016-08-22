<?php
/**
 * Creates a Products 2-1-2 Widget which can be placed in sidebar
 *
 * @class       Electro_Products_2_1_2_Widget
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
	 * Electro Products 2-1-2 widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Products_2_1_2_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add products 2-1-2 block widgets to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_products_2_1_2_widget', esc_html__( 'Electro Product 2-1-2 Block', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {

			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$show = isset( $instance['show'] ) ? $instance['show'] : '';
			$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
			$order = isset( $instance['order'] ) ? $instance['order'] : '';
			$hide_free = isset( $instance['hide_free'] ) ? $instance['hide_free'] : false;
			$show_hidden = isset( $instance['show_hidden'] ) ? $instance['show_hidden'] : false;
			$product_id = isset( $instance['product_id'] ) ? $instance['product_id'] : '';
			$cat_limit = isset( $instance['cat_limit'] ) ? $instance['cat_limit'] : '';
			$cat_has_no_products = isset( $instance['cat_has_no_products'] ) ? $instance['cat_has_no_products'] : 0;
			$cat_orderby = isset( $instance['cat_orderby'] ) ? $instance['cat_orderby'] : '';
			$cat_order = isset( $instance['cat_order'] ) ? $instance['cat_order'] : '';
			$cat_include = isset( $instance['cat_include'] ) ? $instance['cat_include'] : '';

			$atts = array(
				'section_title' 		=> $title,
				'category_args'		=> array(
					'number'		=> $cat_limit,
					'hide_empty'	=> $cat_has_no_products,
					'orderby' 		=> $cat_orderby,
					'order' 		=> $cat_order,
				)
			);

			if( ! empty( $cat_include ) ) {
				$cat_include = explode( ",", $cat_include );
				$atts['category_args']['include'] = $cat_include;
			}

			$product_query_args	= array(
				'limit'			=> 5,
				'show'			=> $show,
				'orderby'		=> $orderby,
				'order'			=> $order,
				'hide_free'		=> $hide_free,
				'show_hidden'	=> $show_hidden
			);

			if( ! empty( $product_id ) ) {
				$product_id = explode( ",", $product_id );
				$product_query_args['post__in'] = $product_id;
			}

			$atts['products'] = Electro_WC_Helper::get_products( $product_query_args );

			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_products_2_1_2_block' ) ) {
				electro_products_2_1_2_block( $atts );
			}
			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['title'] ) ) {
				$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
			}
			if ( ! empty( $new_instance['show'] ) ) {
				$instance['show'] = strip_tags( stripslashes($new_instance['show']) );
			}
			if ( ! empty( $new_instance['orderby'] ) ) {
				$instance['orderby'] = strip_tags( stripslashes($new_instance['orderby']) );
			}
			if ( ! empty( $new_instance['order'] ) ) {
				$instance['order'] = strip_tags( stripslashes($new_instance['order']) );
			}
			if ( ! empty( $new_instance['hide_free'] ) ) {
				$instance['hide_free'] = strip_tags( stripslashes($new_instance['hide_free']) );
			}
			if ( ! empty( $new_instance['show_hidden'] ) ) {
				$instance['show_hidden'] = strip_tags( stripslashes($new_instance['show_hidden']) );
			}
			if ( ! empty( $new_instance['product_id'] ) ) {
				$instance['product_id'] = strip_tags( stripslashes($new_instance['product_id']) );
			}
			if ( ! empty( $new_instance['cat_limit'] ) ) {
				$instance['cat_limit'] = strip_tags( stripslashes($new_instance['cat_limit']) );
			}
			if ( ! empty( $new_instance['cat_has_no_products'] ) ) {
				$instance['cat_has_no_products'] = strip_tags( stripslashes($new_instance['cat_has_no_products']) );
			}
			if ( ! empty( $new_instance['cat_orderby'] ) ) {
				$instance['cat_orderby'] = strip_tags( stripslashes($new_instance['cat_orderby']) );
			}
			if ( ! empty( $new_instance['cat_order'] ) ) {
				$instance['cat_order'] = strip_tags( stripslashes($new_instance['cat_order']) );
			}
			if ( ! empty( $new_instance['cat_include'] ) ) {
				$instance['cat_include'] = strip_tags( stripslashes($new_instance['cat_include']) );
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$show = isset( $instance['show'] ) ? $instance['show'] : '';
			$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
			$order = isset( $instance['order'] ) ? $instance['order'] : '';
			$hide_free = isset( $instance['hide_free'] ) ? $instance['hide_free'] : false;
			$show_hidden = isset( $instance['show_hidden'] ) ? $instance['show_hidden'] : false;
			$product_id = isset( $instance['product_id'] ) ? $instance['product_id'] : '';
			$cat_limit = isset( $instance['cat_limit'] ) ? $instance['cat_limit'] : '';
			$cat_has_no_products = isset( $instance['cat_has_no_products'] ) ? $instance['cat_has_no_products'] : 0;
			$cat_orderby = isset( $instance['cat_orderby'] ) ? $instance['cat_orderby'] : '';
			$cat_order = isset( $instance['cat_order'] ) ? $instance['cat_order'] : '';
			$cat_include = isset( $instance['cat_include'] ) ? $instance['cat_include'] : '';

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
			<h2><?php esc_html_e( 'Product Options', 'electro' ) ?></h2>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'show' ) ); ?>"><?php esc_html_e( 'Show:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'show' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show' ) ); ?>">
					<option value="" <?php selected( '', $show ); ?>><?php esc_html_e( 'All Products', 'electro' ) ?></option>
					<option value="featured" <?php selected( 'featured', $show ); ?>><?php esc_html_e( 'Featured Products', 'electro' ) ?></option>
					<option value="onsale" <?php selected( 'onsale', $show ); ?>><?php esc_html_e( 'On-sale Products', 'electro' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Orderby:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
					<option value="date" <?php selected( 'date', $orderby ); ?>><?php esc_html_e( 'Date', 'electro' ) ?></option>
					<option value="price" <?php selected( 'price', $orderby ); ?>><?php esc_html_e( 'Price', 'electro' ) ?></option>
					<option value="rand" <?php selected( 'rand', $orderby ); ?>><?php esc_html_e( 'Random', 'electro' ) ?></option>
					<option value="sales" <?php selected( 'sales', $orderby ); ?>><?php esc_html_e( 'Sales', 'electro' ) ?></option>
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
				<input id="<?php echo esc_attr( $this->get_field_id( 'hide_free' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_free' ) ); ?>" type="checkbox" value="1" <?php checked( $hide_free, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'hide_free' ) ); ?>"><?php esc_html_e( 'Hide free products:', 'electro' ) ?></label>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'show_hidden' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_hidden' ) ); ?>" type="checkbox" value="1" <?php checked( $show_hidden, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'show_hidden' ) ); ?>"><?php esc_html_e( 'Show hidden products:', 'electro' ) ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('product_id') ); ?>"><?php esc_html_e( 'Product ID:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('product_id') ); ?>" name="<?php echo esc_attr( $this->get_field_name('product_id') ); ?>" value="<?php echo esc_attr( $product_id ); ?>" />
			</p>
			<h2><?php esc_html_e( 'Category Options', 'electro' ) ?></h2>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('cat_limit') ); ?>"><?php esc_html_e( 'Limit:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('cat_limit') ); ?>" name="<?php echo esc_attr( $this->get_field_name('cat_limit') ); ?>" value="<?php echo esc_attr( $cat_limit ); ?>" />
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'cat_has_no_products' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat_has_no_products' ) ); ?>" type="checkbox" value="1" <?php checked( $cat_has_no_products, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'cat_has_no_products' ) ); ?>"><?php esc_html_e( 'Has no products:', 'electro' ) ?></label>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cat_orderby' ) ); ?>"><?php esc_html_e( 'Orderby:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cat_orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat_orderby' ) ); ?>">
					<option value="name" <?php selected( 'name', $cat_orderby ); ?>><?php esc_html_e( 'Name', 'electro' ) ?></option>
					<option value="slug" <?php selected( 'slug', $cat_orderby ); ?>><?php esc_html_e( 'Slug', 'electro' ) ?></option>
					<option value="term_group" <?php selected( 'term_group', $cat_orderby ); ?>><?php esc_html_e( 'Term Group', 'electro' ) ?></option>
					<option value="term_id" <?php selected( 'term_id', $cat_orderby ); ?>><?php esc_html_e( 'Term ID', 'electro' ) ?></option>
					<option value="id" <?php selected( 'id', $cat_orderby ); ?>><?php esc_html_e( 'ID', 'electro' ) ?></option>
					<option value="description" <?php selected( 'description', $cat_orderby ); ?>><?php esc_html_e( 'Description', 'electro' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cat_order' ) ); ?>"><?php esc_html_e( 'Order:', 'electro' ) ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cat_order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat_order' ) ); ?>">
					<option value="asc" <?php selected( 'asc', $cat_order ); ?>><?php esc_html_e( 'ASC', 'electro' ) ?></option>
					<option value="desc" <?php selected( 'desc', $cat_order ); ?>><?php esc_html_e( 'DESC', 'electro' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id('cat_include') ); ?>"><?php esc_html_e( 'Include:', 'electro' ) ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('cat_include') ); ?>" name="<?php echo esc_attr( $this->get_field_name('cat_include') ); ?>" value="<?php echo esc_attr( $cat_include ); ?>" />
			</p>
			<?php
		}
	}
endif;