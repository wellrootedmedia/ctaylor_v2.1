<?php
get_header();
global $post;
$postFormat = get_post_format();
$contentClassName = ($postFormat == "aside" || $postFormat == "video" ? "content_aside" : "content-bg");
?>

    <div class="jumbotron">
        <div class="row">
            <div class="container single-item">

                <?php while ( have_posts() ) : the_post(); ?>

                    <div class="content-bg">

                        <?php if($postFormat == 'aside') : ?>

                            <?php get_template_part('ribbon', 'portfolio-navigation'); ?>

                            <div class="col-md-10">
                                <h1 class="single-title"><?php the_title(); ?></h1>
                            </div>

                        <?php else: ?>

                            <?php get_template_part('banner-slider'); ?>

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

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="post-date single-date">
                                        <span class="day"><?php the_time('d'); ?> <?php the_time('M') ?></span>
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <h1 class="single-title"><?php the_title(); ?></h1>
                                </div>
                            </div>

                            <div class="row single-post-header small-caps">
                                <div class="col-md-6">
                                    <p>
                                        <span class="post_footer_span"><?php _e('Categories:'); ?> </span><?php the_category(' • '); ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        <span class="post_footer_span"><?php _e('Tags:'); ?> </span><?php the_tags('', ' • ', ''); ?>
                                    </p>
                                </div>
                            </div>

                            <?php
                            $image = wp_get_attachment_image_src(
                                get_post_thumbnail_id($post->ID), 'large'
                            );
                            if($image) : ?>
                            <div class="row text-center show-grid">
                                <div class="col-md-12">
                                    <img src="<?php echo $image[0]; ?>" class="img-thumbnail" />
                                </div>
                            </div>
                            <?php endif; ?>

                        <?php endif; ?>

                        <div class="col-md-12">
                            <?php the_content(); ?>
                        </div>


                        <?php
                        if($postFormat == 'aside') {
                            get_template_part('footer', 'aside');
                        } else {
                            get_template_part('footer','single');
                        }
                        ?>

                    </div>

                <?php endwhile; ?>

            </div>
        </div>
    </div>

<?php get_footer(); ?>