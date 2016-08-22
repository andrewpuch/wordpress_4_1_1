<?php
/*-----------------------------------------------------------------------------------*/
/*	Recent Posts Widget Class
/*-----------------------------------------------------------------------------------*/
class Electro_Recent_Posts_Widget extends WP_Widget {

	public $defaults;

	public function __construct() {

		$widget_ops = array(
			'classname' 	=> 'electro_recent_posts_widget',
			'description' 	=> esc_html__( 'Your site&#8217;s most recent Posts.', 'electro' )
		);

        parent::__construct( 'electro_recent_posts_widget', esc_html__('Electro Recent Posts', 'electro'), $widget_ops );

		$defaults = apply_filters( 'electro_recent_posts_widget_default_args', array(
			'title'		=> '',
			'number'	=> 5,
			'show_date'	=> true
		) );
		$this->defaults = $defaults;
	}

	public function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$instance = wp_parse_args( (array) $instance, $this->defaults );

		electro_get_template( 'widgets/recent-posts-widget.php', array( 'args' => $args,'instance' => $instance ) );
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title']			= strip_tags( $new_instance['title'] );
		$instance['number']			= strip_tags( $new_instance['number'] );
		$instance['show_date']		= strip_tags( $new_instance['show_date'] );

		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e('Title', 'electro'); ?>:</label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'electro' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $instance['number'] ); ?>" size="3" />
		</p>

		<p>
			<input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Display post date?', 'electro' ); ?></label>
		</p>

		<?php
		do_action( 'electro_recent_posts_widget_add_opts', $this, $instance);
	}

}
