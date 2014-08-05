<?php
define('ABSPATH', dirname(dirname(dirname(dirname(__FILE__)))).'/');
define('WP_USE_THEMES', false);
define('WP_INSTALLING', true);
include_once(ABSPATH . 'wp-config.php');
include_once(ABSPATH.'wp-load.php');
include_once(ABSPATH.'wp-includes/wp-db.php');
?>
<?php
	/* IMPORTANT! This code retrieves the custom logo options & dynamic styling */
	global $wpdb;
	$style = $wpdb->get_results("SELECT custom_logo,custom_logo_image,dynamic_style FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1");
	foreach ($style as $style) {
		$custom_logo = $style->custom_logo;
		$custom_logo_image = $style->custom_logo_image;
		$dynamic_style =  $style->dynamic_style;
	}
	
    $gall = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1", ARRAY_A);
	foreach ($gall as $key => $value) {
		$$key = $value;
	}
	
    $cart = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_ecommerce_settings WHERE id = 1", ARRAY_A);
	foreach ($cart as $key => $value) {
		$$key = $value;
	}
	
    $gal_item = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_galleries WHERE id = ".$_GET['prod_id'], ARRAY_A);
	foreach ($gal_item as $key => $value) {
		$$key = $value;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	
	<!-- IMPORTANT! Do not remove this code. This is used for enabling & disabling the dynamic styling -->
		<?php if($dynamic_style == 'YES') { ?>
        
            <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/dynamic-style.php" />
            
        <?php } else { ?>
        
            <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/style.css" />
        
        <?php } ?>
    <!-- End dynamic styling -->
	
	<?php if($fs_rightclick == "ON") { ?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/clickprotect.js"></script>
	<?php } ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js?ver=3.0"></script>

<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function()
{
	
	jQuery('[id^=qty_]').keyup(function (event) { 
		m_strOut = jQuery(this).val().replace(/[^0-9]/g, '');
		jQuery(this).val(m_strOut);
	});
	
	<?php if($_GET['actions']) { ?>
	
	jQuery('[id^=qty_]').each(function()
	{
		var currentId3 = jQuery(this).attr('id');
		var qty2 = jQuery(this).val();
		var amt2 = jQuery("#amt_"+currentId3.substr(4)).val();
		var ttl2 = qty2*amt2;
		var gttl2 = parseFloat(0.00);
		jQuery("#line_"+currentId3.substr(4)).val(ttl2.toFixed(2));
		
		jQuery('[id^=qty_]').each(function()
		{
			
			var currentId4 = jQuery(this).attr('id');
			gttl2 = gttl2 + parseFloat(jQuery("#line_"+currentId4.substr(4)).val());
			
		});
		
		jQuery("#cart_total").val(gttl2.toFixed(2));
		
	});
	
	<?php } ?>
	
	jQuery('[id^=qty_]').change(function()
	{
		
		var currentId = jQuery(this).attr('id');
		var qty = jQuery(this).val();
		var amt = jQuery("#amt_"+currentId.substr(4)).val();
		var ttl = qty*amt;
		var gttl = parseFloat(0.00);
		jQuery("#line_"+currentId.substr(4)).val(ttl.toFixed(2));
		
		jQuery('[id^=qty_]').each(function()
		{
			
			var currentId2 = jQuery(this).attr('id');
			gttl = gttl + parseFloat(jQuery("#line_"+currentId2.substr(4)).val());
			
		});
		
		jQuery("#cart_total").val(gttl.toFixed(2));
		
	});
	
	jQuery("#cancel").click(function()
	{
		
		parent.jQuery.fancybox.close();
		
	});	
	
	jQuery("#addto").click(function()
	{
		
		jQuery("#loader").show();
		
		jQuery.ajax({type: "POST", url: "<?php bloginfo('template_directory'); ?>/ecomm-add-to-cart.php", data: 'action=add&id=<?php echo $_GET['prod_id']; ?>', success: function(data)
		{
		
			jQuery('[id^=qty_]').each(function()
			{
				
				var currentId = jQuery(this).attr('id');
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_directory'); ?>/ecomm-add-to-cart-quantities.php", data: 'action=add&id=<?php echo $_GET['prod_id']; ?>&size_id='+currentId.substr(4)+'&qty='+jQuery(this).val()+'&total='+jQuery("#line_"+currentId.substr(4)).val(), success: function(data)
				{
					
				}	
				});
				
			});
		
			jQuery.ajax({type: "POST", url: "<?php bloginfo('template_directory'); ?>/ecomm-cart-widget.php", data: '', success: function(data)
			{
				parent.jQuery('#cart_widget').html(data);
				parent.jQuery('#addto_<?php echo $_GET['prod_id']; ?>').attr("href","<?php bloginfo('template_directory'); ?>/ecomm-sizes.php?prod_id=<?php echo $_GET['prod_id']; ?>&actions=edit&page=gallery");
				parent.jQuery.fancybox.close();
			}
		
			});
			
		}	
		});
		
	});	
	
	jQuery("#update").click(function()
	{
		
		jQuery("#loader").show();
		
		jQuery.ajax({type: "POST", url: "<?php bloginfo('template_directory'); ?>/ecomm-remove-item-cart.php", data: 'remove_id=<?php echo $_GET['prod_id']; ?>', success: function(data)
			{
		
				jQuery.ajax({type: "POST", url: "<?php bloginfo('template_directory'); ?>/ecomm-add-to-cart.php", data: 'action=add&id=<?php echo $_GET['prod_id']; ?>', success: function(data)
				{
				
					var ln = jQuery('[id^=qty_]').size();
					jQuery('[id^=qty_]').each(function(index)
					{
						
						var currentId = jQuery(this).attr('id');
						jQuery.ajax({type: "POST", url: "<?php bloginfo('template_directory'); ?>/ecomm-add-to-cart-quantities.php", data: 'action=add&id=<?php echo $_GET['prod_id']; ?>&size_id='+currentId.substr(4)+'&qty='+jQuery(this).val()+'&total='+jQuery("#line_"+currentId.substr(4)).val(), success: function(data)
						{
						
							var ln2 = ln - 1;
							if (index==ln2) {
								parent.jQuery.fancybox.close();
								<?php if(!$_GET["page"]) { ?>
								parent.location.reload();
								<?php } ?>
							}
							
						}	
						});
						
					});
					
				}	
				});
				
			}	
		});
		
	});	
	
});
</script>
	
</head>

<body style="background:#ffffff;">
	
	<div id="cart_wrapper">
	
		<h1 class="cart_header">
			<?php if($_GET['actions']) { ?>
				Edit Quantities
			<?php } else { ?>
				Add To <?php echo $ecomm_title; ?>
			<?php } ?>
		</h1>
		
		<div class="cart_image">
		
			<img src="<?php echo get_bloginfo('template_url'); ?>/galleries/post-<?php echo $post_id; ?>/thumbnails/<?php echo str_replace("%","%25",$image_name); ?>">
		
		</div>
		
		<div class="cart_data">
			
			<p><strong>Select the quantity of each print size:</strong></p>
			
			<div class="cart_qty titles"><b>Qty</b></div>
							
			<div class="cart_desc titles"><b>Description</b></div>
							
			<div class="cart_amt titles"><b>Price</b></div>
							
			<div class="cart_line titles"><b>Totals</b></div>
					
			<div class="clear"></div>
			
			<?php
			
			if(
				$ecomm_currency == "USD" ||
				$ecomm_currency == "CAD" ||
				$ecomm_currency == "AUD" ||
				$ecomm_currency == "NZD" ||
				$ecomm_currency == "HKD" ||
				$ecomm_currency == "SGD"
			) {
				$curr = "$";
			} else if($ecomm_currency == "EUR") {
				$curr = "&euro;";
			} else if($ecomm_currency == "GBP") {
				$curr = "&pound;";
			} else if($ecomm_currency == "JPY") {
				$curr = "&yen;";
			}
			
			if($_GET['actions']) {
			?>
			
			<?php
			
			$qty = explode(",", $_SESSION['cart_qty']);
			
			foreach ($qty as $cart_items) {
				$item = explode("|", $cart_items);
				if($item[0] == $_GET['prod_id']) {
					
					$id = $item[1];	
					${"qty_$id"} = $item[2];
					
				}
			}
					
			?>
			
			<?php } ?>
			
			<?php
			$l = 1;
			while($l < 13) {
			?>
			
				<?php if(${"ecomm_op$l"}) { ?>
					
					<div class="cart_qty">
						
						<input type="text" id="qty_<?php echo $l; ?>" name="qty_<?php echo $l; ?>" value="<?php if(${"qty_$l"}) { echo ${"qty_$l"}; } else { echo '0'; } ?>">
						<input type="hidden" id="amt_<?php echo $l; ?>" value="<?php echo ${"ecomm_cost$l"}; ?>">
						
					</div>
							
					<div class="cart_desc">
						
						<?php echo ${"ecomm_op$l"}; ?>
						
					</div>
							
					<div class="cart_amt">
						
						<?php echo $curr.${"ecomm_cost$l"}; ?>
						
					</div>
							
					<div class="cart_line">
						
						<?php echo $curr; ?><input type="text" id="line_<?php echo $l; ?>" name="line_<?php echo $l; ?>" value="0.00" readonly>
						
					</div>
					
					<div class="clear cart_clear"></div>
				
				<?php } ?>
			
			<?php
			$l = $l + 1;
			}
			?>
			
			<div class="cart_total">TOTAL:</div>
			
			<div class="cart_total_amount">
				
				<?php
				echo $curr."<input id='cart_total' name='cart_total' value='0.00' readonly>";
				?>
				
			</div>
					
			<div class="clear buttons_clear"></div>
			
			<div class="addto">
				
				<button id="cancel" class="positive" style="margin:0 5px;">
					Cancel
				</button>
				
				<button class="addto" <?php if($_GET['actions']) { echo 'id="update"'; } else { echo 'id="addto"'; } ?> class="positive" style="margin:0 5px;">
					<?php if($_GET['actions']) { ?>
						Update
					<?php } else { ?>
						<?php echo $ecomm_but_text; ?>
					<?php } ?>
				</button>
				
				<img id="loader" src="<?php echo get_bloginfo('template_url'); ?>/admin/images/ajax-loader.gif" style="display:none;padding-top:3px;margin:0 30px 0 0;">
				
			</div>
			
		</div>
	
	</div>

</body>
</html>
