<?php

	define('ABSPATH', dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/');
	include_once(ABSPATH.'wp-config.php');
	include_once(ABSPATH.'wp-load.php');
	include_once(ABSPATH.'wp-includes/wp-db.php');
	global $wpdb;
	
	if (!current_user_can('edit_pages') && !current_user_can('edit_posts'))
	{
		wp_die('Permission Denied.');
	}
		
	$SQL = "SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE gallery_id = '" . $wpdb->escape($_POST['gallery_id']) . "' AND image_name = '" . $wpdb->escape(htmlspecialchars($_POST['image_name'])) . "'";	
	$eximg = $wpdb->get_results($SQL);
	foreach ($eximg as $eximg) {
		$imgname = $eximg->image_name;
	}
	
		if($imgname <> '') {
			
			$SQL3 = "UPDATE ".$wpdb->prefix."photocrati_galleries SET gal_type = " . ((int)$_POST['gal_type']) . " WHERE gallery_id = '" . $wpdb->escape($_POST['gallery_id']) . "' AND image_name = '" . $wpdb->escape(htmlspecialchars($_POST['image_name'])) . "'";
			$wpdb->query($SQL3);
		
		} else {
		
			$SQL2 = "INSERT INTO ".$wpdb->prefix."photocrati_galleries (gallery_id, post_id, gal_type, image_name, image_order, image_alt, image_desc, ecomm_options) VALUES (";
				$i = 0;
				foreach ($_POST as $key => $value) {
					if ($key != 'ecomm_options') {
					if ($i != 0) { $comma = ", ";} else { $comma = ""; }
						$SQL2 = $SQL2.$comma."'" . $wpdb->escape(htmlspecialchars($value)) . "'";
					$i = $i + 1;
					}
				}
			$SQL2 = $SQL2.", '1,2,3,4,5,6,7,8,9,10,11,12')";
			
			$wpdb->query($SQL2);				
						
		}
?>
