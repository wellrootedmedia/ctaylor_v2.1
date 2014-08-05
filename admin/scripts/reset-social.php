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
	
	$SQL = "UPDATE ".$wpdb->prefix."photocrati_styles SET ";
	$SQL = $SQL."social_media='OFF'";
	$SQL = $SQL.", social_media_title='Follow Me'";
	$SQL = $SQL.", social_media_set='small'";
	$SQL = $SQL.", social_rss=''";
	$SQL = $SQL.", social_email=''";
	$SQL = $SQL.", social_twitter=''";
	$SQL = $SQL.", social_facebook=''";
	$SQL = $SQL." WHERE option_set = 1";
	
	$wpdb->query($SQL);
					
?>

