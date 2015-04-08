<?php	


if ( ! defined('ABSPATH')) exit; // if direct access 



if(empty($_POST['team_hidden']))
	{
		$team_member_social_field = get_option( 'team_member_social_field' );
	}
else
	{	
		if($_POST['team_hidden'] == 'Y') {
			//Form data sent
			$team_member_social_field = stripslashes_deep($_POST['team_member_social_field']);
			update_option('team_member_social_field', $team_member_social_field);
	
			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.' ); ?></strong></p></div>
	
			<?php
			} 
	}
	
	
	
    $team_customer_type = get_option('team_customer_type');
    $team_version = get_option('team_version');
	
	
?>





<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(team_plugin_name.' Settings')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="team_hidden" value="Y">
        <?php settings_fields( 'team_plugin_options' );
				do_settings_sections( 'team_plugin_options' );
			
		?>

    <div class="para-settings">
    
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Options</li>
            <li nav="2" class="nav2">Help & Upgrade</li>
        </ul> <!-- tab-nav end -->    
		<ul class="box">
            <li style="display: block;" class="box1 tab-box active">
                <div class="option-box">
                    <p class="option-title">Display input field on team member profile.</p>
                    <p class="option-info">By adding bellow input you can control extra input field under member page. if you want to remove one profile field then please empty this field and save changes or to add new profile field simply click add new. Some default profile fields are facebook, twitter, googleplus, pinterest.</p>
                    <table class="team_member_social_field">
                            
                      
                    <?php 
        
                    if(empty($team_member_social_field))
                        {
                            $team_member_social_field = array("facebook"=>"facebook","twitter"=>"twitter","googleplus"=>"googleplus","pinterest"=>"pinterest");
                            
                        }
        
                    foreach ($team_member_social_field as $value) {
                        if(!empty($value))
                            {
                                ?>
                            <tr><td>
                            <input type="text" name="team_member_social_field[<?php echo $value; ?>]" value="<?php if(isset($team_member_social_field[$value])) echo $team_member_social_field[$value]; else echo $value; ?>"  /><br />
                            </td>
                            </tr>
                                <?php
                            
                            }
                    }
                    
                    ?>
        
                    
                    </table> 
                    
        
                    <div class="button new_team_member_social_field">Add New</div>
        
                </div>   
            
            
            
            
            </li>
            <li style="display: none;" class="box2 tab-box active">
				<div class="option-box">
                    <p class="option-title">Need Help ?</p>
                    <p class="option-info">Feel free to Contact with any issue for this plugin, Ask any question via forum <a href="<?php echo team_qa_url; ?>"><?php echo team_qa_url; ?></a> <strong style="color:#139b50;">(free)</strong><br />
                    
                    </p>
                    
                    
                    
                </div>
                
                
				<div class="option-box">
                    <p class="option-title">Upgrade</p>
                    <p class="option-info">
					<?php
                
                
                    if($team_customer_type=="free")
                        {
                    
                            echo 'You are using <strong> '.$team_customer_type.' version  '.$team_version.'</strong> of <strong>'.team_plugin_name.'</strong>, To get more feature you could try our premium version. ';
                            
                            echo '<br /><a href="'.team_pro_url.'">'.team_pro_url.'</a>';
                            
                        }
                    else
                        {
                    
                            echo 'Thanks for using <strong> premium version  '.$team_version.'</strong> of <strong>'.team_plugin_name.'</strong> ';	
                            
                            
                        }
                    
                     ?>       

           
                    
                    
                    
                    </p>
                	
                </div>
                
                
                
                
				<div class="option-box">
                    <p class="option-title">Submit Reviews...</p>
                    <p class="option-info">We are working hard to build some awesome plugins for you and spend thousand hour for plugins. we wish your three(3) minute by submitting five star reviews at wordpress.org. if you have any issue please submit at forum.</p>
                	<img class="team-pro-pricing" src="<?php echo team_plugin_url."css/five-star.png";?>" /><br />
                    <a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/team">
                	https://wordpress.org/support/view/plugin-reviews/team
               		</a>
                    
                    
                    
                </div>
                
                
				<div class="option-box">
                    <p class="option-title">Please Share</p>
                    <p class="option-info">If you like this plugin please share with your social share network.</p>
                	
                    <?php
                    
						echo team_share_plugin();
					?>

                </div>
                
				<div class="option-box">
                    <p class="option-title">Video Tutorial</p>
                    <p class="option-info">Please watch this video tutorial.</p>
                	<iframe width="640" height="480" src="<?php echo team_tutorial_video_url; ?>" frameborder="0" allowfullscreen></iframe>
                </div>
   
            </li>

        </ul>
    
    
    
    
		
    </div>






<p class="submit">
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes' ) ?>" />
                </p>
		</form>


</div>
