<?php

	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/');
	include_once(ABSPATH . 'wp-config.php');
	include_once(ABSPATH.'wp-load.php');
	include_once(ABSPATH.'wp-includes/wp-db.php');
	global $wpdb;

	if (!current_user_can('manage_options'))
	{
		wp_die('Permission Denied.');
	}
	
	$style = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1", ARRAY_A);
	foreach ($style as $key => $value) {
		$$key = $value;
	}
	
	$SQL1 = "DELETE FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1";
	$wpdb->query($SQL1);
	
	$SQL2 = "INSERT INTO ".$wpdb->prefix."photocrati_styles SELECT * FROM ".$wpdb->prefix."photocrati_presets WHERE preset_name = '" . $wpdb->escape($_POST['preset_name']) . "'";
	$wpdb->query($SQL2);
		
	$SQL3 = "UPDATE ".$wpdb->prefix."photocrati_styles SET ";
	$SQL3 = $SQL3."footer_copy = '".$footer_copy."', ";
	$SQL3 = $SQL3."google_analytics = '".$google_analytics."', ";
	if($custom_logo == 'custom' && $preset_name != 'preset-exposure2' && $preset_name != 'preset-telephoto') {
	$SQL3 = $SQL3."custom_logo = '".$custom_logo."', ";
	$SQL3 = $SQL3."custom_logo_image = '".$custom_logo_image."', ";
	}
	$SQL3 = $SQL3."social_media = '".$social_media."', ";
	$SQL3 = $SQL3."social_media_title = '".$social_media_title."', ";
	$SQL3 = $SQL3."social_media_set = '".$social_media_set."', ";
	$SQL3 = $SQL3."social_rss = '".$social_rss."', ";
	$SQL3 = $SQL3."social_email = '".$social_email."', ";
	$SQL3 = $SQL3."social_twitter = '".$social_twitter."', ";
	$SQL3 = $SQL3."social_facebook = '".$social_facebook."', ";
	$SQL3 = $SQL3."custom_sidebar = '".$custom_sidebar."', ";
	$SQL3 = $SQL3."custom_sidebar_position = '".$custom_sidebar_position."', ";
	$SQL3 = $SQL3."custom_sidebar_html = '".$custom_sidebar_html."', ";
	$SQL3 = $SQL3."footer_widget_placement = '".$footer_widget_placement."', ";
	$SQL3 = $SQL3."footer_height = '".$footer_height."'"; 
	$SQL3 = $SQL3." WHERE option_set = 1";	
	$wpdb->query($SQL3);	
					
?>

