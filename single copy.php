<?php
get_header();
global $post;
$format = get_post_format();
?>

    <div id="main">
    <div class="content_blog" id="content">
    <div class="two">
    <?php if ($format != 'aside' && $format != 'video') { ?>
        <?php get_template_part('banner-slider'); ?>
        <?php wp_reset_query(); ?>
    <?php } else { ?>
        <div class="page-separator"></div>
    <?php } ?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post() ?>
            <div class="blog_wrap">
                <?php if ($format != 'aside' && $format != 'video') { ?>
                    <div class="content_navigation">
                        <?php
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
                        );
                        ?>
                        <?php wp_nav_menu($defaults); ?>
                        <div class="clr"></div>
                    </div>
                <?php } elseif ($format == 'video') { ?>
                    <div class="content_navigation">
                        <?php
                        $defaults = array(
                            'theme_location' => '',
                            'menu' => 'portfolio-navigation',
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
                        );
                        ?>
                        <?php wp_nav_menu($defaults); ?>
                        <div class="clr"></div>
                    </div>
                <?php } elseif ($format == 'aside') { ?>
                    <div class="content_navigation">
                        <?php
                        $defaults = array(
                            'theme_location' => '',
                            'menu' => 'portfolio-navigation',
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
                        );
                        ?>
                        <?php wp_nav_menu($defaults); ?>
                        <div class="clr"></div>
                    </div>
                <?php } ?>

                <div class="single_content">
                    <div class="content2 <?php echo($format == 'aside' ? 'content_aside' : ''); ?>">
                        <?php
                        if ($format != 'aside' && $format != 'video') {
                            ?>
                            <div class="post-date">
                                <span class="day"><?php the_time('d'); ?></span>
                                <span class="month"><?php the_time('M') ?></span>
                                <!--<span class="year"><?php //the_time('Y'); ?></span>-->
                            </div><!-- end post_date -->
                        <?php } ?>
                        <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

                        <div class="clr"></div>

                        <?php if ($format != 'aside' && $format != 'video') : ?>
                            <div class="single-post-header">
                                <div class="post_cats">
                                    <p><span
                                            class="post_footer_span">Categories:</span> <?php the_category(' • '); ?></span>
                                    </p>
                                </div>
                                <div class="post_tags">
                                    <?php the_tags('<p><span class="post_footer_span">Tags:</span> ', ' • ', '</p>'); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="content3">
                            <?php the_content(); ?>
                            <?php echo($format == 'video' ? "<br /><br />" : ""); ?>
                        </div>

                    </div>
                </div>
                <div class="clr"></div>
            </div>

            <?php if ($format != 'aside' && $format != 'video') : ?>
                <div>
                    <div class="single_post_connect">
                        <div class="connection">

                            <?php
                            $ctpc_options = get_option('ctpc_setting_values');
                            $facebook = $ctpc_options['facebook'];
                            $myvalue = 'Contact Us';
                            $arr = explode(' ', trim($myvalue));
                            $newValue = "<span class='contact-us-first'>" . $arr[0] . "</span> <span>" . $arr[1] . "</span>";
                            ?>

                            <div class="connect-links">
                                <a href="<?php echo get_permalink(133); ?>">
                                    <span class='connection-first-letter contact-us'>Contact</span>
                                    <span class='connection-second-letter contact-us'>Us</span>
                                </a>
                            </div>

                            <div class="connection_spacer_blog"> |</div>

                            <div class="connect-links">
                                <a href="<?php echo $facebook; ?>">
                                    <span class='connection-first-letter first-fbook'>Like us on</span>
                                    <br/>
                                    <span class='connection-second-letter second-fbook'>Facebook</span>
                                </a>
                            </div>

                            <div class="connection_spacer_blog"> |</div>

                            <div class="connect-links">
                                <a href="<?php echo get_permalink(1540); ?>">
                                    <span class='connection-first-letter first-profile'>View our</span>
                                    <br/>
                                    <span class='connection-second-letter second-profile'>Portfolio</span>
                                </a>
                            </div>

                            <div class="clear"></div>

                        </div>
                    </div>

                    <div class="clr"></div>

                    <div id="connection" class="connectionSingle">

                        <div id="fb-root"></div>
                        <script>(function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=128644630632482";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>

                        <div class="fb-like-box" data-href="https://www.facebook.com/ctaylorphotos" data-width="350"
                             data-show-faces="false" data-stream="false" data-header="true"></div>

                        <div class="post_facebook">
                            <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="true"
                                 data-layout="button_count" data-width="450" data-show-faces="true"></div>
                        </div>

                        <div class="clr"></div>

                        <?php comments_template('', true); ?>

                    </div>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>

    <?php if ($format == 'aside' || $format == 'video') { ?>
        <?php get_template_part('footer', 'aside'); ?>
    <?php } else { ?>
        <?php get_template_part('footer-single'); ?>
        <div class="pageSeperatorBottom"></div>
    <?php } ?>
    </div>
    </div>
    <div class="clr"></div>
    </div>

<?php get_footer(); ?>

    <script type="text/javascript">
        jQuery.noConflict();
        jQuery(document).ready(function () {
            jQuery('#promo-slides').slidesjs({
                width: 921,
                height: 263,
                play: {
                    active: false,
                    auto: true,
                    interval: 5000,
                    swap: true,
                    effect: 'fade'
                },
                navigation: false,
                pagination: false
            });
        });
    </script>

<?php
if ($format == 'video') {
    ?>
    <script type="text/javascript">
        var player = new MediaElementPlayer('video', {
                autoplay: true
            }
        );
        player.play();
    </script>
<?php
}
?>