<?php
/**
 * Template Name: contact us
 */
get_header();
?>

<div class="jumbotron">
    <div class="row content-bg">
        <?php while (have_posts()) : the_post() ?>
            <div class="content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
