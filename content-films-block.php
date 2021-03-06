<?php
$films = query_posts( array(
    'category_name' => 'featured-films',
    'posts_per_page' => 12,
    'orderby' => 'date',
    'order' => 'DESC',
    'status' => 'publish'
) );

foreach ($films as $film) :
    $image = wp_get_attachment_image_src(
        get_post_thumbnail_id($film->ID), 'medium'
    );
    ?>
    <a href="<?php echo get_post_meta( $film->ID, 'VimeoUrl', true );?>" class="fancybox">
        <div class="col-6 col-sm-6 col-lg-4">

            <div class="portfolio-thumbnail">

                <?php if($image) : ?>
                    <img src="<?php _e($image[0]); ?>" class="img-thumbnail" />
                <?php else: ?>
                    <img src="holder.js/300x200/auto/#000:#7a7a7a/text:Placeholder" class="img-thumbnail" />
                <?php endif; ?>

                <div class="portfolio-overlay">
                    <div class="portfolio-overlay-title"><?php _e($film->post_title); ?></div>
                    <div class="portfolio-overlay-description"><?php _e($film->post_excerpt); ?></div>
                </div>

            </div>
        </div>
    </a>
<?php endforeach; ?>
