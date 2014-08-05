<?php
get_header();
global $post;
$children = get_pages('child_of=' . $post->ID . '&parent=' . $post->ID);
?>
    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <?php while (have_posts()) : the_post() ?>
                    <?php if (!is_front_page()) : ?>
                        <div class="blue-ribbon"></div>
                        <div class="post-title">
                            <div class="the-title">
                                <h1><?php the_title(); ?></h1>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="content <?php echo(is_page(133) ? "content_page" : "");
                    echo(is_front_page() ? 'content_home' : ''); ?>">
                        <div class="content2 <?php echo(is_front_page() ? 'content2Home' : ''); ?>">
                            <?php if (is_page(1238)) : ?>
                                <script type="text/javascript">
                                    jQuery.noConflict();
                                    jQuery(function () {

                                        jQuery('body').find('.album_wrapper').attr('id', 'otherContent');

                                        jQuery('input[name=linksNewWindow]').change(function () {
                                            if (jQuery('input[name=linksNewWindow]').is(':checked')) {
                                                jQuery.cookie('linksNewWindow', 1, { expires: 365, path: '/' });
                                                jQuery('#otherContent').show();
                                            } else {
                                                jQuery.cookie('linksNewWindow', 0, { expires: 365, path: '/' });
                                                jQuery('#otherContent').hide();
                                            }
                                        });

                                        function displayContent() {
                                            var gettingCookie = jQuery.cookie('linksNewWindow');
                                            jQuery('input[name=linksNewWindow]').change(function () {
                                                if (jQuery('input[name=linksNewWindow]').is(':checked')) {
                                                    jQuery.cookie('linksNewWindow', 1, { expires: 365, path: '/' });
                                                } else {
                                                    jQuery.cookie('linksNewWindow', 0, { expires: 365, path: '/' });
                                                }
                                            });

                                            if (gettingCookie == 1) {
                                                jQuery('#otherContent').show();
                                                jQuery('#linksNewWindow').attr('checked', 'checked');
                                            } else {
                                                jQuery('#otherContent').hide();
                                            }
                                        }

                                        displayContent();

                                    });
                                </script>
                                <input type="checkbox" id="linksNewWindow" name="linksNewWindow">
                                <label for="linksNewWindow">&nbsp;I agree to the Proof Gallery</label> <a
                                    href="#myDivID" id="fancyBoxLink" style="margin-left: 10px;">Terms & Conditions</a>
                                <!-- Wrap it inside a hidden div so it won't show on load -->
                                <div style="display:none;">
                                    <div id="myDivID" style=" width: 550px; height: auto; overflow: auto;">
                                        <h2><span
                                                style="text-align: justify;">Studio Policies Regarding Reprints:</span>
                                        </h2>
                                        <br/>

                                        <p style="text-align: justify;">Before you begin, we would like to go over
                                            couple simple studio policies to ensure that you have an enjoyable
                                            experience ordering photographs.</p>
                                        <br/>

                                        <p style="text-align: justify;">The images that you will view are proofs - they
                                            are similar to what the final print will be like, but it might not be
                                            exactly the same. There might be variations between final print and the
                                            online proof. If you are concerned about final output, you can request a
                                            printed proof for a small charge.</p>
                                        <br/>

                                        <p style="text-align: justify;">Each monitor is different and your final order
                                            may be slightly different then what your monitor is showing. For the best
                                            experience, use a calibrated monitor or request a printed proof.</p>
                                        <br/>

                                        <p style="text-align: justify;">The images online are, for the most part, in a
                                            3/2 ratio. If you order an 8x10 or 5x7 or other sizes not proportional to
                                            the original shot, some cropping will occur. Unless specified in the
                                            instructions while ordering, we will use our best judgment to crop them. If
                                            you do not want any cropping, please mention full frame printing for that
                                            photograph. This will produce an image with a white border around it, but
                                            will retain the full frame.</p>
                                        <br/>

                                        <p style="text-align: justify;">All orders are final and are non-refundable.
                                            Make sure you go over your order carefully before submitting.</p>
                                        <br/>

                                        <p style="text-align: justify;">Please indicate any special instructions. For
                                            example, if you want a certain crop of a photograph, or would like it black
                                            &amp; white etc., please make sure to indicate it. For more detailed
                                            modifications that require custom retouching, please <strong><a
                                                    href="http://ctaylorphotos.com/clients/contact">Contact
                                                    Us</a></strong> for a quote.</p>
                                        <br/>

                                        <p style="text-align: justify;">Scanning prints to make larger enlargements is
                                            against copyright law and will yield unprofessional quality results.</p>
                                        <br/>

                                        <p style="text-align: justify;">Orders during busy times like holiday season or
                                            summer wedding season can take a little longer. We may be traveling and/or
                                            busy with other clients. If we foresee a delay, we will contact you as soon
                                            as possible.</p>
                                        <br/>

                                        <p style="text-align: justify;">Also, if you have a deadline, please let us know
                                            and we will do our best to accommodate you! By entering a proof gallery, you
                                            agree to the above policies.</p>
                                        <br/>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>