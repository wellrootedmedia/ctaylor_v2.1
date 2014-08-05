<?php get_header(); ?>

    <div class="jumbotron">
        <div class="content-bg">

            <?php get_template_part('ribbon', 'portfolio-navigation'); ?>

            <div class="page-navigation-container">
                <h1 class="clients-title"><?php the_title(); ?></h1>
            </div>

            <div class="content">
                <?php
                $relatedPosts = query_posts( array( 'posts_per_page' => 6, 'orderby' => 'date', 'order' => 'DESC', 'category_name' => 'blog' ) );
                foreach( $relatedPosts as $relatedPost ) {
                    $image = wp_get_attachment_image_src(
                        get_post_thumbnail_id( $relatedPost->ID ), 'large'
                    );
                    if($image) :
                    ?>
                        <a href="<?php _e(get_permalink($relatedPost->ID)); ?>">
                            <div class="col-6 col-sm-6 col-lg-4">
                                <div class="portfolio-thumbnail">
                                    <?php if($image) : ?>
                                        <img src="<?php _e($image[0]); ?>" width="300" class="img-thumbnail" />
                                    <?php else: ?>
                                        <img src="holder.js/300x200/auto/#000:#7a7a7a/text:Placeholder" class="img-thumbnail" />
                                    <?php endif; ?>
                                    <div class="portfolio-overlay">
                                        <div class="portfolio-overlay-title"><?php _e($relatedPost->post_title); ?></div>
                                        <div class="portfolio-overlay-description"><?php _e($relatedPost->post_excerpt); ?></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php
                    endif;
                }
                ?>
            </div>

            <div class="clear"></div>


            <?php get_template_part('footer', 'wec'); ?>

        </div>
    </div>

<?php get_footer(); ?>