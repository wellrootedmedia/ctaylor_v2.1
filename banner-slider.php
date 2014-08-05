<?php
$promoSliders = query_posts(array(
    'category_name' => 'promo-slider-gallery',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC'
));
?>

<div class="row">
    <div class="col-md-12">
        <div id="slides-section" class="section banner-slide-section">
            <div id="category-blog-slides">
                <?php
                foreach ($promoSliders as $promoSlider) {
                    $image = wp_get_attachment_image_src(
                        get_post_thumbnail_id($promoSlider->ID), 'full'
                    );
                    ?>
                    <div class="promo-child-thumb">
                        <?php if($image) : ?>
                            <img src="<?php _e($image[0]); ?>" width="921" class="img-thumbnail" />
                        <?php else: ?>
                            <img src="holder.js/921x263/auto/#000:#7a7a7a/text:Placeholder" class="img-thumbnail" />
                        <?php endif; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="dropshadow-img">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-shadow.png" class="img-thumbnail" />
        </div>
    </div>
</div>

<?php wp_reset_postdata(); ?>