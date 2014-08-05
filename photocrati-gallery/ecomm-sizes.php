<?php
define('ABSPATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/');
define('WP_USE_THEMES', false);
//define('WP_INSTALLING', true);
include_once(ABSPATH.'wp-config.php');
include_once(ABSPATH.'wp-load.php');
include_once(ABSPATH.'wp-includes/wp-db.php');
include_once(dirname(__FILE__) . '/core.php');
include_once(get_template_directory().'/photocrati-gallery/shopping-cart.php');
$upload_dir = photocrati_gallery_wp_upload_dir();
?>
<?php
    $preset             = Photocrati_Style_Manager::get_active_preset();
    $custom_logo        = $preset->custom_logo;
    $custom_logo_image  = $preset->custom_logo_image;
    $dynamic_style      = $preset->dynamic_style;

    $gall = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1", ARRAY_A);
	foreach ($gall as $key => $value) {
		$$key = $value;
	}

    $cart_settings = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."photocrati_ecommerce_settings WHERE id = 1", ARRAY_A);
	foreach ($cart_settings as $key => $value) {
		$$key = $value;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

	<!-- IMPORTANT! Do not remove this code. This is used for enabling & disabling the dynamic styling -->
		<?php if($dynamic_style) { ?>

            <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/dynamic-style.php" />

        <?php } else { ?>

            <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/styles/style.css" />

        <?php } ?>
    <!-- End dynamic styling -->

	<?php if($fs_rightclick == "ON") { ?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/clickprotect.js"></script>
	<?php } ?>

<script type="text/javascript" src="<?php echo includes_url('js/jquery/jquery.js')?>"></script>
<script type='text/javascript'>
    jQuery(function($){

        function formatCurrency(num) {
            num = isNaN(num) || num === '' || num === null ? 0.00 : num;
            return parseFloat(num).toFixed(2);
        }

        function update_cart_totals() {
            var cart_total = 0.0;
            $('.cart_item').each(function(){
               var $cart_item = $(this);
               var $quantity = parseInt($cart_item.find('.quantity_field').val());
               var $amount = parseFloat($cart_item.find('.amount_field').text());

               // Set line item total
               var total = $quantity*$amount;
               cart_total += total;
               $cart_item.find('.cart_amt .total').text(formatCurrency(total));
            });

            $('#cart_total').text(formatCurrency(cart_total));
        }

        // When the quantity changes, update the totals
        $('.quantity_field').on('change', update_cart_totals).on('keyup', update_cart_totals);

        // When the close button is clicked, close the lightbox
        $('#cancel').click(function(){
            parent.jQuery.fancybox.close();
        });

        // When the update button is clicked, update the cart on the server
        // and close the lightbox
        $('#update').click(function(e){
            e.preventDefault();
            $('#loader').show();
            var postdata = {
                nonce:  '<?php echo wp_create_nonce('update_cart_product_options')?>',
                data:   $('#cart').serialize(),
                action: 'update_cart_product_options'
            };
            var post_url = "<?php echo trailingslashit(site_url()) ?>";
            $.post(post_url, postdata, function(response){
                if (typeof(response) != 'object') response = JSON.parse(response);
                parent.jQuery.fancybox.close();
                if (typeof(response.number_of_cart_items) != 'undefined') {
                    parent.refresh_cart_widget();
                }
            });
        });
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

	jQuery("#cancel").on('click', function()
	{

		parent.jQuery.fancybox.close();

	});

	jQuery("#addto").on('click', function()
	{

		jQuery("#loader").show();

		jQuery.ajax({type: "POST", url: "<?php echo photocrati_gallery_file_uri('ecomm-add-to-cart.php'); ?>", data: 'action=add&id=<?php echo $_GET['prod_id']; ?>', success: function(data)
		{

			jQuery('[id^=qty_]').each(function()
			{

				var currentId = jQuery(this).attr('id');
				var val = jQuery(this).val();
				var total = jQuery("#line_"+currentId.substr(4)).val();
				var async = <?php echo defined('PHOTOCRATI_THEME_CART_QUANTITIES_SYNC') ? 'false' : 'true'; ?>;
				
				jQuery.ajax({type: "POST", url: "<?php echo photocrati_gallery_file_uri('ecomm-add-to-cart-quantities.php'); ?>", data: 'action=add&id=<?php echo $_GET['prod_id']; ?>&size_id='+currentId.substr(4)+'&qty='+ val +'&total='+total, async : async, success: function(data)
				{
					
				}	
				});

			});

			jQuery.ajax({type: "POST", url: "<?php echo photocrati_gallery_file_uri('ecomm-cart-widget.php'); ?>", data: '', success: function(data)
			{
				parent.jQuery('#cart_widget').html(data);
				parent.jQuery('#addto_<?php echo $_GET['prod_id']; ?>').attr("href","<?php echo photocrati_gallery_file_uri('ecomm-sizes.php'); ?>?prod_id=<?php echo $_GET['prod_id']; ?>&actions=edit&page=gallery");
				parent.jQuery.fancybox.close();
			}

			});

		}
		});

	});

	jQuery("#update").on('click', function()
	{

		jQuery("#loader").show();

		jQuery.ajax({type: "POST", url: "<?php echo photocrati_gallery_file_uri('ecomm-remove-item-cart.php'); ?>", data: 'remove_id=<?php echo $_GET['prod_id']; ?>', success: function(data)
			{

				jQuery.ajax({type: "POST", url: "<?php echo photocrati_gallery_file_uri('ecomm-add-to-cart.php'); ?>", data: 'action=add&id=<?php echo $_GET['prod_id']; ?>', success: function(data)
				{

					var ln = jQuery('[id^=qty_]').size();
					jQuery('[id^=qty_]').each(function(index)
					{
						var currentId = jQuery(this).attr('id');
						var val = jQuery(this).val();
						var total = jQuery("#line_"+currentId.substr(4)).val();
						var async = <?php echo defined('PHOTOCRATI_THEME_CART_QUANTITIES_SYNC') ? 'false' : 'true'; ?>;
				
						jQuery.ajax({type: "POST", url: "<?php echo photocrati_gallery_file_uri('ecomm-add-to-cart-quantities.php'); ?>", data: 'action=add&id=<?php echo $_GET['prod_id']; ?>&size_id='+currentId.substr(4)+'&qty='+ val +'&total='+total, async : async, success: function(data)
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
</script>
</head>

<body style="background:#ffffff;">
    <?php Photocrati_Shopping_Cart::render_add_to_cart_form($_GET['prod_id'], $ecomm_currency) ?>
</body>
</html>
