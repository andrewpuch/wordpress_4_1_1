<?php
/**
 * Creates a Products Filter Widget which can be placed in sidebar
 *
 * @class       Electro_Products_Filter_Widget
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
	 * Electro Products Filter widget class
	 *
	 * @since 1.0.0
	 */
	 class Electro_Products_Filter_Widget extends WP_Widget {

		public function __construct() {
			$widget_ops = array( 'description' => esc_html__( 'Add products filter sidebar widgets to your sidebar.', 'electro' ) );
			parent::__construct( 'electro_products_filter', esc_html__( 'Electro Product Filter', 'electro' ), $widget_ops );
		}

		public function widget($args, $instance) {

			global $electro_version;

			if ( ! woocommerce_products_will_display() ) {
				return;
			}
			
			wp_enqueue_script( 'hidemaxlistitem-js',		get_template_directory_uri() . '/assets/js/hidemaxlistitem.min.js', array( 'jquery' ), $electro_version, true );

			$instance['title'] = apply_filters( 'electro_products_filter_widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo wp_kses_post( $args['before_widget'] );

			if ( ! empty($instance['title']) )
				echo wp_kses_post( $args['before_title'] . $instance['title'] . $args['after_title'] );

			if ( ! is_active_sidebar( 'product-filters-widgets' ) ) {
				if ( function_exists( 'electro_default_product_filter_widgets' ) ) {
					electro_default_product_filter_widgets();
				}
			} else {
				dynamic_sidebar( 'product-filters-widgets' );
			}

			?>
			<script type="text/javascript">
				jQuery( document ).ready( function(){
					jQuery('.widget_electro_products_filter .widget .widget-title + ul').hideMaxListItems({
						'max': 5,
						'speed': 500,
						'moreText': "<?php echo esc_attr( esc_html__( '+ Show more', 'electro' ) ); ?>",
						'lessText': "<?php echo esc_attr( esc_html__( '- Show less', 'electro' ) ); ?>",
					});
					if( jQuery('.widget_electro_products_filter > .widget').length == 0 ) {
						jQuery('.widget_electro_products_filter').hide();
					}
				} );
			</script>
			<?php

			echo wp_kses_post( $args['after_widget'] );
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			if ( ! empty( $new_instance['title'] ) ) {
				$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
			}
			return $instance;
		}

		public function form( $instance ) {
			global $wp_registered_sidebars;

			$title = isset( $instance['title'] ) ? $instance['title'] : '';

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
			<?php
		}
	}
endif;