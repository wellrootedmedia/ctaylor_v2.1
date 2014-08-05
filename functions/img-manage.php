<?php

// These functions control the image management portion of the Photocrati SuperTheme.
// Please do not edit these functions!!


function add_media_button() {

	global $post_ID, $temp_ID, $wpdb;

	$uploading_iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);

	$generic_title = 'Upload/Insert';
	
	$media_upload_iframe_src = "media-upload.php?post_id=$uploading_iframe_ID";
	
	$image_upload_iframe_src = apply_filters('image_upload_iframe_src', "$media_upload_iframe_src&type=image");
	$image_title = 'Add an Image';
	$image_button = '<a href="' . $image_upload_iframe_src . '&TB_iframe=true" id="add_image" class="thickbox" title="' . $image_title . '" onclick="return false;"><img src="images/media-button-image.gif" alt="' . $image_title . '" /></a>';

	$video_upload_iframe_src = apply_filters('video_upload_iframe_src', "$media_upload_iframe_src&type=video");
	$video_title = 'Add Video';
	$video_button = '<a href="' . $video_upload_iframe_src . '&TB_iframe=true" id="add_video" class="thickbox" title="' . $video_title . '" onclick="return false;"><img src="images/media-button-video.gif" alt="' . $video_title . '" /></a>';

	$audio_upload_iframe_src = apply_filters('audio_upload_iframe_src', "$media_upload_iframe_src&type=audio");
	$audio_title = 'Add Audio';
	$audio_button = '<a href="' . $audio_upload_iframe_src . '&TB_iframe=true" id="add_audio" class="thickbox" title="' . $audio_title . '" onclick="return false;"><img src="images/media-button-music.gif" alt="' . $audio_title . '" /></a>';
	
	$media_title = 'Add Media';
	$media_button = '<a href="' . $media_upload_iframe_src . '&TB_iframe=true" id="add_media" class="thickbox" title="' . $media_title . '" onclick="return false;"><img src="images/media-button-other.gif" alt="' . $media_title . '" /></a>';

	$photocrati_upload_iframe_src = apply_filters('audio_upload_iframe_src', get_bloginfo('template_url')."/admin/gallery/upload.php");
	$photocrati_title = 'Add Photocrati Gallery';
	$photocrati_button = '';
    
    $existing = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_ids WHERE post_id = " . ((int)$post_ID));
    $u = 0;
    foreach ($existing as $existing) {
    $u = $u + 1;
    }
    
    if(!$_GET["post"]) {
        $photocrati_button .= '<a href="#" onclick="alert(\'You need to save your post or page before you can insert a Photocrati gallery. You can do this by inserting a title and clicking the Save Draft button.\')" id="add_gallery" title="' . $photocrati_title . '" onclick="return false;"><img src="'.get_bloginfo('template_url').'/admin/images/new_gallery.gif" alt="' . $photocrati_title . '" /></a>';
    } else {
        $photocrati_button .= '<a id="ph_gallery_button" style="clear:none;';
        if($u != 0) {
        //$photocrati_button .= 'display:none;';
        }
        $photocrati_button .= '" href="' . $photocrati_upload_iframe_src . '?post='.$post_ID.'&TB_iframe=true" id="add_gallery" class="thickbox" title="' . $photocrati_title . '" onclick="return false;"><img src="'.get_bloginfo('template_url').'/admin/images/new_gallery.gif" alt="' . $photocrati_title . '" /></a>';
    }

	return $generic_title . ':' . $image_button . ' ' . $video_button . ' ' .  $audio_button . ' ' .  $media_button . ' ' .  $photocrati_button;

}

add_action('media_buttons_context','add_media_button');

      
    function oppColour($c, $inverse=true){
        if(strlen($c)== 3)    { // short-hand
            $c = $c{0}.$c{0}.$c{1}.$c{1}.$c{2}.$c{2};
        }
            $r = (strlen($r=dechex(255-hexdec($c{0}.$c{1})))<2)?'0'.$r:$r;
            $g = (strlen($g=dechex(255-hexdec($c{2}.$c{3})))<2)?'0'.$g:$g;
            $b = (strlen($b=dechex(255-hexdec($c{4}.$c{5})))<2)?'0'.$b:$b;
            return $r.$g.$b;
    } 

function insertGallery($atts) {
	
	$upload_dir = wp_upload_dir();
    
    global $wpdb;
    $global = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1", ARRAY_A);
	foreach ($global as $key => $value) {
		$$key = $value;
	}
	
    $cart_settings = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_ecommerce_settings WHERE id = 1", ARRAY_A);
	foreach ($cart_settings as $key => $value) {
		$$key = $value;
	}
	
	$style = $wpdb->get_row("SELECT bg_color,container_color,content_width,container_padding,container_border FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1", ARRAY_A);
	foreach ($style as $key => $value) {
		$$key = $value;
	}
	
	if($_GET['gal_page'] == 'true'){
    $contwidth = $content_width / 100;
    } else {
    $contwidth = ($content_width - 2) / 100;    
    }
    
	extract(shortcode_atts(array(
	"gal_id" 	=> 		'1_1',
	"gal_type" 	=> 		'1',
    ), $atts));
	
	if ($container_color <> 'transparent') {
		$bg = $container_color;
	} else {
		$bg = $bg_color;
	}
    
	//$insertgallery = '
	//<script type="text/javascript" src="'.get_bloginfo('template_directory').'/admin/js/jquery.lightbox-0.5.js"></script>
	//';
		
	$gallery = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '".$gal_id."' ORDER BY image_order,image_name ASC");
		
	$insertgallery .= '<div class="photocrati_nojava" id="gal_images_'.$gal_id.'">';
	
	$j = 0;
	foreach ($gallery as $gallery) {
	
	$j = $j + 1;
			
		if($image_resolution == '1') {
			
			if (file_exists($upload_dir['basedir'].'/galleries/post-'.$gallery->post_id.'/'.str_replace("&amp;","&",$gallery->image_name))) {
				$url = $upload_dir['baseurl']."/galleries/post-".$gallery->post_id."/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name));
			} else {
				$url = get_bloginfo('template_url')."/galleries/post-".$gallery->post_id."/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name));
			}
			
		} else {
				
			if (file_exists($upload_dir['basedir'].'/galleries/post-'.$gallery->post_id.'/full/'.str_replace("&amp;","&",$gallery->image_name))) {
				$url = $upload_dir['baseurl']."/galleries/post-".$gallery->post_id."/full/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name));
			} else {
				$url = get_bloginfo('template_url')."/galleries/post-".$gallery->post_id."/full/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name));
			}
		   
		}
		
		/*	
		if(function_exists('gd_info') && $gal_type == '4' || function_exists('gd_info') && $gal_type == '3') {
				
			if (file_exists($upload_dir['basedir'].'/galleries/post-'.$gallery->post_id.'/thumbnails/'.str_replace("&amp;","&",$gallery->image_name))) {
				$insertgallery .= "rel='".$upload_dir['baseurl']."/galleries/post-".$gallery->post_id."/thumbnails/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."' ";
			} else {
				$insertgallery .= "rel='".get_bloginfo('template_url')."/galleries/post-".$gallery->post_id."/thumbnails/".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."' ";
			}
			
		}
			
		if($image_resolution == '1' && function_exists('gd_info') && $gal_type == '2') {
				
			if (file_exists($upload_dir['basedir'].'/galleries/post-'.$gallery->post_id.'/thumbnails/'.str_replace("&amp;","&",$gallery->image_name))) {
				$insertgallery .= "rel='".$upload_dir['baseurl']."/galleries/post-".$gallery->post_id."/thumbnails/med-".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."' ";
			} else {
				$insertgallery .= "rel='".get_bloginfo('template_url')."/galleries/post-".$gallery->post_id."/thumbnails/med-".str_replace("%","%25",str_replace("&amp;","&",$gallery->image_name))."' ";
			}
			
		}
		*/	
			
		$alt = stripslashes($gallery->image_alt);
		if($gallery->image_desc){
		$alt .= " - ".htmlspecialchars(stripslashes(str_replace(array("\r", "\r\n", "\n"), '', $gallery->image_desc)))."";
		}
		
		$insertgallery .= "<a href='".$url."' class='decoy' ";
		if($gallery->gal_type == '1' && $gallery_cap1 == 'ON' || $gallery->gal_type == '2' && $gallery_cap2 == 'ON' || $gallery->gal_type == '3' && $gallery_cap3 == 'ON' || $gallery->gal_type == '4' && $gallery_cap4 == 'ON') {
		$insertgallery .= "title=\"".stripslashes($alt)."\"";
		}
		$insertgallery .= "id='img_".$gallery->gallery_id."_".$j."' rel='gallery_".$gallery->gallery_id."'><img src='".$url."' alt=\"".stripslashes($alt)."\" /></a>";
		
	}
			
	$insertgallery .= '</div>';
		
	$insertgallery .= '<script type="text/javascript">
		jQuery.noConflict();
		jQuery("#gal_images_'.$gal_id.'").hide();
			
		function iframe_'.$gal_id.'_loaded()
		{
			var iframe = jQuery("#g'.$gal_id.'")
			var height = iframe.contents().height();
			iframe.height(height);
		}
	</script>';
	
	if($gal_type == '1') {

		if(!is_page()) {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=1&amp;gal_cap='.$gallery_cap1.'&amp;gal_page=false&amp;page_template=false&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		} else if(is_page() && !is_page_template('page-with-sidebar.php')) {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=1&amp;gal_cap='.$gallery_cap1.'&amp;gal_page=true&amp;page_template=false&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		} else {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=1&amp;gal_cap='.$gallery_cap1.'&amp;gal_page=true&amp;page_template=true&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		}

	} else if($gal_type == '2') {
	
		if(!is_page()) {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=2&amp;gal_cap='.$gallery_cap2.'&amp;gal_page=false&amp;page_template=false&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		} else if(is_page() && !is_page_template('page-with-sidebar.php')) {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=2&amp;gal_cap='.$gallery_cap2.'&amp;gal_page=true&amp;page_template=false&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		 } else {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=2&amp;gal_cap='.$gallery_cap2.'&amp;gal_page=true&amp;page_template=true&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		}

	} else if($gal_type == '3') {
    
		if(!is_page()) {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=3&amp;gal_cap='.$gallery_cap3.'&amp;gal_page=false&amp;page_template=false&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		} else if(is_page() && !is_page_template('page-with-sidebar.php')) {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=3&amp;gal_cap='.$gallery_cap3.'&amp;gal_page=true&amp;page_template=false&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		 } else {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=3&amp;gal_cap='.$gallery_cap3.'&amp;gal_page=true&amp;page_template=true&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		}
	
    } else if($gal_type == '4') {
        
		if(!is_page()) {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=4&amp;gal_cap='.$gallery_cap4.'&amp;gal_page=false&amp;page_template=false&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		} else if(is_page() && !is_page_template('page-with-sidebar.php')) {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=4&amp;gal_cap='.$gallery_cap4.'&amp;gal_page=true&amp;page_template=false&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		 } else {
		$insertgallery .= '<div class="iframe_wrapper"><script type="text/javascript">
<!--
document.write (\'<iframe id="g'.$gal_id.'" allowtransparency="true" src="'.get_bloginfo ( 'wpurl' ).'/?display_gallery_iframe&amp;gal_id='.$gal_id.'&amp;gal_type=4&amp;gal_cap='.$gallery_cap4.'&amp;gal_page=true&amp;page_template=true&amp;bg='.$bg.'" scrolling="no" width="100%" frameborder="0" style="margin:0 auto;padding:0;border:0;clear:both;background:transparent;height:0;"></iframe>\');
//-->
</script></div>';
		}

	} else if($gal_type == '5') {
		
	if(is_page() && !is_page_template('page-with-sidebar.php')){
		
		$maxwidth = (960 - ($container_padding * 2) - ($container_border * 2));
	
    } else {
    
		$maxwidth = floor((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth);
		
    }	
		
	$layoutw = floor($maxwidth / $ecomm_per_row);
	$layouth = floor($layoutw * .664);
		
    
	$insertgallery .= '<script src="'. get_bloginfo('template_url') .'/admin/js/jquery.tools.min.js"></script>
	
	<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function() {
			
		jQuery("a.iframe").fancybox({
			\'width\'				: 650,
			\'height\'			: 500,
			\'autoScale\'     	: false,
			\'transitionIn\'	: \'elastic\',
			\'transitionOut\'	: \'elastic\',
			\'overlayColor\'	: \'#0b0b0f\',
			\'type\'			: \'iframe\'
		});
		
		jQuery.ajax({type: "POST", url: "'. get_bloginfo('template_url') .'/ecomm-cart-widget.php", data: \'\', success: function(data)
        {
            jQuery(\'#cart_widget\').html(data)
        }
		
		});
	
	});
	</script>
	
	<style type="text/css">
	
	.ecommerce {
		width			:	'.($layoutw - ($ecomm_line_size * 2) -30).'px;
		height			:	'.(($layouth) + 40).'px;
		margin			:	5px;
		padding			:	10px;
		background		:	#'.$ecomm_back_color.';
		border			:	'.$ecomm_line_size.'px solid #'.$ecomm_line_color.';
	}
	
	.ecommerce .image_wrapper {
		height			:	'.($layouth).'px;
		z-index			:	1;
		overflow		:	hidden;
	}
	
	.ecommerce .image_wrapper img {
		max-width		:	'.($layoutw - ($ecomm_line_size * 4) - 30).'px;
		max-height		:	'.($layouth - ($ecomm_line_size * 2)).'px;
		border			:	'.$ecomm_line_size.'px solid #'.$ecomm_line_color.';
		z-index			:	1;
	}
	
	.ecommerce .meta_wrapper {
		height			:	30px;
		color			:	#333;
		margin-top		:	'.(10).'px;
		text-align		:	left;
		z-index			:	5;
	}
	
	</style>
	
	<div class="ecommerce_wrapper">
	
	<div class="widget_wrapper">
		<div id="cart_widget"></div>
	</div>';
	
	$g = 1;
	$gallery = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '".$gal_id."' ORDER BY image_order,image_name ASC");
	foreach ($gallery as $gallery) {
		
	$action = '';
	$qty = explode(",", $_SESSION['cart_qty']);
			
	foreach ($qty as $cart_items) {
		$item = explode("|", $cart_items);
		if($item[0] == $gallery->id) {
					
			$action = '&actions=edit&page=gallery';
					
		}
	}
	
	$upload_dir = wp_upload_dir();
		
		
	$insertgallery .= '<div class="ecommerce"';
	
	if($g == ($ecomm_per_row + 1)) {
		$insertgallery .= ' style="clear:both;"';
		$g = 1;
	}	
	
	$insertgallery .= '>
		
		<div class="image_wrapper">';
		
				
				if (file_exists($upload_dir['basedir'].'/galleries/post-'.$gallery->post_id.'/thumbnails/'.$gallery->image_name)) {
					
				$insertgallery .= '<a class="photocrati_lightbox" rel="gallery" href="'.$upload_dir['baseurl'].'/galleries/post-'.$gallery->post_id.'/full/'.str_replace("%","%25",$gallery->image_name).'"';
				
				if($ecomm_captions == 'ON') {
					$insertgallery .= 'title="'.$gallery->image_alt.'';
					if($gallery->image_desc) {
						$insertgallery .= ' - '.$gallery->image_desc;
					}
					$insertgallery .= '"';
				}
				
				$insertgallery .= '>
					<img onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false" src="'.$upload_dir['baseurl'].'/galleries/post-'.$gallery->post_id.'/thumbnails/'.str_replace("%","%25",$gallery->image_name).'" alt="'.$gallery->image_name.'">';
				
				} else {
				
				$insertgallery .= '<a class="photocrati_lightbox" rel="gallery" href="'.get_bloginfo('template_url').'/galleries/post-'.$gallery->post_id.'/full/'.str_replace("%","%25",$gallery->image_name).'"';
				
				if($ecomm_captions == 'ON') {
					$insertgallery .= 'title="'.$gallery->image_alt.'';
					if($gallery->image_desc) {
						$insertgallery .= ' - '.$gallery->image_desc;
					}
					$insertgallery .= '"';
				}
				$insertgallery .= '>
					<img onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false" src="'.get_bloginfo('template_url').'/galleries/post-'.$gallery->post_id.'/thumbnails/'.str_replace("%","%25",$gallery->image_name).'" alt="'.$gallery->image_name.'">';
				
				}
				
				$insertgallery .= '</a>
		
			</div>
			
			<div class="meta_wrapper">
				
				<div class="addto">';
					
					if(!$ecomm_but_image) {
					
						$insertgallery .= '<a class="iframe" id="addto_'.$gallery->id.'" href="'.get_bloginfo('template_url').'/ecomm-sizes.php?prod_id='.$gallery->id.$action.'">
						<button id="addto" class="positive">
							'.$ecomm_but_text.'
						</button>
						</a>';
					
					} else {
					
						$insertgallery .= '<a class="iframe" id="addto_'.$gallery->id.'" href="'.get_bloginfo('template_url').'/ecomm-sizes.php?prod_id='.$gallery->id.$action.'">
							<img src="'.$ecomm_but_image.'" id="addto">
						</a>';
					
					}
					
				$insertgallery .= '</div>
		
			</div>
		
		</div>';
		
	$g = $g + 1;
	}
	
	$insertgallery .= '</div>
	<div class="clear"></div>';
	

	} else if($gal_type == '6') {
		
	if(is_page() && !is_page_template('page-with-sidebar.php')){
		
		$maxwidth = (960 - ($container_padding * 2) - ($container_border * 2));
	
    } else {
    
		$maxwidth = floor((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth);
    
    }	
		
		$layoutw = floor($maxwidth / $albuml_per_row);
		$layouth = floor($layoutw * .664);
	
	$insertgallery .= '<style type="text/css">
	
	.album_list {
		width			:	'.($layoutw - ($albuml_line_size * 2) -20).'px;
		height			:	150px;
		margin			:	10px 0;
		padding			:	10px;
		background		:	#'.$albuml_back_color.';
		border			:	'.$albuml_line_size.'px solid #'.$albuml_line_color.';
	}
	
	.album_list .image_wrapper {
		float			:	left;
		z-index			:	1;
		overflow		:	hidden;
	}
	
	.album_list .image_wrapper img {
		border			:	'.$albuml_line_size.'px solid #'.$albuml_line_color.';
		z-index			:	1;
	}
	
	.album_list .meta_wrapper {
		float			:	left;
		color			:	#'.$albuml_font_color.';
		margin-top		:	'.(10).'px;
		text-align		:	left;
		z-index			:	5;
	}
	
	.album_list .meta_wrapper h4 a {
		color			:	#'.$albuml_font_color.';
		font-size		:	'.$albuml_font_size.'px;
	}
	
	</style>
	
	<div class="album_wrapper">';
	
	$g = 1;
	$album = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_albums WHERE album_id = '".$gal_id."' ORDER BY album_order,gallery_id ASC");
	foreach ($album as $album) {
	$postnumber = explode("_", $album->gallery_id);
	$upload_dir = wp_upload_dir();
	
		$gallery_exists = false;
		$image = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '".$album->gallery_id."' ORDER BY image_order,image_name LIMIT 1");
		foreach ($image as $image) {
			$gallery_exists = true;
		}
		
		if($gallery_exists) {
		
		$insertgallery .= '<div class="album_list"';
		if($g == ($albuml_per_row + 1)) {
			$insertgallery .= ' style="clear:both;"'; $g = 1;
		}
		$insertgallery .= '>';
		
			$image = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '".$album->gallery_id."' ORDER BY image_order,image_name LIMIT 1");
			foreach ($image as $image) {		
			
				$insertgallery .= '<div class="image_wrapper">
					<a href="'.get_permalink($image->post_id).'">';
					if (file_exists($upload_dir['basedir'].'/galleries/post-'.$postnumber[0].'/thumbnails/'.$image->image_name)) {
						$insertgallery .= '<img onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false" src="'.$upload_dir['baseurl'].'/galleries/post-'.$postnumber[0].'/thumbnails/'.str_replace("%","%25",$image->image_name).'" alt="'.$image->image_name.'">';
					} else {
						$insertgallery .= '<img onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false" src="'.get_bloginfo('template_url').'/galleries/post-'.$postnumber[0].'/thumbnails/'.str_replace("%","%25",$image->image_name).'" alt="'.$image->image_name.'">';
					}
					$insertgallery .= '</a>
				</div>';
			
			}
			
				$insertgallery .= '<div class="meta_wrapper">';
					
					$meta = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_ids WHERE gallery_id = '".$album->gallery_id."' ORDER BY gallery_id LIMIT 1");
					foreach ($meta as $meta) {		
					
						$insertgallery .= '<h4><a href="'.get_permalink($meta->post_id).'">'.stripslashes($meta->gal_title).'</a></h4>';
						
						$insertgallery .= stripslashes($meta->gal_desc);
					
					}
					
				$insertgallery .= '</div>
		
		</div>';
		
		}
		
	$g = $g + 1;
	}
	
	$insertgallery .= '</div>
	<div class="clear"></div>';
	

	} else if($gal_type == '7') {
		
	if(is_page() && !is_page_template('page-with-sidebar.php')){
		
		$maxwidth = (960 - ($container_padding * 2) - ($container_border * 2));
	
    } else {
    
		$maxwidth = floor((960 - ($container_padding * 2) - ($container_border * 2)) * $contwidth);
    
    }	
		
		$layoutw = floor($maxwidth / $albumg_per_row);
		$layouth = floor($layoutw * .664);
		
	$insertgallery .= '<style type="text/css">
	
	.album_grid {
		width			:	'.($layoutw - ($albumg_line_size * 2) - 30).'px;
		min-height		:	'.($layouth - ($albumg_line_size * 2) + 40).'px;
		height			:	auto;
		float			:	left;
		margin			:	5px;
		padding			:	10px;
		background		:	#'.$albumg_back_color.';
		border			:	'.$albumg_line_size.'px solid #'.$albumg_line_color.';
	}
	
	.album_grid .image_wrapper {
		width			:	'.($layoutw - ($albumg_line_size * 2) - 30).'px;
		height			:	'.($layouth - ($albumg_line_size * 2) + 15).'px;
		float			:	left;
		text-align		:	center;
		z-index			:	1;
		overflow		:	hidden;
	}
	
	.album_grid .image_wrapper img {
		max-width		:	'.($layoutw - ($albumg_line_size * 4) - 30).'px;
		max-height		:	'.($layouth - ($albumg_line_size * 2)).'px;
		border			:	'.$albumg_line_size.'px solid #'.$albumg_line_color.';
		z-index			:	1;
	}
	
	.album_grid .meta_wrapper {
		width			:	100%;
		clear			:	both;
		float			:	left;
		color			:	#'.$albumg_font_color.';
		text-align		:	center;
		z-index			:	5;
	}
	
	.album_grid .meta_wrapper h4 a {
		color			:	#'.$albumg_font_color.';
		font-size		:	'.$albumg_font_size.'px;
	}
	
	</style>
	
	<div class="album_wrapper">';
	
	$g = 1;
	$album = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_albums WHERE album_id = '".$gal_id."' ORDER BY album_order,gallery_id ASC");
	foreach ($album as $album) {
	$postnumber = explode("_", $album->gallery_id);
		
		$gallery_exists = false;
		$image = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '".$album->gallery_id."' ORDER BY image_order,image_name LIMIT 1");
		foreach ($image as $image) {
			$gallery_exists = true;
		}
		
		if($gallery_exists) {
		
		$insertgallery .= '<div class="album_grid"';
		if($g == ($albumg_per_row + 1)) {
			$insertgallery .= ' style="clear:both;"'; $g = 1;
		}
		$insertgallery .= '>';
		
			$image = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '".$album->gallery_id."' ORDER BY image_order,image_name LIMIT 1");
			foreach ($image as $image) {		
			
				$insertgallery .= '<div class="image_wrapper">
					<a href="'.get_permalink($image->post_id).'">';
					if (file_exists($upload_dir['basedir'].'/galleries/post-'.$postnumber[0].'/thumbnails/med-'.$image->image_name)) {
						$insertgallery .= '<img onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false" src="'.$upload_dir['baseurl'].'/galleries/post-'.$postnumber[0].'/thumbnails/med-'.str_replace("%","%25",$image->image_name).'" alt="'.$image->image_name.'">';
					} else {
						$insertgallery .= '<img onmousedown="event.preventDefault ? event.preventDefault() : event.returnValue = false" src="'.get_bloginfo('template_url').'/galleries/post-'.$postnumber[0].'/thumbnails/med-'.str_replace("%","%25",$image->image_name).'" alt="'.$image->image_name.'">';
					}
					$insertgallery .= '</a>
				</div>';
			
			}
			
				$insertgallery .= '<div class="meta_wrapper">';
					
					$meta = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_ids WHERE gallery_id = '".$album->gallery_id."' ORDER BY gallery_id LIMIT 1");
					foreach ($meta as $meta) {		
					
						$insertgallery .= '<h4><a href="'.get_permalink($meta->post_id).'">'.stripslashes($meta->gal_title).'</a></h4>';
					
					}
					
				$insertgallery .= '</div>
		
		</div>';
		
		}
		
	$g = $g + 1;
	}
	
	$insertgallery .= '</div>
	<div class="clear"></div>';

	}
    
    return $insertgallery;
	
}

add_shortcode('photocrati_gallery', 'insertGallery');


function placer_image($content) {
	global $post;
    $original = preg_replace('(<img(.*)id=\"phgallery-([^\"]+) ([^\"]+)\"(.*)src=\"([^\"]+)" alt="photocrati gallery" />)', '[photocrati_gallery gal_id="$2" gal_type="$3"]', $content);
	return $original;
}
add_filter('the_content', 'placer_image');


// Adds a gallery edit box to the "advanced" Post and Page edit screens
function pg_add_custom_box() {
	if( function_exists( 'add_meta_box' )) {
		add_meta_box( 'pg_custom_box_1', __( 'Edit Photocrati Galleries / Albums', 'photocrati' ), 'pg_inner_custom_box_1', 'page', 'normal', 'high' );
		add_meta_box( 'pg_custom_box_2', __( 'Edit Photocrati Galleries / Albums', 'photocrati' ), 'pg_inner_custom_box_1', 'post', 'normal', 'high' );
	}
}

function pg_inner_custom_box_1() {
	$dir = dirname(dirname(__FILE__));
	include($dir.'/admin/gallery/display_galleries.php');
}

add_action('admin_menu', 'pg_add_custom_box');


function delete_phpost($pid) {
	
	global $wpdb;
	$upload_dir = wp_upload_dir();
	
	$pid = (int) $pid;
	
	if ($pid == 0)
		return;
	
	define('GALPATH', $upload_dir['basedir'].'/galleries/post-'.$pid.'/');
	$gallery = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE post_id = '".$pid."' ORDER BY image_name ASC");
	foreach ($gallery as $gallery) {
		
		if (file_exists(GALPATH.$gallery->image_name)) {
			unlink(GALPATH.$gallery->image_name);
		}
		if (file_exists(GALPATH.'full/'.$gallery->image_name)) {
			unlink(GALPATH.'full/'.$gallery->image_name);
		}
		if (file_exists(GALPATH.'thumbnails/'.$gallery->image_name)) {
			unlink(GALPATH.'thumbnails/'.$gallery->image_name);
		}
		if (file_exists(GALPATH.'thumbnails/med-'.$gallery->image_name)) {
			unlink(GALPATH.'thumbnails/med-'.$gallery->image_name);
		}
	
	}
	
	$SQL = "DELETE FROM ".$wpdb->prefix."photocrati_galleries WHERE post_id = '".$pid."'";	
	$wpdb->query($SQL);
	
	$SQL2 = "DELETE FROM ".$wpdb->prefix."photocrati_gallery_ids WHERE post_id = '".$pid."'";	
	$wpdb->query($SQL2);
	
	if (file_exists(GALPATH.'thumbnails/')) {
	rmdir(GALPATH.'thumbnails/');
	}
	if (file_exists(GALPATH.'full/')) {
	rmdir(GALPATH.'full/');
	}
	if (file_exists(GALPATH)) {
	rmdir(GALPATH);
	}
  
}

add_action('delete_post', 'delete_phpost');


// Grab iFrame contents
add_action('init', 'render_iframe_gallery');
function render_iframe_gallery()
{
  //if (preg_match("/\/?display_gallery-iframe/", $_SERVER['REQUEST_URI'])) {
  if (isset($_GET['display_gallery_iframe'])) {
    $path = array();
    $path[] = get_stylesheet_directory();
    $path[]= 'admin';
    $path[]= 'gallery';
    $path[]= 'gallery-iframe.php';
    include(implode(DIRECTORY_SEPARATOR, $path));
    exit(0);
  }
}

?>
