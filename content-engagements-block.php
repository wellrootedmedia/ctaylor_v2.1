<?php
$engagements = query_posts( array(
    'category_name' => 'featured-engagements',
    'posts_per_page' => 12,
    'orderby' => 'date',
    'order' => 'DESC',
    'status' => 'publish'
) );

foreach ($engagements as $engagement) :
    $image = wp_get_attachment_image_src(
        get_post_thumbnail_id($engagement->ID), 'medium'
    );
    ?>
    <a href="<?php _e(get_permalink($engagement->ID)); ?>">
        <div class="col-6 col-sm-6 col-lg-4">

            <div class="portfolio-thumbnail">

                <?php if($image) : ?>
                    <img src="<?php _e($image[0]); ?>" class="img-thumbnail" width="300" />
                <?php else: ?>
                    <img src="holder.js/300x200/auto/#000:#7a7a7a/text:Placeholder" class="img-thumbnail" />
                <?php endif; ?>

                <div class="portfolio-overlay">
                    <div class="portfolio-overlay-title"><?php _e($engagement->post_title); ?></div>
                    <div class="portfolio-overlay-description"><?php _e($engagement->post_excerpt); ?></div>
                </div>

            </div>
        </div>
    </a>
<?php endforeach; ?>