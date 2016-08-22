<?php
/**
 * Creates a Products Carousel Widget which can be placed in sidebar
 *
 * @class       Electro_Products_Carousel_Widget
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
	 * Electro Products Carousel widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Products_Carousel_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add products carousel block widgets to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_products_carousel_widget', esc_html__( 'Electro Products Carousel', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {

			$type = isset( $instance['type'] ) ? $instance['type'] : 'type-1';

			$title = !empty( $instance['title'] ) ? $instance['title'] : '';
			$shortcode_tag = !empty( $instance['shortcode_tag'] ) ? $instance['shortcode_tag'] : 'recent_products';
			$limit = !empty( $instance['limit'] ) ? $instance['limit'] : 10;
			$columns = !empty( $instance['columns'] ) ? $instance['columns'] : 5;
			$product_id = isset( $instance['product_id'] ) ? $instance['product_id'] : '';
			$category = !empty( $instance['category'] ) ? $instance['category'] : '';
			$show_custom_nav = !empty( $instance['show_custom_nav'] ) ? $instance['show_custom_nav'] : false;
			
			$is_nav = !empty( $instance['is_nav'] ) ? $instance['is_nav'] : false;
			$is_dots = !empty( $instance['is_dots'] ) ? $instance['is_dots'] : false;
			$is_touchdrag = !empty( $instance['is_touchdrag'] ) ? $instance['is_touchdrag'] : false;
			$nav_next = !empty( $instance['nav_next'] ) ? $instance['nav_next'] : '';
			$nav_prev = !empty( $instance['nav_prev'] ) ? $instance['nav_prev'] : '';
			$margin = !empty( $instance['margin'] ) ? $instance['margin'] : 0;

			if( $type == 'type-2' ) {
				global $woocommerce_loop;

				$columns = $woocommerce_loop['columns'] = 1;
				$is_nav = false;
				$is_dots = false;

				$products = Electro_Products::$shortcode_tag( array(
					'per_page' => $limit,
					'columns' => $columns,
					'ids' => $product_id,
					'category' => $category
				) );

				ob_start();

				if ( $products->have_posts() ) {
					woocommerce_product_loop_start();
					while ( $products->have_posts() ) : $products->the_post();
						wc_get_template_part( 'templates/contents/content', 'product-carousel-alt' );
					endwhile;
					woocommerce_product_loop_end();
				}

				woocommerce_reset_loop();
				wp_reset_postdata();

				$products_html = ob_get_clean();
			} else {
				$products_html = electro_do_shortcode( $shortcode_tag, array(
					'per_page' => $limit,
					'columns' => $columns,
					'ids' => $product_id,
					'category' => $category
				) );
			}

			$atts = apply_filters( 'electro_products_carousel_widget_args', array(
				'section_args' 	=> array(
					'products_html'		=> $products_html,
					'section_title'		=> $title,
					'show_custom_nav'	=> $show_custom_nav
				),
				'carousel_args'	=> array(
					'items'				=> $columns,
					'nav'				=> $is_nav,
					'dots'				=> $is_dots,
					'touchDrag'			=> $is_touchdrag,
					'navText'			=> array( $nav_prev, $nav_next ),
					'margin'			=> $margin,
					'responsive'		=> array(
						'0'		=> array( 'items'	=> 1 ),
						'480'	=> array( 'items'	=> 3 ),
						'768'	=> array( 'items'	=> 2 ),
						'992'	=> array( 'items'	=> 3 ),
						'1200'	=> array( 'items'	=> $columns ),
					)
				)
			) );

			if( $columns == 1 ) {
				$atts['carousel_args']['responsive'] = false;
			}

			echo wp_kses_post( $args['before_widget'] );
			if( function_exists( 'electro_products_carousel' ) ) {
				electro_products_carousel( $atts['section_args'], $atts['carousel_args'] );
			}
			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['type'] ) ) {
				$instance['type'] = strip_tags( stripslashes($new_instance['type']) );
			}
			if ( ! empty( $new_instance['title'] ) ) {
				$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
			}
			if ( ! empty( $new_instance['shortcode_tag'] ) ) {
				$instance['shortcode_tag'] = strip_tags( stripslashes($new_instance['shortcode_tag']) );
			}
			if ( ! empty( $new_instance['limit'] ) ) {
				$instance['limit'] = strip_tags( stripslashes($new_instance['limit']) );
			}
			if ( ! empty( $new_instance['columns'] ) ) {
				$instance['columns'] = strip_tags( stripslashes($new_instance['columns']) );
			}
			if ( ! empty( $new_instance['product_id'] ) ) {
				$instance['product_id'] = strip_tags( stripslashes($new_instance['product_id']) );
			}
			if ( ! empty( $new_instance['category'] ) ) {
				$instance['category'] = strip_tags( stripslashes($new_instance['category']) );
			}
			if ( ! empty( $new_instance['show_custom_nav'] ) ) {
				$instance['show_custom_nav'] = strip_tags( stripslashes($new_instance['show_custom_nav']) );
			}
			if ( ! empty( $new_instance['is_nav'] ) ) {
				$instance['is_nav'] = strip_tags( stripslashes($new_instance['is_nav']) );
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

			$shortcode_tags_list = array(
				'featured_products'		=> esc_html__( 'Featured Products', 'electro' ),
				'sale_products'			=> esc_html__( 'On Sale Products', 'electro' ),
				'top_rated_products'	=> esc_html__( 'Top Rated Products', 'electro' ),
				'recent_products'		=> esc_html__( 'Recent Products', 'electro' ),
				'best_selling_products'	=> esc_html__( 'Best Selling Products', 'electro' ),
				'products'				=> esc_html__( 'Products by Ids', 'electro' ),
				'product_category'		=> esc_html__( 'Product Category', 'electro' ),
			);

			$type = isset( $instance['type'] ) ? $instance['type'] : 'type-1';

			$title = isset( $instance['title'] ) ? $instance['title'] : '';
			$shortcode_tag = isset( $instance['shortcode_tag'] ) ? $instance['shortcode_tag'] : '';
			$limit = isset( $instance['limit'] ) ? $instance['limit'] : '';
			$columns = isset( $instance['columns'] ) ? $instance['columns'] : '';
			$product_id = isset( $instance['product_id'] ) ? $instance['product_id'] : '';
			$category = isset( $instance['category'] ) ? $instance['category'] : '';
			$show_custom_nav = isset( $instance['show_custom_nav'] ) ? $instance['show_custom_nav'] : false;

			$is_nav = isset( $instance['is_nav'] ) ? $instance['is_nav'] : false;
			$is_dots = isset( $instance['is_dots'] ) ? $instance['is_dots'] : false;
			$is_touchdrag = isset( $instance['is_touchdrag'] ) ? $instance['is_touchdrag'] : false;
			$nav_next = isset( $instance['nav_next'] ) ? $instance['nav_next'] : esc_html__( 'Next', 'electro' );
			$nav_prev = isset( $instance['nav_prev'] ) ? $instance['nav_prev'] : esc_html__( 'Prev', 'electro' );
			$margin = isset( $instance['margin'] ) ? $instance['margin'] : '';

			// If no sidebars exists.
			if ( !$wp_registered_sidebars ) {
				echo '<p>'. esc_html__('No sidebars are available.', 'electro' ) .'</p>';
				return;
			}
			wp_enqueue_script( 'electro-admin-meta-boxes' );
			?>

			<div class="options_group">
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Type:', 'electro' ) ?></label>
				<select class="widefat show_hide_select" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
					<option value="type-1" <?php selected( 'type-1', $type ); ?>><?php esc_html_e( 'Type 1', 'electro' ) ?></option>
					<option value="type-2" <?php selected( 'type-2', $type ); ?>><?php esc_html_e( 'Type 2', 'electro' ) ?></option>
				</select>
			</p>

			<div class="product-options">
				<h2><?php esc_html_e( 'Product Options', 'electro' ) ?></h2>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php esc_html_e( 'Title:', 'electro' ) ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'shortcode_tag' ) ); ?>"><?php esc_html_e( 'Product Shortcode:', 'electro' ) ?></label>
					<select class="widefat show_hide_select" id="<?php echo esc_attr( $this->get_field_id( 'shortcode_tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'shortcode_tag' ) ); ?>">
						<?php foreach ( $shortcode_tags_list as $option_key => $option_value ) : ?>
							<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $shortcode_tag ); ?>><?php echo esc_html( $option_value ); ?></option>
						<?php endforeach; ?>
					</select>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id('limit') ); ?>"><?php esc_html_e( 'Limit:', 'electro' ) ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('limit') ); ?>" name="<?php echo esc_attr( $this->get_field_name('limit') ); ?>" value="<?php echo esc_attr( $limit ); ?>" />
				</p>
				<p class="show_if_type-1 hide">
					<label for="<?php echo esc_attr( $this->get_field_id('columns') ); ?>"><?php esc_html_e( 'Columns:', 'electro' ) ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('columns') ); ?>" name="<?php echo esc_attr( $this->get_field_name('columns') ); ?>" value="<?php echo esc_attr( $columns ); ?>" />
				</p>
				<p class="show_if_products hide">
					<label for="<?php echo esc_attr( $this->get_field_id('product_id') ); ?>"><?php esc_html_e( 'Product ID:', 'electro' ) ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('product_id') ); ?>" name="<?php echo esc_attr( $this->get_field_name('product_id') ); ?>" value="<?php echo esc_attr( $product_id ); ?>" />
				</p>
				<p class="show_if_product_category hide">
					<label for="<?php echo esc_attr( $this->get_field_id('category') ); ?>"><?php esc_html_e( 'Category Slug:', 'electro' ) ?></label>
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('category') ); ?>" name="<?php echo esc_attr( $this->get_field_name('category') ); ?>" value="<?php echo esc_attr( $category ); ?>" />
				</p>
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'show_custom_nav' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_custom_nav' ) ); ?>" type="checkbox" value="1" <?php checked( $show_custom_nav, 1 ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id( 'show_custom_nav' ) ); ?>"><?php esc_html_e( 'Show Custom Navigation:', 'electro' ) ?></label>
				</p>
			</div>
			<div class="carousel-options show_if_type-1 hide">
				<h2><?php esc_html_e( 'Carousel Options', 'electro' ) ?></h2>
				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'is_nav' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'is_nav' ) ); ?>" type="checkbox" value="1" <?php checked( $is_nav, 1 ); ?> />
					<label for="<?php echo esc_attr( $this->get_field_id( 'is_nav' ) ); ?>"><?php esc_html_e( 'Show Navigation:', 'electro' ) ?></label>
				</p>
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
			</div>
			</div>
			<?php
		}
	}
endif;