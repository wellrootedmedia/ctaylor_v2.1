<div class="blue-ribbon single-item-ribbon">
    <div class="connection">

        <?php
        $myvalue = 'Contact Us';
        $arr = explode(' ',trim($myvalue));
        $newValue = "<span class='contact-us-first'>" . $arr[0] . "</span> <span>" . $arr[1] . "</span>";
        ?>

        <div class="connect-links">
            <a href="<?php echo get_permalink(133); ?>">
                <span class='connection-first-letter contact-us'>Contact</span>
                <span class='connection-second-letter contact-us'>Us</span>
            </a>
        </div>

        <div class="connection_spacer_blog"> | </div>

        <div class="connect-links">
            <a href="https://www.facebook.com/ctaylorphotos">
                <div class='connection-first-letter first-profile'>Like us on</div>
                <div class='connection-second-letter second-profile'>Facebook</div>
            </a>
        </div>

        <div class="connection_spacer_blog"> | </div>

        <div class="connect-links">
            <a href="<?php echo get_permalink(1540); ?>">
                <div class='connection-first-letter first-profile'>View our</div>
                <div class='connection-second-letter second-profile'>Portfolio</div>
            </a>
        </div>

        <div class="clear"></div>

    </div>
</div>

<?php comments_template('', true); ?>

<div class="blue-ribbon single-item-ribbon">
    <div id="nav-below" class="navigation">
        <div class="single-nav-previous">
            <?php previous_post_link('%link', '<span class="nextPrev">« Previous</span> <span class="nextPrev">Post</span>', true, '1'); ?>
        </div>
        <div class="single-nav-next">
            <?php next_post_link('%link', '<span class="nextPrev">Next</span> <span class="nextPrev">Post »</span>', true); ?>
        </div>
    </div>
</div>


<section class="footer-mobile">
    <div class="col-md-12">
        <div id="nav-below" class="navigation">
            <div class="nav-previous col-md-4">
                <?php next_posts_link('<span class="nextPrev">« Older Posts</span>') ?>
            </div>
            <div class="nav-next col-md-4">
                <?php previous_posts_link('<span class="nextPrev">Newer Posts »</span>') ?>
            </div>
        </div><!-- #nav-below -->
    </div>
</section>