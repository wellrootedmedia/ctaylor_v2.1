<?php
/**
 * Template Name: portfolio
 */
get_header();
global $post;
global $id;
?>
    <div class="jumbotron">
        <?php while (have_posts()) : the_post() ?>
            <div class="row content-bg">

                <?php get_template_part('ribbon', 'portfolio-navigation'); ?>

                <div id="slides-section" class="section portfolio-slide-section">
                    <div id="portfolio-slides">
                        <?php
                        $child_pages = returnSliderChildren($post->ID);
                        if ($child_pages) :
                            foreach ($child_pages as $pageChild) :
                                setup_postdata($pageChild);
                                ?>
                                <div class="child-thumb">
                                    <a href="<?php echo get_permalink($pageChild->ID); ?>" rel="bookmark"
                                       title="<?php echo $pageChild->post_title; ?>">
                                        <?php
                                        $postThumbnail = get_the_post_thumbnail($pageChild->ID, 'full');
                                        if($postThumbnail) {
                                            echo $postThumbnail;
                                        } else {
                                            ?>
                                            <img src="holder.js/882x370/auto/#000:#7a7a7a/text:Placeholder" class="img-thumbnail" />
                                            <?php
                                        }
                                        ?>
                                        <?php echo "<h1>" . $pageChild->post_title . "</h1>"; ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="dropshadow-img">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-shadow.png" class="img-thumbnail" />
                </div>

                <?php get_template_part('footer', 'wec'); ?>

            </div>
        <?php endwhile; ?>
    </div>
<?php get_footer(); ?>