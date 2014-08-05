<?php
$obj = new FooterContactPageImage();
$aboutId = $obj->about()->ID;
$aboutTitle = $obj->about()->post_title;
$contactId = $obj->contact()->ID;
$contactTitle = $obj->contact()->post_title;
$portfolioId = $obj->portfolio()->ID;
$portfolioTitle = $obj->portfolio()->post_title;
?>
<div class="footer-ribbon container aggregate">
    <div class="blue-ribbon"></div>
    <div class="row">
        <div class="col-md-4">
            <div><a href="<?php echo get_permalink($aboutId); ?>"><?php _e($aboutTitle); ?></a></div>
            <div class="connection-image">
                <?php
                $imageAttachment = wp_get_attachment_image_src(
                    get_post_thumbnail_id($aboutId), 'medium'
                );
                echo '<a href="' . get_permalink($aboutId) . '"><img src="' . $imageAttachment[0] . '" width="264" width="264" class="img-thumbnail" /></a>';
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div><a href="<?php echo get_permalink($contactId); ?>"><?php _e($contactTitle); ?></a></div>
            <div class="connection-image">
                <?php
                $imageAttachment = wp_get_attachment_image_src(
                    get_post_thumbnail_id($contactId), 'medium'
                );
                echo '<a href="' . get_permalink($contactId) . '"><img src="' . $imageAttachment[0] . '" width="264" width="264" class="img-thumbnail" /></a>';
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div><a href="<?php echo get_permalink($portfolioId); ?>"><?php _e($portfolioTitle); ?></a></div>
            <div class="connection-image">
                <?php
                $imageAttachment = wp_get_attachment_image_src(
                    get_post_thumbnail_id($portfolioId), 'medium'
                );
                echo '<a href="' . get_permalink($portfolioId) . '"><img src="' . $imageAttachment[0] . '" width="264" width="264" class="img-thumbnail" /></a>';
                ?>
            </div>
        </div>
    </div>
</div>
<?php wp_reset_postdata(); ?>