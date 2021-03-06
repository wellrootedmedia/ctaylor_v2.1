﻿<?php
get_header();
global $post;
?>

    <div class="jumbotron">

        <div class="content-bg">

            <div class="blue-ribbon portfolio-ribbon category">
                <h1 class="clients-title">Search Results for: "<?php the_search_query(); ?>"</h1>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="container">
                        <?php
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $args = array (
                            's' => $s,
                            'cat' => -474,
                            'posts_per_page' => 8,
                            'order' => 'DESC',
                            'paged' => $paged
                        );
                        $the_query = new WP_Query( $args );
                        $count = 0;

                        if ( $the_query->have_posts() ) :
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                $count++;
                                ?>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="post-date">
                                            <span class="day"><?php the_time('d'); ?> <?php the_time('M') ?></span>
                                        </div>
                                    </div>

                                    <div class="col-md-10">
                                        <h1 class="aggregate-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
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

                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="<?php echo get_permalink($post->ID); ?>">
                                            <?php
                                            $image = wp_get_attachment_image_src(
                                                get_post_thumbnail_id($post->ID), 'medium'
                                            );
                                            if($image) :
                                                ?>
                                                <img src="<?php echo $image[0]; ?>" width="500" class="img-thumbnail" />
                                            <?php else: ?>
                                                <img src="holder.js/225x153/auto/#000:#7a7a7a/text:Placeholder" width="264" class="img-thumbnail" />
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="col-md-6 small-caps">
                                        <?php the_excerpt(); ?>
                                    </div>
                                </div>

                                <div class="single-post-facebook">
                                    <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="true"
                                         data-layout="button_count" data-width="450" data-show-faces="true"></div>
                                </div>

                                <div class="<?php echo($count < $the_query->post_count ? "blue-ribbon category-list" : ""); ?>"></div>

                            <?php endwhile; wp_reset_postdata(); endif; ?>

                        <?php get_template_part('footer', 'acp'); ?>
                        <?php get_template_part('footer', 'paginate'); ?>

                    </div>

                </div>

            </div>
        </div>
    </div>

<?php get_footer(); ?>