<?php
$obj = new FooterContactPageImage();
$weddingsId = $obj->weddings()->ID;
$weddingsTitle = $obj->weddings()->post_title;
$engagementsId = $obj->engagements()->ID;
$engagementsTitle = $obj->engagements()->post_title;
$contactId = $obj->contact()->ID;
$contactTitle = $obj->contact()->post_title;
?>
<div class="footer-ribbon container">
    <div class="blue-ribbon"></div>
    <div class="row">
        <div class="col-md-4">
            <div>
                <a class="<?php if(is_page($weddingsTitle) || is_tree($weddingsId)) echo 'active-footer-link'; ?>" href="<?php echo get_permalink($weddingsId); ?>"><?php _e($weddingsTitle); ?></a>
            </div>
            <div class="connection-image">
                <?php
                $imageAttachment = wp_get_attachment_image_src(
                    get_post_thumbnail_id($weddingsId), 'medium'
                );
                echo '<a href="' . get_permalink($weddingsId) . '"><img src="' . $imageAttachment[0] . '" width="264" class="img-thumbnail" /></a>';
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <a class="<?php if(is_page($engagementsTitle) || is_tree($engagementsId)) echo 'active-footer-link'; ?>" href="<?php echo get_permalink($engagementsId); ?>"><?php _e($engagementsTitle); ?></a>
            </div>
            <div class="connection-image">
                <?php
                $imageAttachment = wp_get_attachment_image_src(
                    get_post_thumbnail_id($engagementsId), 'medium'
                );
                echo '<a href="' . get_permalink($engagementsId) . '"><img src="' . $imageAttachment[0] . '" width="264" class="img-thumbnail" /></a>';
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <a class="<?php if(is_page($contactTitle) || is_tree($contactId)) echo 'active-footer-link'; ?>" href="<?php echo get_permalink($contactId); ?>"><?php _e($contactTitle); ?></a>
            </div>
            <div class="connection-image">
                <?php
                $imageAttachment = wp_get_attachment_image_src(
                    get_post_thumbnail_id($contactId), 'medium'
                );
                echo '<a href="' . get_permalink($contactId) . '"><img src="' . $imageAttachment[0] . '" width="264" class="img-thumbnail" /></a>';
                ?>
            </div>
        </div>
    </div>
</div>