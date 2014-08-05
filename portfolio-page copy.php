<?php
/**
 * Template Name: portfolio-page
 */
get_header();
global $post;
global $id;

$portraits = query_posts( array(
    'category_name' => 'featured-portraits',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC'
) );
$weddings = query_posts( array(
    'category_name' => 'featured-weddings',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC'
) );
$engagements = query_posts( array(
    'category_name' => 'featured-engagements',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC'
) );
$fusionVideos = query_posts( array(
    'category_name' => 'fusion-video',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC'
) );

function getVimeoUrl($post_id, $key) {
    $vimeoUrl = get_post_meta( $post_id, $key );
    return $vimeoUrl;
}

?>

    <div id="main">
        <div class="content_blog" id="content">
            <div class="blog_wrap">

                <div class="page-separator"></div>

                <div class="content_navigation">
                    <?php
                    $defaults = array(
                        'theme_location'  => '',
                        'menu'            => 'portfolio-navigation',
                        'container'       => 'div',
                        'container_class' => 'menu-navigation-container',
                        'container_id'    => '',
                        'menu_class'      => 'navigation-nav',
                        'menu_id'         => 'navigation-nav',
                        'echo'            => true,
                        'fallback_cb'     => 'wp_page_menu',
                        'before'          => '',
                        'after'           => '',
                        'link_before'     => '',
                        'link_after'      => '',
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => ''
                    );
                    ?>
                    <?php wp_nav_menu( $defaults ); ?>
                    <div class="clr"></div>
                </div>

                <div class="content portfolio-page">
                    <h1><?php the_title(); ?></h1>
                    <div>
                        <?php
                        echo '<div class="medium_post_wrap">';
                        switch ($post->post_name) {
                            case 'portraits':
                                foreach( $portraits as $portrait ) {
                                    $image = wp_get_attachment_image_src(
                                        get_post_thumbnail_id( $portrait->ID ), 'large'
                                    );
                                    ?>
                                    <a href="<?php _e(get_permalink($portrait->ID)); ?>">
                                        <div class="medium_post">
                                            <div class="hoverState">
                                                <img src="<?php _e($image[0]); ?>" width="300" height="200" />
                                                <div class="hiddenWrap">
                                                    <div class="hiddenText">
                                                        <span class="hiddenPostTitle"><?php _e($portrait->post_title); ?></span>
                                                        <br />
                                                        <br />
                                                        <span class="hiddenPostExcerpt"><?php _e($portrait->post_excerpt); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                }
                                echo '<div class="clr"></div>';
                                break;
                            case 'weddings':
                                foreach( $weddings as $wedding ) {
                                    $image = wp_get_attachment_image_src(
                                        get_post_thumbnail_id( $wedding->ID ), 'large'
                                    );
                                    ?>
                                    <a href="<?php _e(get_permalink($wedding->ID)); ?>">
                                        <div class="medium_post">
                                            <div class="hoverState">
                                                <img src="<?php _e($image[0]); ?>" width="300" height="200" />
                                                <div class="hiddenWrap">
                                                    <div class="hiddenText">
                                                        <span class="hiddenPostTitle"><?php _e($wedding->post_title); ?></span>
                                                        <br />
                                                        <br />
                                                        <span class="hiddenPostExcerpt"><?php _e($wedding->post_excerpt); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                }
                                echo '<div class="clr"></div>';
                                break;
                            case 'engagements':
                                foreach( $engagements as $engagement ) {
                                    $image = wp_get_attachment_image_src(
                                        get_post_thumbnail_id( $engagement->ID ), 'large'
                                    );
                                    ?>
                                    <a href="<?php _e(get_permalink($engagement->ID)); ?>">
                                        <div class="medium_post">
                                            <div class="hoverState">
                                                <img src="<?php _e($image[0]); ?>" width="300" height="200" />
                                                <div class="hiddenWrap">
                                                    <div class="hiddenText">
                                                        <span class="hiddenPostTitle"><?php _e($engagement->post_title); ?></span>
                                                        <br />
                                                        <br />
                                                        <span class="hiddenPostExcerpt"><?php _e($engagement->post_excerpt); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                }
                                echo '<div class="clr"></div>';
                                break;
                            case 'fusion-video':
                                foreach( $fusionVideos as $fusionVideo ) {
                                    $image = wp_get_attachment_image_src(
                                        get_post_thumbnail_id( $fusionVideo->ID ), 'large'
                                    );
                                    ?>
                                    <a href="<?php echo get_post_meta( $fusionVideo->ID, 'VimeoUrl', true );?>" class="fancybox">
                                        <div class="medium_post">
                                            <div class="hoverState">
                                                <img src="<?php _e($image[0]); ?>" width="300" height="200" />
                                                <div class="hiddenWrap">
                                                    <div class="hiddenText">
                                                        <span class="hiddenPostTitle"><?php _e($fusionVideo->post_title); ?></span>
                                                        <br />
                                                        <br />
                                                        <span class="hiddenPostExcerpt"><?php _e($fusionVideo->post_excerpt); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                }
                                echo '<div class="clr"></div>';
                                break;
                            default:
                                //code to be executed if n is different from both label1 and label2;
                        }
                        echo '</div>';
                        ?>
                    </div>
                </div>
            </div>

        </div><!-- content_blog -->
    </div>
    <div class="clr"></div>

<?php get_footer(); ?>

<script type="text/javascript">
    jQuery.noConflict();
    jQuery(document).ready(function() {
        /*
         *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
         */
        jQuery('.fancybox')
            //.attr('rel', 'gallery')
            .fancybox({
                openEffect : 'none',
                closeEffect : 'none',
                prevEffect : 'none',
                nextEffect : 'none',
                padding: 0,
                helpers : {
                    media : {}
                },
                width: '720px',
                height: '410px'
            });


        jQuery('.hiddenText span.hiddenPostTitle').hover(
            function() {
                jQuery(this).animate({ color: "#ED1C24" }, 'slow');
            },function() {
                jQuery(this).animate({ color: "#000" }, 'slow');
            }
        );
        jQuery('.medium_post').hover(function() {
            jQuery(this).find('.hiddenWrap')
                .css('visibility', 'visible')
                .css('position','relative')
                .css('top','-200px')
                .css('width','300px !important')
                .css('height','auto');
            jQuery(this).find('.hoverState')
//                .animate({backgroundColor: "#fff"}, 'fast')
                .css('background-color','#ffffff')
                .css('height','200px');
            jQuery(this).find('.hoverState img')
                .css('opacity','.2');
        },function(){
            jQuery(this).find('.hiddenWrap')
                .css('visibility','hidden');
            jQuery(this).find('.hoverState')
                .css('background','transparent');
            jQuery(this).find('.hoverState img')
                .css('opacity','1');
        });
    });
</script>