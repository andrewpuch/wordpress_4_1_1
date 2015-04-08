<?php


if ( ! defined('ABSPATH')) exit; // if direct access 

add_theme_support('post-thumbnails', array('team_member'));
add_filter('widget_text', 'do_shortcode');



function team_get_all_post_ids($postid)
	{
		
		$team_post_ids = get_post_meta( $postid, 'team_post_ids', true );
		
		
		$return_string = '';
		$return_string .= '<ul style="margin: 0;">';

		$args_product = array(
		'post_type' => array('team_member'),
		'posts_per_page' => -1,
		);

		$product_query = new WP_Query( $args_product );
	
		if($product_query->have_posts()): while($product_query->have_posts()): $product_query->the_post();
		

	   $return_string .= '<li><label ><input class="team_post_ids" type="checkbox" name="team_post_ids['.get_the_ID().']" value ="'.get_the_ID().'" ';
		
		if ( isset( $team_post_ids[get_the_ID()] ) )
			{
			$return_string .= "checked";
			}

		$return_string .= '/>';

		$return_string .= get_the_title().'</label ></li>';
			
		endwhile; 
		
		else:
		$return_string .= '<span style="color:#f00;">Sorry No Post Found, Please select at least one posttype above or make sure you have at least one post in your posttype selection.';
		endif; wp_reset_query();
		
		
		$return_string .= '</ul>';
		echo $return_string;
	
	}






function team_get_taxonomy_category($postid)
	{

	$team_taxonomy = array('team_group');
	
	if(empty($team_taxonomy))
		{
			$team_taxonomy= "";
		}
	$team_taxonomy_category = get_post_meta( $postid, 'team_taxonomy_category', true );
	
		
		if(empty($team_taxonomy_category))
			{
			 	$team_taxonomy_category =array('none'); // an empty array when no category element selected
				
			
			}

		
		
		if(!isset($_POST['taxonomy']))
			{
			$taxonomy =$team_taxonomy;
			}
		else
			{
			$taxonomy = $_POST['taxonomy'];
			}
		
		
		$args=array(
		  'orderby' => 'name',
		  'order' => 'ASC',
		  'taxonomy' => $taxonomy,
		  );
	
	$categories = get_categories($args);
	
	
	if(empty($categories))
		{
		echo "No Items Found!";
		}
	
	
		$return_string = '';
		$return_string .= '<ul style="margin: 0;">';
	
	foreach($categories as $category){
		
		if(array_search($category->cat_ID, $team_taxonomy_category))
		{
	   $return_string .= '<li class='.$category->cat_ID.'><label ><input class="team_taxonomy_category" checked type="checkbox" name="team_taxonomy_category['.$category->cat_ID.']" value ="'.$category->cat_ID.'" />'.$category->cat_name.'</label ></li>';
		}
		
		else
			{
				   $return_string .= '<li class='.$category->cat_ID.'><label ><input class="team_taxonomy_category" type="checkbox" name="team_taxonomy_category['.$category->cat_ID.']" value ="'.$category->cat_ID.'" />'.$category->cat_name.'</label ></li>';			
			}
		
		

		
		}
	
		$return_string .= '</ul>';
		
		echo $return_string;
	
	if(isset($_POST['taxonomy']))
		{
			die();
		}
	
		
	}

add_action('wp_ajax_team_get_taxonomy_category', 'team_get_taxonomy_category');
add_action('wp_ajax_nopriv_team_get_taxonomy_category', 'team_get_taxonomy_category');
























































function team_dark_color($input_color)
	{
		if(empty($input_color))
			{
				return "";
			}
		else
			{
				$input = $input_color;
			  
				$col = Array(
					hexdec(substr($input,1,2)),
					hexdec(substr($input,3,2)),
					hexdec(substr($input,5,2))
				);
				$darker = Array(
					$col[0]/2,
					$col[1]/2,
					$col[2]/2
				);
		
				return "#".sprintf("%02X%02X%02X", $darker[0], $darker[1], $darker[2]);
			}

		
		
	}
	
	
	
	
	
	
	function team_share_plugin()
		{
			
			?>
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwordpress.org%2Fsupport%2Fplugin%2Fteam&amp;width&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=80&amp;appId=652982311485932" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:80px;" allowTransparency="true"></iframe>

<br />
<!-- Place this tag in your head or just before your close body tag. -->
<script src="https://apis.google.com/js/platform.js" async defer></script>

<!-- Place this tag where you want the +1 button to render. -->
<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300" data-href="<?php echo team_share_url; ?>"></div>

<br />
<br />
<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo team_share_url; ?>" data-text="hello" data-via="ParaTheme" data-hashtags="WordPress">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>









            <?php
			
			
			
		
		
		}
	
	
	
	
	
	
	
	
	
	

	