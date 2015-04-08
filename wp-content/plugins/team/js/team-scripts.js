
jQuery(document).ready(function($)
	{
		$(document).on('click', '.team_content_source', function()
			{	
				var source = $(this).val();
				var source_id = $(this).attr("id");
				
				$(".content-source-box.active").removeClass("active");
				$(".content-source-box."+source_id).addClass("active");

			})
			
			
		$(document).on('click', '.new_team_member_social_field', function()
			{
				var user_profile_social = prompt("Please add new social site","");
				
				if(user_profile_social=='' || user_profile_social==null)
					{
					
					}
				else
					{
				$(".team_member_social_field").append('<input type="text" name="team_member_social_field['+user_profile_social+']" value="'+user_profile_social+'"  /><br />');
					}
				


			
		
			})
			
			
			
			
			
			
			
			
			

	});	
