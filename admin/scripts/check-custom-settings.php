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
	
	$exists = 0;
	$presets = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."photocrati_presets WHERE preset_name = '" . $wpdb->escape(str_replace(' ', '-', strtolower($_POST['preset_name']))) . "'");
	foreach ($presets as $presets) {
		$exists = $exists + 1;
	}
	
	if($exists == 0) {
		echo 'EXISTS - NO';
	} else {
		echo 'EXISTS - YES';
	}
					
?>

