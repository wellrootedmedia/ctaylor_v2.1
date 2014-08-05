<?php 

// The Photocrati SuperTheme uses wp_nav_menu() in two locations.
if ( function_exists('register_nav_menus') ) {
register_nav_menus( 
array(
	'primary' 			=> 		__( 'Primary Navigation', 'photocrati' ),
	'footer' 			=> 		__( 'Footer Navigation (links - no dropdowns)', 'photocrati' ),
) 
);
}

// Load scripts for the jquery Superfish plugin http://users.tpg.com.au/j_birch/plugins/superfish/#examples
function thematic_head_scripts() {
    $scriptdir_start = "\t";
		$scriptdir_start .= '<script type="text/javascript" src="';
    $scriptdir_start .= get_bloginfo('template_directory');
    $scriptdir_start .= '/scripts/';
    
    $scriptdir_end = '"></script>';
    
    $scripts = "\n";
    $scripts .= $scriptdir_start . 'hoverIntent.js' . $scriptdir_end . "\n";
    $scripts .= $scriptdir_start . 'superfish.js' . $scriptdir_end . "\n";
    $scripts .= $scriptdir_start . 'supersubs.js' . $scriptdir_end . "\n";
    $dropdown_options = $scriptdir_start . 'thematic-dropdowns.js' . $scriptdir_end . "\n";
    
    $scripts = $scripts . apply_filters('thematic_dropdown_options', $dropdown_options);

		$scripts .= "\n";
		$scripts .= "\t";
		$scripts .= '<script type="text/javascript">' . "\n";
		$scripts .= "\t\t";
		$scripts .= 'jQuery.noConflict();' . "\n";
		$scripts .= "\t";
		$scripts .= '</script>' . "\n";

    // Print filtered scripts
    print apply_filters('thematic_head_scripts', $scripts);

}
add_action('wp_head','thematic_head_scripts');


function photocrati_theme_menu_fallback_create($args)
{
	$args['echo'] = false;
	$args['menu_class'] = 'menu';
	
	$menu = wp_page_menu($args);
	
	echo preg_replace('/<ul>/', '<ul class="sf-menu">', $menu, 1);
}

?>
