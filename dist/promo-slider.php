<?php
$promoSliders = query_posts( array(
    'category_name' => 'promo-slider-gallery',
    'posts_per_page' => 6,
    'orderby' => 'date',
    'order' => 'DESC'
) );
?>

<section id="promo-slider-wrapper" class="container">
    <div class="promo-slider_gallery">
        <div id="slides">
            <div class="slides_container promo-slider">
                <?php
                foreach( $promoSliders as $promoSlider ) {
                    $image = wp_get_attachment_image_src(
                        get_post_thumbnail_id( $promoSlider->ID ), 'full'
                    );
                    ?>
                    <div class="promo-child-thumb">
                        <img src="<?php _e($image[0]); ?>" width="921" />
                    </div>
                <?php  } ?>
            </div>
        </div>
    </div>
</section>