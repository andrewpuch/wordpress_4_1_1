<?php
/**
 * Electro Meta Boxes
 *
 * Sets up the write panels used by products and orders (custom post types).
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Electro_Admin_Meta_Boxes.
 */
class Electro_Admin_Meta_Boxes {

	/**
	 * Is meta boxes saved once?
	 *
	 * @var boolean
	 */
	private static $saved_meta_boxes = false;

	/**
	 * Meta box error messages.
	 *
	 * @var array
	 */
	public static $meta_box_errors  = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		global $post;
		
		//add_action( 'add_meta_boxes', array( $this, 'remove_meta_boxes' ), 10 );
		//add_action( 'add_meta_boxes', array( $this, 'rename_meta_boxes' ), 20 );
		
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 30 );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ), 1, 2 );

		// Save Page Meta Boxes
		add_action( 'electro_process_page_home_v1_meta', 'Electro_Meta_Box_Home_v1::save', 10, 2 );
		add_action( 'electro_process_page_home_v2_meta', 'Electro_Meta_Box_Home_v2::save', 10, 2 );
		add_action( 'electro_process_page_home_v3_meta', 'Electro_Meta_Box_Home_v3::save', 10, 2 );
		add_action( 'electro_process_page_meta', 'Electro_Meta_Box_Page::save', 10, 2 );

		// Error handling (for showing errors from meta boxes on next page load)
		add_action( 'admin_notices', array( $this, 'output_errors' ) );
		add_action( 'shutdown', array( $this, 'save_errors' ) );
	}

	/**
	 * Add an error message.
	 * @param string $text
	 */
	public static function add_error( $text ) {
		self::$meta_box_errors[] = $text;
	}

	/**
	 * Save errors to an option.
	 */
	public function save_errors() {
		update_option( 'electro_meta_box_errors', self::$meta_box_errors );
	}

	/**
	 * Show any stored error messages.
	 */
	public function output_errors() {
		$errors = maybe_unserialize( get_option( 'electro_meta_box_errors' ) );

		if ( ! empty( $errors ) ) {

			echo '<div id="electro_errors" class="error notice is-dismissible">';

			foreach ( $errors as $error ) {
				echo '<p>' . wp_kses_post( $error ) . '</p>';
			}

			echo '</div>';

			// Clear
			delete_option( 'electro_meta_box_errors' );
		}
	}

	/**
	 * Add Electro Meta boxes.
	 */
	public function add_meta_boxes( $post_type ) {
		global $post;
		
		$screen = get_current_screen();

		$template_file = get_post_meta( $post->ID, '_wp_page_template', true );

		switch( $template_file ) {
			case 'template-homepage-v1.php':
			case 'template-homepage-v2.php';
			case 'template-homepage-v3.php':
				$this->add_home_meta_boxes( $post_type );
			break;
			default:
				$this->add_page_meta_box( $post_type );
		}
	}

	private function add_page_meta_box() {
		add_meta_box( '_electro_page_metabox', esc_html__( 'Electro Page Options', 'electro' ), 'Electro_Meta_Box_Page::output', 'page', 'normal', 'high' );
	}

	/**
	 * Add Home Meta boxes
	 */
	private function add_home_meta_boxes() {
		global $post;

		$template_file = get_post_meta( $post->ID, '_wp_page_template', true );

		if ( ! ( $template_file === 'template-homepage-v1.php' || $template_file === 'template-homepage-v2.php' || $template_file === 'template-homepage-v3.php' ) ) {
			return;
		}

		switch( $template_file ) {
			case 'template-homepage-v1.php':
				$meta_box_title 	= esc_html__( 'Home v1 Options', 'electro' );
				$meta_box_output 	= 'Electro_Meta_Box_Home_v1::output';
			break;
			case 'template-homepage-v2.php':
				$meta_box_title 	= esc_html__( 'Home v2 Options', 'electro' );
				$meta_box_output 	= 'Electro_Meta_Box_Home_v2::output';
			break;
			case 'template-homepage-v3.php':
				$meta_box_title 	= esc_html__( 'Home v3 Options', 'electro' );
				$meta_box_output 	= 'Electro_Meta_Box_Home_v3::output';
			break;
		}
		
		add_meta_box( 'electro-home-page-options', $meta_box_title, $meta_box_output, 'page', 'normal', 'high' );
	}

	/**
	 * Check if we're saving, the trigger an action based on the post type.
	 *
	 * @param  int $post_id
	 * @param  object $post
	 */
	public function save_meta_boxes( $post_id, $post ) {

		// $post_id and $post are required
		if ( empty( $post_id ) || empty( $post ) || self::$saved_meta_boxes ) {
			return;
		}

		// Dont' save meta boxes for revisions or autosaves
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the nonce
		if ( empty( $_POST['electro_meta_nonce'] ) || ! wp_verify_nonce( $_POST['electro_meta_nonce'], 'electro_save_data' ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// We need this save event to run once to avoid potential endless loops. This would have been perfect:
		//	remove_action( current_filter(), __METHOD__ );
		// But cannot be used due to https://github.com/woothemes/woocommerce/issues/6485
		// When that is patched in core we can use the above. For now:
		self::$saved_meta_boxes = true;

		$what = $post->post_type;

		if ( $what == 'page' ) {
			
			$template_file = get_post_meta( $post_id, '_wp_page_template', true );

			switch( $template_file ) {
				case 'template-homepage-v1.php':
					$what .= '_home_v1';
				break;
				case 'template-homepage-v2.php':
					$what .= '_home_v2';
				break;
				case 'template-homepage-v3.php':
					$what .= '_home_v3';
				break;
			}
		}

		do_action( 'electro_process_' . $what . '_meta', $post_id, $post );
	}
}

new Electro_Admin_Meta_Boxes();