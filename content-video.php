<div class="row">

    <?php while ( have_posts() ) : the_post() ?>
        <div class="single_content">
            <div class="content_aside">

                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

                <div class="col-md-12">
                    <?php the_content(); ?>
                    <br/><br/>
                </div>

            </div>
        </div>
    <?php endwhile; ?>

</div>