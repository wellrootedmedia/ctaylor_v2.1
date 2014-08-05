<?php

// These functions control the ecommerce portion of the Photocrati SuperTheme.
// Please do not edit these functions!!

function cp_admin_init()
{
	if (!session_id())
	{
		session_start();
	}
	
	if (isset($_GET['merchant_return_link']) || isset($_GET['photocrati_return_link']))
	{
		unset($_SESSION['cart']);
		unset($_SESSION['cart_qty']);
	}
}

add_action('init', 'cp_admin_init');


function wp_exist_post_by_title($title_str) {
	global $wpdb;
	return $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."posts WHERE post_title = '" . $title_str . "'", 'ARRAY_A');
}

function add_cart_page() {

	global $wpdb;
	$setting = $wpdb->get_results("SELECT ecomm_title FROM ".$wpdb->prefix."photocrati_ecommerce_settings WHERE id = 1");
	foreach ($setting as $setting) {
		$ecomm_title = $setting->ecomm_title;
	}
	
	if (wp_exist_post_by_title(''.$ecomm_title.'')) {
		
		// page exists
	
	} else {
		
		$new_post = array(
		'post_title' => ''.$ecomm_title.'',
		'post_content' => '',
		'post_status' => 'publish',
		'post_date' => date('Y-m-d H:i:s'),
		'post_author' => 1,
		'menu_order' => 999,
		'post_type' => 'page'
		);
		$post_id = wp_insert_post($new_post);
		
		if($post_id) {
			update_post_meta($post_id, '_wp_page_template',  'template-cart.php');
		}
	
	}
	
}

add_action('init', 'add_cart_page');


function writeShoppingCart() {

	global $wpdb;
	$settings = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_ecommerce_settings WHERE id = 1", ARRAY_A);
	foreach ($settings as $key => $value) {
		$$key = $value;
	}
	
	$cart = $_SESSION['cart'];
	if (!$cart) {
		return '<p><em>'.$ecomm_empty.'</em> </p>';
	} else {
		// Parse the cart session variable
		$items = explode(',',$cart);
		$s = (count($items) > 1) ? 's':'';
		if ( get_option('permalink_structure') != '' ) {
			
			return '<button id="addto2" class="positive" style="margin:0 5px;" onClick=\'window.location.href = "'.get_bloginfo('url').'/'.str_replace(" ","-",strtolower($ecomm_title)).'/"\'><img src="'.get_bloginfo('template_directory').'/images/cart.png"> '.$ecomm_title.': '.count($items).' item'.$s.'</button>';
		
		} else {
			
			$pgid = query_posts(array('pagename' => $ecomm_title));
			foreach($pgid as $pgid){
			  $pageid = $pgid->ID;
			}
			wp_reset_query();
			return '<button id="addto2" class="positive" style="margin:0 5px;" onClick=\'window.location.href = "'.get_bloginfo('url').'/?page_id='.$pageid.'"\'><img src="'.get_bloginfo('template_directory').'/images/cart.png"> '.$ecomm_title.': '.count($items).' item'.$s.'</button>';	
		
		}
	}
	
}

?>
