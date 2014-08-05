<?php

	if (!function_exists('current_user_can') || !current_user_can('manage_options'))
	{
		if (function_exists('wp_die'))
		{
			wp_die('Permission Denied.');
		}
		else
		{
			die('Permission Denied.');
		}
	}

	include "scripts/scripts-css.php";
    $preset         = Photocrati_Style_Manager::get_active_preset();
    $custom_css     = $preset->custom_css;
    $dynamic_style  = $preset->dynamic_style;
?>

<div id="admin-wrapper">
    
    <div id="container">
    
		<div class="options">Dynamic Styling</div>
        
            <div class="sub-options"><span id="comments">Disable or enable the dynamic styling. If the dynamic styling is disabled you can use styles/style.css to customize your theme.</span></div>
            <div class="option-content">
            
                <div id="option-container">
                
                	<div class="left" style="border-right:0;width:30%;">
                    
                        <form name="dynamic-stying" id="dynamic-styling" method="post">
                        
                            <div class="inner" style="width:100%;">
                                <p class="titles">Dynamic Styling Enabled?</p>
                                <p>
                                <select name="dynamic_style" id="dynamic_style">
                                    <option value='YES' <?php selected($dynamic_style, TRUE) ?>>YES</option>
                                    <option value='NO' <?php selected($dynamic_style, FALSE) ?>>NO</option>
                                </select>
                                </p>
                            </div>
                            
                            <div id="msg11" style="float:left;"></div>
                        
                        </form>
                        
                    </div>
					
					<div class="left" style="border-right:0;width:60%;">
						<p><i>
							<b>Note:</b>
							When you disable the dynamic styling a static style sheet will be generated
							based on the current theme style. You can edit this file at styles/style.css.
						</i></p>
					</div>
                                        
        		</div>
        </div>
	
		<?php if($dynamic_style) { ?>
    	<div class="options">Custom CSS Code</div>
        
            <div class="sub-options"><span id="comments">If you insert code with custom classes you can style it here! You can also over ride theme styles.</span></div>
            <div class="option-content">
            
                <div id="option-container">
                
                <form name="css-options" id="css-options" method="post">
                
                    <div class="left" style="border:0;">
                    
                        <p class="titles">CSS Code (leave blank to exclude)</p>
                        <p>
                        	<textarea name="custom_css" cols="80" rows="10"><?php echo stripslashes(str_replace('"', '&quot;', $custom_css)); ?></textarea>
                        </p>
                        
                    </div>
                    
                    <div class="right">
                    
                    </div>
                    
                    <div class="submit-button-wrapper">
                        <input type="button" class="button" id="update-css" value="Update Custom CSS" style="clear:none;" /> 
                    </div>
                    <div id="msg2" style="float:left;"></div>
                
                </form>
                
                </div>
                
        </div>
		<?php } ?>
    
    </div>
    
</div>
