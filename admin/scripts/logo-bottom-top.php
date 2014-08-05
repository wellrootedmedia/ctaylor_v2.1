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
	
	$style = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1", ARRAY_A);
	foreach ($style as $key => $value) {
		$$key = $value;
	}
	
	$SQL = "UPDATE ".$wpdb->prefix."photocrati_styles SET ";
	
	if($one_column_logo == 'ON') {
	
	$SQL = $SQL."logo_menu_position='bottom-top', ";
	$SQL = $SQL."header_logo_margin_above='0', ";
	$SQL = $SQL."header_logo_margin_below='0' ";
	
	} else {
	
	$SQL = $SQL."logo_menu_position='bottom-top', ";
	$SQL = $SQL."header_logo_margin_above='60', ";
	$SQL = $SQL."header_logo_margin_below='20' ";
		
	}
	
	$SQL = $SQL." WHERE option_set = 1";
	
	$wpdb->query($SQL);
					
?>

