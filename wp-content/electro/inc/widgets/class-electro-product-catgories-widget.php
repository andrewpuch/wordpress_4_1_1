<?php
/**
 * Creates a Electro Product Categories Widget which can be placed in sidebar
 *
 * @class       Electro_Product_Categories_Widget
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
	 * Electro Products Categories widget class
	 *
	 * @since 1.0.0
	 */
	class Electro_Product_Categories_Widget extends WP_Widget {

		/**
		 * Current Category.
		 *
		 * @var bool
		 */
		public $current_cat;

		/**
		 * Current Category Parent.
		 *
		 * @var array
		 */
		public $current_cat_parent;

		public function __construct() {
			$widget_ops = array( 'classname' => 'woocommerce widget_product_categories electro_widget_product_categories', 'description' => esc_html__( 'A list of product categories.', 'electro' ) );
			parent::__construct( 'electro_product_categories_widget', esc_html__( 'Electro Product Categories', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {
			global $wp_query, $post;

			$count = isset( $instance['count'] ) ? $instance['count'] : false;
			$hide_empty = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : false;
			$el_class = '';

			$list_args	= array(
				'show_count' => $count,
				'taxonomy' => 'product_cat',
				'orderby' => 'id',
				'echo' => false,
				'hide_empty' => $hide_empty
			);

			// Setup Current Category
			$this->current_cat   = false;
			$this->current_cat_parent = false;

			if ( is_tax( 'product_cat' ) ) {

				$this->current_cat   = $wp_query->queried_object;
				$this->current_cat_parent = $this->current_cat->parent;

			} elseif ( is_singular( 'product' ) ) {

				$product_category = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent' ) );

				if ( $product_category ) {
					$this->current_cat   = end( $product_category );
					$this->current_cat_parent = $this->current_cat->parent;
				}

			}

			// Show Children Only
			if ( $this->current_cat ) {

				$el_class = 'category-single';
				$show_all_categories_text = apply_filters( 'electro_product_categories_widget_show_all_categories_text', esc_html__( 'Show All Categories', 'electro' ) );

				// Top level is needed
				$top_level = wp_list_categories( array(
					'title_li'     => sprintf( '<span class="show-all-cat-dropdown">%1$s</span>', $show_all_categories_text ),
					'taxonomy'     => 'product_cat',
					'parent'       => 0,
					'hierarchical' => true,
					'hide_empty'   => false,
					'exclude'      => $this->current_cat->term_id,
					'show_count'   => $count,
					'hide_empty'   => $hide_empty,
					'echo'         => false
				) );

				$list_args['title_li'] = '<ul class="show-all-cat">' . $top_level . '</ul>';

				// Direct children are wanted
				$direct_children = get_terms(
					'product_cat',
					array(
						'fields'       => 'ids',
						'child_of'     => $this->current_cat->term_id,
						'hierarchical' => true,
						'hide_empty'   => false
					)
				);

				$siblings = array();
				if( $this->current_cat_parent ) {
					// Siblings are wanted
					$siblings = get_terms(
						'product_cat',
						array(
							'fields'       => 'ids',
							'child_of'     => $this->current_cat_parent,
							'hierarchical' => true,
							'hide_empty'   => false
						)
					);
				}

				$include = array_merge( array( $this->current_cat->term_id, $this->current_cat_parent ), $direct_children, $siblings );

				$list_args['include']     = implode( ',', $include );
				$list_args['depth']       = 3;

				if ( empty( $include ) ) {
					return;
				}

			} else {
				$all_categories_text           = apply_filters( 'electro_product_categories_widget_shop_all_categories_text', esc_html__( 'Browse Categories', 'electro' ) );
				$list_args['title_li']         = sprintf( '<span>%1$s</span>', $all_categories_text );
				$list_args['depth']            = 2;
				$list_args['child_of']         = 0;
				$list_args['hierarchical']     = 1;
			}

			$list_args['pad_counts']                 = 1;
			$list_args['show_option_none']           = esc_html__('No product categories exist.', 'electro' );
			$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';

			echo wp_kses_post( $args['before_widget'] );

			$output = wp_list_categories( apply_filters( 'electro_product_categories_widget_args', $list_args ) );
			$output = str_replace('</a> (', '</a> <span class="count">(', $output);
			$output = str_replace(')', ')</span>', $output);

			echo '<ul class="product-categories ' . esc_attr( $el_class ) . '">';

			echo wp_kses_post( $output );

			echo '</ul>';

			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['count'] ) ) {
				$instance['count'] = strip_tags( stripslashes($new_instance['count']) );
			}
			if ( ! empty( $new_instance['hide_empty'] ) ) {
				$instance['hide_empty'] = strip_tags( stripslashes($new_instance['hide_empty']) );
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			$count = isset( $instance['count'] ) ? $instance['count'] : '';
			$hide_empty = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : '';

			// If no sidebars exists.
			if ( !$wp_registered_sidebars ) {
				echo '<p>'. esc_html__('No sidebars are available.', 'electro' ) .'</p>';
				return;
			}
			?>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="checkbox" value="1" <?php checked( $count, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Show Product Count:', 'electro' ) ?></label>
			</p>
			<p>
				<input id="<?php echo esc_attr( $this->get_field_id( 'hide_empty' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_empty' ) ); ?>" type="checkbox" value="1" <?php checked( $hide_empty, 1 ); ?> />
				<label for="<?php echo esc_attr( $this->get_field_id( 'hide_empty' ) ); ?>"><?php esc_html_e( 'Hide Empty:', 'electro' ) ?></label>
			</p>
			<?php
		}
	}
endif;
