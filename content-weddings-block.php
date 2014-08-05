<?php
$weddings = query_posts( array(
    'category_name' => 'featured-weddings',
    'posts_per_page' => 12,
    'orderby' => 'date',
    'order' => 'DESC',
    'status' => 'publish'
) );

foreach ($weddings as $wedding) :
    $image = wp_get_attachment_image_src(
        get_post_thumbnail_id($wedding->ID), 'medium'
    );
    ?>
    <a href="<?php _e(get_permalink($wedding->ID)); ?>">
        <div class="col-6 col-sm-6 col-lg-4">

            <div class="portfolio-thumbnail">

                <?php if($image) : ?>
                    <img src="<?php _e($image[0]); ?>" width="300" class="img-thumbnail" />
                <?php else: ?>
                    <img src="holder.js/300x200/auto/#000:#7a7a7a/text:Placeholder" class="img-thumbnail" />
                <?php endif; ?>

                <div class="portfolio-overlay">
                    <div class="portfolio-overlay-title"><?php _e($wedding->post_title); ?></div>
                    <div class="portfolio-overlay-description"><?php _e($wedding->post_excerpt); ?></div>
                </div>

            </div>
        </div>
    </a>
<?php endforeach; ?>