<?php
get_header();
global $post;
$children = get_pages('child_of=' . $post->ID . '&parent=' . $post->ID);
$postTitle = get_the_title($post->ID);
?>
    <div class="jumbotron">

        <div class="row content-bg">
            <?php
            if (is_tree(2627)
                || is_tree(7345)
                || is_tree(7220)
                || is_tree(1238)
                || is_page(1539)) {
                ?>
                <div class="blue-ribbon portfolio-ribbon">
                    <div class="page-navigation-container">
                        <h1 class="clients-title"><?php the_title(); ?></h1>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php while (have_posts()) : the_post() ?>

                <?php if(is_page('clients')): ?>
                <?php endif; ?>

                <div class="content">
                    <?php if(is_page('Proofing')) : ?>

                        <input type="checkbox" id="linksNewWindow" name="linksNewWindow">
                        <label for="linksNewWindow" id="linksNewWindow">&nbsp;I agree to the Proof Gallery</label> <a href="#myDivID" id="fancyBoxLink" style="margin-left: 10px;">Terms & Conditions</a>
                        <!-- Wrap it inside a hidden div so it won't show on load -->
                        <div style="display:none;">
                            <div id="myDivID">
                                <h2><span>Studio Policies Regarding Reprints:</span></h2>
                                <br />
                                <p>Before you begin, we would like to go over couple simple studio policies to ensure that you have an enjoyable experience ordering photographs.</p>
                                <p></p>
                                <p>The images that you will view are proofs - they are similar to what the final print will be like, but it might not be exactly the same. There might be variations between final print and the online proof. If you are concerned about final output, you can request a printed proof for a small charge.</p>
                                <p></p>
                                <p>Each monitor is different and your final order may be slightly different than what your monitor is showing. For the best experience, use a calibrated monitor or request a printed proof.</p>
                                <p></p>
                                <p>The images online are, for the most part, in a 3/2 ratio. If you order an 8x10 or 5x7 or other sizes not proportional to the original shot, some cropping will occur. Unless specified in the instructions while ordering, we will use our best judgment to crop them. If you do not want any cropping, please mention full frame printing for that photograph. This will produce an image with a white border around it, but will retain the full frame.</p>
                                <p></p>
                                <p>All orders are final and are non-refundable. Make sure you go over your order carefully before submitting.</p>
                                <p></p>
                                <p>Please indicate any special instructions. For example, if you want a certain crop of a photograph, or would like it black &amp; white etc., please make sure to indicate it. For more detailed modifications that require custom retouching, please <strong><a href="http://ctaylorphotos.com/clients/contact">Contact Us</a></strong> for a quote.</p>
                                <p></p>
                                <p>Scanning prints to make larger enlargements is against copyright law and will yield unprofessional quality results.</p>
                                <p></p>
                                <p>Orders during busy times like holiday season or summer wedding season can take a little longer. We may be traveling and/or busy with other clients. If we foresee a delay, we will contact you as soon as possible.</p>
                                <p></p>
                                <p>Also, if you have a deadline, please let us know and we will do our best to accommodate you! By entering a proof gallery, you agree to the above policies.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php the_content(); ?>
                </div>

                <div class="clear"></div>

            <?php endwhile; ?>

            <?php if( !is_page('Contact Us')) : ?>
                <?php get_template_part('footer', 'acb'); ?>
            <?php endif; ?>

        </div>
    </div>

<?php get_footer(); ?>

<?php if(is_page('Proofing')) : ?>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(function() {
        jQuery("body")
            .find(".album_wrapper")
            .attr("id","otherContent");
        jQuery("input[name=linksNewWindow]")
            .change(function() {
                if(jQuery("input[name=linksNewWindow]")
                    .is(":checked")) {
                    jQuery.cookie("linksNewWindow",1,{expires:365,path:"/"});
                    jQuery("#otherContent").show()
                } else {
                    jQuery.cookie("linksNewWindow",0,{expires:365,path:"/"});
                    jQuery("#otherContent").hide();
                }
            });
        function a() {
            var b = jQuery.cookie("linksNewWindow");
            jQuery("input[name=linksNewWindow]")
                .change(function() {
                    if(jQuery("input[name=linksNewWindow]")
                        .is(":checked")) {
                        jQuery.cookie("linksNewWindow",1,{expires:365,path:"/"});
                    } else {
                        jQuery.cookie("linksNewWindow",0,{expires:365,path:"/"});
                    }
                });
            if(b == 1) {
                jQuery("#otherContent")
                    .show();
                jQuery("#linksNewWindow")
                    .attr("checked","checked");
            } else {
                jQuery("#otherContent").hide();
            }
        }
        a()
    });
</script>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(function() {
        jQuery("#fancyBoxLink").fancybox({
            'width':'500',
            'autoSize':false,
            'onStart': function() {
                jQuery('#myDivID')
                    .css('display','block')
                    .css('overflow', 'auto');
            },
            'onClosed': function() {
                jQuery('#myDivID')
                    .css('display','none');
            }
        });
    });
</script>
<?php endif; ?>