<?php
/**
 * Template Name: about page
 */
get_header(); ?>
<div class="row">
    <?php while ( have_posts() ) : the_post() ?>
        <div class="container">
            <div class="jumbotron">

                <div class="about-page-wrap">
                    <div class="about-page-video">
                        <div class="iframe-wrapper">
                            <iframe src="//player.vimeo.com/video/94236959?title=0&amp;byline=0&amp;portrait=0" width="500"
                                    height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                        </div>
                        <div class="about-page-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <div class="clear"></div>
                </div>

            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>