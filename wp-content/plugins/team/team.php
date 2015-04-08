<?php
/*
Plugin Name: Team
Plugin URI: http://paratheme.com/items/team-responsive-meet-the-team-grid-for-wordpress/
Description: Fully responsive and mobile ready meet the team showcase plugin for wordpress.
Version: 1.4
Author: paratheme
Author URI: http://paratheme.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

define('team_plugin_url', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('team_plugin_dir', plugin_dir_path( __FILE__ ) );
define('team_wp_url', 'http://wordpress.org/plugins/team/' );
define('team_pro_url', 'http://paratheme.com/items/team-responsive-meet-the-team-grid-for-wordpress/' );
define('team_demo_url', 'http://paratheme.com/items/team-responsive-meet-the-team-grid-for-wordpress/' );
define('team_conatct_url', 'http://paratheme.com/contact' );
define('team_qa_url', 'http://paratheme.com/qa/' );
define('team_plugin_name', 'Team' );
define('team_share_url', 'https://wordpress.org/plugins/team/' );
define('team_tutorial_video_url', '//www.youtube.com/embed/8OiNCDavSQg?rel=0' );

require_once( plugin_dir_path( __FILE__ ) . 'includes/team-meta.php');
require_once( plugin_dir_path( __FILE__ ) . 'includes/team-functions.php');



//Themes php files
require_once( plugin_dir_path( __FILE__ ) . 'themes/flat/index.php');
require_once( plugin_dir_path( __FILE__ ) . 'themes/flat-bg/index.php');
require_once( plugin_dir_path( __FILE__ ) . 'themes/rounded/index.php');



function team_init_scripts()
	{
		wp_enqueue_script('jquery');
		wp_enqueue_script('team_js', plugins_url( '/js/team-scripts.js' , __FILE__ ) , array( 'jquery' ));	
		wp_localize_script('team_js', 'team_ajax', array( 'team_ajaxurl' => admin_url( 'admin-ajax.php')));
		wp_enqueue_style('team_style', team_plugin_url.'css/style.css');

		//ParaAdmin
		wp_enqueue_style('ParaAdmin', team_plugin_url.'ParaAdmin/css/ParaAdmin.css');
		wp_enqueue_style('ParaIcons', team_plugin_url.'ParaAdmin/css/ParaIcons.css');		
		wp_enqueue_script('ParaAdmin', plugins_url( 'ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));



		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'team_color_picker', plugins_url('/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
		wp_enqueue_script('jquery.dotdotdot', plugins_url( '/js/jquery.dotdotdot.js' , __FILE__ ) , array( 'jquery' ));
		
		
		
		
		
		// Style for themes
		wp_enqueue_style('team-style-flat', team_plugin_url.'themes/flat/style.css');
		wp_enqueue_style('team-style-flat-bg', team_plugin_url.'themes/flat-bg/style.css');		
		wp_enqueue_style('team-style-rounded', team_plugin_url.'themes/rounded/style.css');	
		
	}
add_action("init","team_init_scripts");







register_activation_hook(__FILE__, 'team_activation');


function team_activation()
	{
		$team_version= "1.4";
		update_option('team_version', $team_version); //update plugin version.
		
		$team_customer_type= "free"; //customer_type "free"
		update_option('team_customer_type', $team_customer_type); //update plugin version.
		
		

		
		
		
		
	}


function team_display($atts, $content = null ) {
		$atts = shortcode_atts(
			array(
				'id' => "",

				), $atts);


			$post_id = $atts['id'];

			$team_themes = get_post_meta( $post_id, 'team_themes', true );

			$team_display ="";

			if($team_themes== "flat")
				{
					$team_display.= team_body_flat($post_id);
				}

			elseif($team_themes== "flat-bg")
				{
					$team_display.= team_body_flat_bg($post_id);
				}
			elseif($team_themes== "rounded")
				{
					$team_display.= team_body_rounded($post_id);
				}				
							
							

return $team_display;



}

add_shortcode('team', 'team_display');





add_action('admin_menu', 'team_menu_init');


	
function team_menu_help(){
	include('team-help.php');	
}

function team_menu_settings(){
	include('team-settings.php');	
}

function team_menu_init()
	{
		add_submenu_page('edit.php?post_type=team', __('Settings','menu-team'), __('Settings','menu-team'), 'manage_options', 'team_menu_settings', 'team_menu_settings');


	}





?>