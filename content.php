<div class="row content-bg">
    <?php while ( have_posts() ) : the_post() ?>
        <div class="container">
            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <div class="col-md-12">
                <?php the_content(); ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>