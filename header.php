<?php
$preset = Photocrati_Style_Manager::get_active_preset();
extract($preset->to_array());

$rcp = $wpdb->get_results("SELECT fs_rightclick,lightbox_mode,lightbox_type FROM ".$wpdb->prefix."photocrati_gallery_settings WHERE id = 1");
foreach ($rcp as $rcp) {
    $fs_rightclick = $rcp->fs_rightclick;
    $lightbox_mode = $rcp->lightbox_mode;
    $lightbox_type = $rcp->lightbox_type;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 9 ]> <html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> class='ie9'><!--<![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>><!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">
    <?php
    Photocrati_Fonts::render_google_font_link(array(
        array($font_style, $font_weight, $font_italic),
        array($sidebar_font_style, $sidebar_font_weight, $sidebar_font_italic),
        array($sidebar_title_style, $sidebar_title_weight, $sidebar_title_italic),
        array($title_style, $title_font_weight, $title_italic),
        array($h1_font_style, $h1_font_weight, $h1_font_italic),
        array($h2_font_style, $h2_font_weight, $h2_font_italic),
        array($h3_font_style, $h3_font_weight, $h3_font_italic),
        array($h4_font_style, $h4_font_weight, $h4_font_italic),
        array($h5_font_style, $h5_font_weight, $h5_font_italic),
        array($description_style, $description_font_weight, $description_font_italic),
        array($menu_font_style, $menu_font_weight, $menu_font_italic),
        array($submenu_font_style, $submenu_font_weight, $submenu_font_italic),
        array($footer_widget_style, $footer_widget_weight, $footer_widget_italic),
        array($footer_font_style, $footer_font_weight, $footer_font_italic)
    ));
    ?>
    <title><?php
        if ( is_single() ) { single_post_title(); }
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); get_page_number(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); get_page_number(); }
        ?></title>

    <meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- IMPORTANT! Do not remove this code. This is used for enabling & disabling the dynamic styling -->
    <?php if($dynamic_style) { ?>

        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/styles/dynamic-style.php" />
        <?php if($logo_menu_position == 'left-right') { ?>
            <!--[if lt IE 8]>
            <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/styles/style-ie7-menufix.css" type="text/css" />
            <![endif]-->
        <?php } ?>

    <?php } else { ?>

        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" />

        <?php if($logo_menu_position == 'left-right') { ?>
            <!--[if lt IE 8]>
            <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/styles/style-ie7-menufix.css" type="text/css" />
            <![endif]-->
        <?php } ?>

    <?php } ?>
    <!-- End dynamic styling -->

    <!--[if IE 8]>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/styles/style-ie.css" type="text/css" />
    <![endif]-->

    <!--[if lt IE 8]>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/styles/style-ie7.css" type="text/css" />
    <![endif]-->

    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

    <?php
    if( !is_admin()){
        wp_enqueue_script('jquery');
        if ($preset->custom_js) wp_enqueue_script('photocrati-custom-js', site_url('?photocrati-js'));
    }
    ?>

    <?php wp_head(); ?>

    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'photocrati-framework' ), esc_html( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'photocrati-framework' ), esc_html( get_bloginfo('name'), 1 ) ); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <script type="text/javascript">
        function updateUnit() {
            var amount = document.getElementById("amount");
            var str = amount.value;
            var n = str.indexOf("$");
            var newAmount = (n == -1) ? "$" + amount.value : amount.value;

            var itemName = document.getElementById("item_name");
            var itemNumber = document.getElementById("item_number");
            itemNumber.value = (itemName.value != "") ? itemName.value + ' - ' + newAmount : newAmount;
        }
    </script>

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/jquery-ui.min.css" />
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/navbar-static-top.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/dist/css/supersized.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/dist/css/supersized.shutter.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/dist/css/custom.css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/dist/css/media.query.css" rel="stylesheet">

    <?php
    $pageTitle = get_the_title();
    switch ($pageTitle) {
        case "Contact Us":
            echo '<link href="' . get_stylesheet_directory_uri() . '/dist/css/contact-page.css" rel="stylesheet">';
            break;
        case "About Us":
            echo '<link href="' . get_stylesheet_directory_uri() . '/dist/css/about-page.css" rel="stylesheet">';
            break;
    }
    ?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div id="<?php echo (is_front_page()) ? "wrap" : ""; ?>">
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-static-top">
        <div class="navbar-inner">
            <div class="container">

                <div class="navbar-header">
                    <section class="navbar-menu-display"></section>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="row">
                    <?php
                    $walker = new Menu_With_Description;
                    wp_nav_menu( array(
                        'theme_location' => '',
                        'menu' => 'Menu Main Nav',
                        'container' => 'div',
                        'container_class' => 'navbar-collapse collapse',
                        'container_id' => '',
                        'menu_class' => 'nav navbar-nav',
                        'menu_id' => '',
                        'echo' => true,
                        'fallback_cb' => 'wp_page_menu',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth' => 0,
                        'walker' => $walker
                    ) ); ?>
                    <div class="navbar-logo">
                        <a href="<?php bloginfo('url'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo-black.png" width="300" /></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container">