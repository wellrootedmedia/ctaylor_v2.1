<?php

	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/');
	include_once(ABSPATH . 'wp-config.php');
	include_once(ABSPATH.'wp-load.php');
	include_once(ABSPATH.'wp-includes/wp-db.php');
	global $wpdb;
	
	if (!current_user_can('edit_pages') && !current_user_can('edit_posts'))
	{
		wp_die('Permission Denied.');
	}
	
	$style = $wpdb->get_results("SELECT custom_logo_image FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$custom_logo_image = $style->custom_logo_image;
	}
	if($custom_logo_image <> '') {
		unlink(dirname(dirname(dirname(__FILE__))).'/images/uploads/'.$custom_logo_image);
	}
	
	$SQL = "UPDATE ".$wpdb->prefix."photocrati_styles SET ";
	$SQL = $SQL."custom_logo='default'";
	$SQL = $SQL.", custom_logo_image=''";
	$SQL = $SQL.", footer_copy=''";
	$SQL = $SQL." WHERE option_set = 1";
	
	$wpdb->query($SQL);
					
?>

