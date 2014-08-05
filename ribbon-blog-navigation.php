

<div class="blue-ribbon portfolio-ribbon blog">
    <?php wp_reset_query();
    $defaults = array(
        'theme_location' => '',
        'menu' => 'blog-navigation',
        'container' => 'div',
        'container_class' => 'menu-navigation-container',
        'container_id' => '',
        'menu_class' => 'navigation-nav',
        'menu_id' => 'navigation-nav',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth' => 0,
        'walker' => ''
    ); wp_nav_menu($defaults); wp_reset_query(); ?>
</div>

<div class="device-navigation">
    <?php wp_reset_query();
    $defaults = array(
        'theme_location' => '',
        'menu' => 'blog-navigation',
        'container' => 'div',
        'container_class' => 'menu-navigation-container',
        'container_id' => '',
        'menu_class' => 'navigation-nav',
        'menu_id' => 'navigation-nav',
        'echo' => true,
        'fallback_cb' => 'wp_page_menu',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth' => 0,
        'walker' => ''
    ); wp_nav_menu($defaults); wp_reset_query(); ?>
</div>