<?php
    define('ABSPATH', dirname(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))))).'/');
	include_once(ABSPATH . 'wp-config.php');
	include_once(ABSPATH.'wp-load.php');
	include_once(ABSPATH.'wp-includes/wp-db.php');
	
	@header( 'Content-type: text/css' ); 
	
	global $wpdb;
	
	global $shortname;
	$settings = get_option($shortname.'_options');
	// Options are called like this $settings['option_id'];
	
	$style = $wpdb->get_row("SELECT container_padding,container_border FROM ".$wpdb->prefix."photocrati_styles WHERE option_set = 1", ARRAY_A);
	foreach ($style as $key => $value) {
		$$key = $value;
	}
	$thumbsblock = 120;
	$height = round((800 * .664) + $thumbsblock).'px!important';
    $width = round(((960 - ((int)$container_padding * 2) - ((int)$container_border * 2)) * .664) + $thumbsblock);
?>

.galleria-container{
		position			:	relative;
		overflow			:	hidden;
		max-width			:	800px;
		border				:	0px solid #666;
		margin				:	0 auto;
}

.galleria-container img{
		-moz-user-select	:	none;
		-webkit-user-select	:	none;
		-o-user-select		:	none;
		width				:	100%!important;
}

.galleria-stage {
		position			:	absolute;
		top					:	0px;
		left				:	0px;
		right				:	0px;
		overflow			:	hidden;
}

.galleria-thumbnails-container {
		height				:	90px;
		margin				:	0 auto;
		bottom				:	0;
		position			:	absolute;
		left				:	0px;
		right				:	0px;
		z-index				:	2;
		text-align			:	center;
		border-top			:	0px solid #666;
}

.galleria-carousel {
		padding				:	10px 0 20px 0;
}

.galleria-carousel .galleria-thumbnails-list {
		margin-left			:	0px;
		margin-right		:	0px;
}

.galleria-thumbnails .galleria-image {
		height				:	75px;
		width				:	110px;
		background			:	#fff;
		margin				:	0 5px 0 0;
		cursor				:	pointer;
		display				: 	-moz-inline-stack;
		display				:	inline-block;
		float				:	none;
		zoom				: 	1;
		*display			: 	inline;
		vertical-align		: 	top;
		_height				: 	85px;
		_width				: 	110px;
		clear				:	none;
}

.galleria-counter {
		position			:	absolute;
		bottom				:	25px;
		left				:	15px;
		text-align			:	right;
		color				:	#333;
		font				:	normal 11px/1 arial,sans-serif;
		background			:	#FFF;
		z-index				:	5;
		padding				:	3px;
}

.galleria-loader {
		background			:	#fff;
		width				:	50px;
		height				:	50px;
		position			:	absolute;
		top					:	50%;
		left				:	50%;
		margin-left			:	-25px;
		margin-top			:	-25px;
		z-index				:	2;
		display				:	none;
		background			:	url(gallery-ajax-loader.gif) no-repeat 2px 2px;
}

.galleria-info {
		width				:	50%;
		top					:	15px;
		left				:	15px;
		z-index				:	2;
		position			:	absolute;
}

.galleria-info-text {
		background-color	:	rgba(0,0,0,.9);
		*background-color	:	#fff;
		padding				: 	12px;
		display				:	none;
}

.galleria-info-title {
		font				:	bold 12px/1.1 arial,sans-serif;
		margin				:	0;
		color				:	#fff;
}

.galleria-info-description {
		font				:	italic 12px/1.4 georgia,serif;
		margin				:	0;
		color				:	#bbb;
}

.galleria-info-title+.galleria-info-description {
		margin-top			:	7px;
}

.galleria-info-close {
		width				:	9px;
		height				:	9px;
		position			:	absolute;
		top					:	5px;
		right				:	5px;
		background-position	:	-753px -11px;
		opacity				:	.5;
		filter				:	alpha(opacity=50);
		cursor				:	pointer;
		display				:	none;
}

.galleria-info-link {
		background-position	:	-669px -5px;
		opacity				:	.8;
		filter				:	alpha(opacity=80);
		position			:	absolute;
		width				:	20px;
		height				:	20px;
		cursor				:	pointer;
		background-color	:	#fff;
}

.galleria-info-link:hover,
.galleria-info-close:hover {
		opacity				:	.5;
		filter				:	alpha(opacity=50);
}

.galleria-image-nav {
		position			:	absolute;
		top					:	50%;
		margin-top			:	-15px;
		width				:	100%;
		height				:	31px;
		left				:	0;
}

.galleria-image-nav-left,
.galleria-image-nav-right {
		opacity				:	.5;
		cursor				:	pointer;
		width				:	16px;
		height				:	31px;
		position			:	absolute;
		left				:	20px;
		z-index				:	2;
}

.galleria-image-nav-right {
		left				:	auto;
		right				:	20px;
		background-position	:	-300px 0;
		z-index				:	2;
}

.galleria-image-nav-left:hover,
.galleria-image-nav-right:hover {
		opacity				:	.9;
}

.galleria-thumb-nav-left,
.galleria-thumb-nav-right {
		cursor				:	pointer;
		display				:	none;
		background-position	:	-495px 5px;
		position			:	absolute;
		left				:	0;
		top					:	85px;
		height				:	40px;
		width				:	23px;
		z-index				:	3;
		opacity				:	.8;
		filter				:	alpha(opacity=80);
}

.galleria-thumb-nav-right{
		background-position	:	-578px 5px;
		border-right		:	none;
		right				:	0;
		left				:	40px;
}

.galleria-thumbnails-container .disabled,
.galleria-thumbnails-container .disabled:hover {
		opacity				:	.2;
		filter				:	alpha(opacity=20);
		cursor				:	default;
}

.galleria-thumb-nav-left:hover,
.galleria-thumb-nav-right:hover {
		opacity				:	1;
		filter				:	alpha(opacity=100);
}

.galleria-carousel .galleria-thumb-nav-left,
.galleria-carousel .galleria-thumb-nav-right {
		display				:	block;
}

.galleria-thumb-nav-left,
.galleria-thumb-nav-right,
.galleria-info-link,
.galleria-info-close,
.galleria-image-nav-left,
.galleria-image-nav-right{
		background-image	:	url(../vertical/classic-map.png);
		background-repeat	:	no-repeat;
}