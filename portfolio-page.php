<?php
/**
 * Template Name: portfolio-page
 */
get_header();
global $post;
global $id;

function getVimeoUrl($post_id, $key) {
    $vimeoUrl = get_post_meta($post_id, $key);
    return $vimeoUrl;
}
?>
    <div class="jumbotron">
        <div class="content-bg">

            <?php get_template_part('ribbon', 'portfolio-navigation'); ?>

            <div class="row">

                <div class="content portfolio-page">
                    <?php
                    switch ($post->post_name) {
                        case 'weddings':
                            get_template_part('content', 'weddings-block');
                            wp_reset_query();
                            break;
                        case 'films':
                            get_template_part('content', 'films-block');
                            wp_reset_query();
                            break;
                        case 'engagements':
                            get_template_part('content', 'engagements-block');
                            wp_reset_query();
                            break;
                        case 'fusion-video':
                            get_template_part('content', 'fusionVideos-block');
                            wp_reset_query();
                            break;
                        case 'portraits':
                            get_template_part('content', 'portrait-block');
                            wp_reset_query();
                            break;
                        default:
                    }
                    ?>
                </div>

            </div>

            <?php get_template_part('footer', 'wec'); ?>
        </div>
    </div>

<?php get_footer(); ?>