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
	
	$SQL = "INSERT INTO ".$wpdb->prefix."posts "; 
	$SQL = $SQL."(
	post_author, 
	post_date, 
	post_date_gmt, 
	post_content, 
	post_title, 
	post_status, 
	comment_status, 
	ping_status, 
	post_name, 
	post_modified, 
	post_modified_gmt,
	post_parent,
	menu_order,
	post_type,
	comment_count
	)";
	$SQL = $SQL." VALUES (";
	$SQL = $SQL."1";
	$SQL = $SQL.", '".date('Y-m-d H:i:s')."'";
	$SQL = $SQL.", '".date('Y-m-d H:i:s')."'";
	$SQL = $SQL.", ''";
	$SQL = $SQL.", 'Home'";
	$SQL = $SQL.", 'publish'";
	$SQL = $SQL.", 'open'";
	$SQL = $SQL.", 'open'";
	$SQL = $SQL.", 'home'";
	$SQL = $SQL.", '".date('Y-m-d H:i:s')."'";
	$SQL = $SQL.", '".date('Y-m-d H:i:s')."'";
	$SQL = $SQL.", 0";
	$SQL = $SQL.", 1";
	$SQL = $SQL.", 'page'";
	$SQL = $SQL.", 0";
	$SQL = $SQL.")";
	
	$wpdb->query($SQL);
	
	
	$SQL2 = "INSERT INTO ".$wpdb->prefix."posts "; 
	$SQL2 = $SQL2."(
	post_author, 
	post_date, 
	post_date_gmt, 
	post_content, 
	post_title, 
	post_status, 
	comment_status, 
	ping_status, 
	post_name, 
	post_modified, 
	post_modified_gmt,
	post_parent,
	menu_order,
	post_type,
	comment_count
	)";
	$SQL2 = $SQL2." VALUES (";
	$SQL2 = $SQL2."1";
	$SQL2 = $SQL2.", '".date('Y-m-d H:i:s')."'";
	$SQL2 = $SQL2.", '".date('Y-m-d H:i:s')."'";
	$SQL2 = $SQL2.", ''";
	$SQL2 = $SQL2.", 'Galleries'";
	$SQL2 = $SQL2.", 'publish'";
	$SQL2 = $SQL2.", 'open'";
	$SQL2 = $SQL2.", 'open'";
	$SQL2 = $SQL2.", 'galleries'";
	$SQL2 = $SQL2.", '".date('Y-m-d H:i:s')."'";
	$SQL2 = $SQL2.", '".date('Y-m-d H:i:s')."'";
	$SQL2 = $SQL2.", 0";
	$SQL2 = $SQL2.", 2";
	$SQL2 = $SQL2.", 'page'";
	$SQL2 = $SQL2.", 0";
	$SQL2 = $SQL2.")";
	
	$wpdb->query($SQL2);
	
	
	$aboutpage = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."posts WHERE ID = 2");
	$i = 0;
	foreach ($aboutpage as $aboutpage) {
		$i = $i+1;
	}
	
	if($i <> 1) {
	
		$SQL5 = "INSERT INTO ".$wpdb->prefix."posts "; 
		$SQL5 = $SQL5."(
		post_author, 
		post_date, 
		post_date_gmt, 
		post_content, 
		post_title, 
		post_status, 
		comment_status, 
		ping_status, 
		post_name, 
		post_modified, 
		post_modified_gmt,
		post_parent,
		menu_order,
		post_type,
		comment_count
		)";
		$SQL5 = $SQL5." VALUES (";
		$SQL5 = $SQL5."1";
		$SQL5 = $SQL5.", '".date('Y-m-d H:i:s')."'";
		$SQL5 = $SQL5.", '".date('Y-m-d H:i:s')."'";
		$SQL5 = $SQL5.", ''";
		$SQL5 = $SQL5.", 'About'";
		$SQL5 = $SQL5.", 'publish'";
		$SQL5 = $SQL5.", 'open'";
		$SQL5 = $SQL5.", 'open'";
		$SQL5 = $SQL5.", 'about'";
		$SQL5 = $SQL5.", '".date('Y-m-d H:i:s')."'";
		$SQL5 = $SQL5.", '".date('Y-m-d H:i:s')."'";
		$SQL5 = $SQL5.", 0";
		$SQL5 = $SQL5.", 3";
		$SQL5 = $SQL5.", 'page'";
		$SQL5 = $SQL5.", 0";
		$SQL5 = $SQL5.")";
		
		$wpdb->query($SQL5);
	
	} else {
	
		$SQLU = "UPDATE ".$wpdb->prefix."posts SET menu_order = 3 WHERE ID = 2";
		$wpdb->query($SQLU);
	
	}
	
	
	$SQL3 = "INSERT INTO ".$wpdb->prefix."posts "; 
	$SQL3 = $SQL3."(
	post_author, 
	post_date, 
	post_date_gmt, 
	post_content, 
	post_title, 
	post_status, 
	comment_status, 
	ping_status, 
	post_name, 
	post_modified, 
	post_modified_gmt,
	post_parent,
	menu_order,
	post_type,
	comment_count
	)";
	$SQL3 = $SQL3." VALUES (";
	$SQL3 = $SQL3."1";
	$SQL3 = $SQL3.", '".date('Y-m-d H:i:s')."'";
	$SQL3 = $SQL3.", '".date('Y-m-d H:i:s')."'";
	$SQL3 = $SQL3.", ''";
	$SQL3 = $SQL3.", 'Blog'";
	$SQL3 = $SQL3.", 'publish'";
	$SQL3 = $SQL3.", 'open'";
	$SQL3 = $SQL3.", 'open'";
	$SQL3 = $SQL3.", 'blog'";
	$SQL3 = $SQL3.", '".date('Y-m-d H:i:s')."'";
	$SQL3 = $SQL3.", '".date('Y-m-d H:i:s')."'";
	$SQL3 = $SQL3.", 0";
	$SQL3 = $SQL3.", 4";
	$SQL3 = $SQL3.", 'page'";
	$SQL3 = $SQL3.", 0";
	$SQL3 = $SQL3.")";
	
	$wpdb->query($SQL3);
	
	
	$SQL4 = "INSERT INTO ".$wpdb->prefix."posts "; 
	$SQL4 = $SQL4."(
	post_author, 
	post_date, 
	post_date_gmt, 
	post_content, 
	post_title, 
	post_status, 
	comment_status, 
	ping_status, 
	post_name, 
	post_modified, 
	post_modified_gmt,
	post_parent,
	menu_order,
	post_type,
	comment_count
	)";
	$SQL4 = $SQL4." VALUES (";
	$SQL4 = $SQL4."1";
	$SQL4 = $SQL4.", '".date('Y-m-d H:i:s')."'";
	$SQL4 = $SQL4.", '".date('Y-m-d H:i:s')."'";
	$SQL4 = $SQL4.", ''";
	$SQL4 = $SQL4.", 'Contact'";
	$SQL4 = $SQL4.", 'publish'";
	$SQL4 = $SQL4.", 'open'";
	$SQL4 = $SQL4.", 'open'";
	$SQL4 = $SQL4.", 'contact'";
	$SQL4 = $SQL4.", '".date('Y-m-d H:i:s')."'";
	$SQL4 = $SQL4.", '".date('Y-m-d H:i:s')."'";
	$SQL4 = $SQL4.", 0";
	$SQL4 = $SQL4.", 5";
	$SQL4 = $SQL4.", 'page'";
	$SQL4 = $SQL4.", 0";
	$SQL4 = $SQL4.")";
	
	$wpdb->query($SQL4);
	
	
	$homepage = $wpdb->get_results("SELECT ID FROM ".$wpdb->prefix."posts WHERE post_title = 'Home' LIMIT 1");
	foreach ($homepage as $homepage) {
		$HPID = $homepage->ID;
	}
	
	$SQLH = "UPDATE ".$wpdb->prefix."options SET option_value = 'page' WHERE option_name = 'show_on_front'";
	$wpdb->query($SQLH);
	
	
	$pagefront = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."options WHERE option_name = 'page_on_front' LIMIT 1");
	$p = 0;
	foreach ($pagefront as $pagefront) {
		$p = $p+1;
	}
	
	if($p == 1) {
	
		$SQLHID = "UPDATE ".$wpdb->prefix."options SET option_value = '".$HPID."' WHERE option_name = 'page_on_front'";
		$wpdb->query($SQLHID);
		
	} else {
	
		$SQL6 = "INSERT INTO ".$wpdb->prefix."options "; 
		$SQL6 = $SQL6."(
		blog_id,
		option_name,
		option_value,
		autoload
		)";
		$SQL6 = $SQL6." VALUES (";
		$SQL6 = $SQL6."0";
		$SQL6 = $SQL6.", 'page_on_front'";
		$SQL6 = $SQL6.", ".$HPID;
		$SQL6 = $SQL6.", 'yes'";
		$SQL6 = $SQL6.")";
		
		$wpdb->query($SQL6);
	
	}
	
	
	$blogpage = $wpdb->get_results("SELECT ID FROM ".$wpdb->prefix."posts WHERE post_title = 'Blog' LIMIT 1");
	foreach ($blogpage as $blogpage) {
		$BPID = $blogpage->ID;
	}
	
	$blogset = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."options WHERE option_name = 'page_for_posts' LIMIT 1");
	$b = 0;
	foreach ($blogset as $blogset) {
		$b = $b+1;
	}
	
	if($b == 1) {
	
		$SQLBID = "UPDATE ".$wpdb->prefix."options SET option_value = '".$BPID."' WHERE option_name = 'page_for_posts'";
		$wpdb->query($SQLBID);
		
	} else {
	
		$SQL7 = "INSERT INTO ".$wpdb->prefix."options "; 
		$SQL7 = $SQL7."(
		blog_id,
		option_name,
		option_value,
		autoload
		)";
		$SQL7 = $SQL7." VALUES (";
		$SQL7 = $SQL7."0";
		$SQL7 = $SQL7.", 'page_for_posts'";
		$SQL7 = $SQL7.", ".$BPID;
		$SQL7 = $SQL7.", 'yes'";
		$SQL7 = $SQL7.")";
		
		$wpdb->query($SQL7);
	
	}
					
?>

