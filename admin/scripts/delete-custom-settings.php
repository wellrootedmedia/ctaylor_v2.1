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
	
	$SQL = "DELETE FROM ".$wpdb->prefix."photocrati_presets WHERE preset_name = '" . $wpdb->escape($_POST['preset_name']) . "' AND custom_setting = 'YES'";	
	$wpdb->query($SQL);
					
?>

