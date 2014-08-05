<?php
/*
* Template Name: homepage
*/
get_header();
?>

<style type="text/css">
    html, body {
        height: 100%;
    }
    #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        margin: 0 auto -60px;
        padding: 0 0 60px;
    }
    .site-bg {
        position: absolute;
        z-index: -100;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
    }
    .intro-video {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        z-index: -100;
        background-size: cover;
        opacity: 0.7;
    }
    .static-img {
        display:none;
        z-index:4;
        width:100%;
        height:100%;
        margin:0;
        padding:0;
        background-repeat: no-repeat;
        background-position: center center;
        background-attachment: fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    #footer {
        height: 60px;
        background-color: transparent;
    }
    #footer > .container {
        padding-left: 15px;
        padding-right: 15px;
    }
</style>

<div class="site-bg">
    <video autoplay class="intro-video">
        <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/video/promo-home-video.webm" type="video/webm">
        <source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/video/promo-home-video.mp4" type="video/mp4">
    </video>
    <section class="static-img"></section>
</div>

<?php get_footer(); ?>