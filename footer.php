</div><!-- end container -->

<?php if(!is_front_page()) : ?>

    <div id="footer">
        <div class="container">
            <div class="lower-footer">

                <form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="s" id="s">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Go!</button>
                        </span>
                    </div>
                </form>
                <p class="text-muted credit">
                    <a href="<?php bloginfo('url'); ?>">Cameron Taylor | Long Beach Wedding Photography & Cinematography</a>
                </p>

            </div>
        </div>
    </div>

<?php else: ?>

    <div id="footer">
        <div class="container">
            <p class="text-muted credit"><a href="<?php bloginfo('url'); ?>">Cameron Taylor | Long Beach Wedding Photography & Cinematography</a></p>
        </div>
    </div>

<?php endif; ?>

<?php wp_footer(); ?>

<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/js/jquery.easing.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/dist/js/bootstrap.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/holder.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/dist/js/extras.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/dist/js/jquery.cookie.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/dist/js/jquery.slides.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/js/supersized.3.2.7.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/js/supersized.shutter.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/dist/js/super.sized.listview.js"></script>

<?php if(is_front_page()) : ?>
    <script type="text/javascript">
        jQuery(function($) {

            var viewpoint240 = window.matchMedia( "(max-width: 240px)" );
            var viewpoint320 = window.matchMedia( "(max-width: 320px)" );
            var viewpoint360 = window.matchMedia( "(max-width: 360px)" );
            var viewpoint603 = window.matchMedia( "(max-width: 603px)" );
            var viewpoint768 = window.matchMedia( "(max-width: 768px)" );
            var viewpoint1024 = window.matchMedia( "(max-width: 1024px)" );

            if (viewpoint1024.matches) {

                $('.site-bg').remove();

                $.supersized({
                    slide_interval : 3000,
                    transition : 1,
                    transition_speed : 700,
                    slide_links : 'blank',
                    slides : [
                        {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/homepage-mobile-images/1.jpg', title : '', thumb : ''},
                        {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/homepage-mobile-images/2.jpg', title : '', thumb : ''},
                        {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/homepage-mobile-images/3.jpg', title : '', thumb : ''},
                        {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/homepage-mobile-images/4.jpg', title : '', thumb : ''},
                        {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/homepage-mobile-images/5.jpg', title : '', thumb : ''},
                        {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/homepage-mobile-images/6.jpg', title : '', thumb : ''},
                        {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/homepage-mobile-images/7.jpg', title : '', thumb : ''}
                    ]
                });

            } else {

                var introvid = jQuery('.intro-video');
                var introvidplayer = jQuery('.intro-video')[0];
                introvidplayer.play();
                introvidplayer.addEventListener( "ended", function() {
                    jQuery('body')
                        .find('.static-img')
                        .css('display', 'block')
                        .css('background-image', 'url("<?php echo get_stylesheet_directory_uri(); ?>/assets/images/promo-home-image.jpg")');

                    introvid.fadeOut();
                }, false );
            }

        });
    </script>
<?php endif; ?>

<?php
if(is_page('portfolio')
    || is_page('blog')
    || is_page('clients')
    || is_search()
    || is_tag()
    || is_tree(1540)
    || is_single()
    || is_tree(1238)
    || is_tree(2627)
    || is_tree(7220)
    || is_tree(7345)
    || is_category()
    || is_archive()
    || is_page('Shopping Cart')
    || is_page('Thank You!')) : ?>
    <script type="text/javascript">
        jQuery(function($){

            $.supersized({
                slide_interval : 3000,
                transition : 1,
                transition_speed : 700,
                slide_links : 'blank',
                slides : [
                    {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/bg-slider-images/1.jpg', title : '', thumb : ''},
                    {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/bg-slider-images/2.jpg', title : '', thumb : ''},
                    {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/bg-slider-images/3.jpg', title : '', thumb : ''},
                    {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/bg-slider-images/4.jpg', title : '', thumb : ''},
                    {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/bg-slider-images/5.jpg', title : '', thumb : ''},
                    {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/bg-slider-images/6.jpg', title : '', thumb : ''},
                    {image : '<?php echo get_stylesheet_directory_uri();?>/assets/images/bg-slider-images/7.jpg', title : '', thumb : ''}
                ]
            });
        });
    </script>
<?php endif; ?>

<?php if(!is_page('blog')) : ?>
    <script type="text/javascript"
            src="<?php echo get_stylesheet_directory_uri(); ?>/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript"
            src="<?php echo get_stylesheet_directory_uri(); ?>/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
    <script type="text/javascript"
            src="<?php echo get_stylesheet_directory_uri(); ?>/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript"
            src="<?php echo get_stylesheet_directory_uri(); ?>/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <script type="text/javascript"
            src="<?php echo get_stylesheet_directory_uri(); ?>/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

    <script type="text/javascript">
        jQuery(function($){

            $('.fancybox')
                .fancybox({
                    openEffect: 'none',
                    closeEffect: 'none',
                    prevEffect: 'none',
                    nextEffect: 'none',
                    padding: 0,
                    helpers: {
                        media: {}
                    },
                    width: '720px',
                    height: '410px',
                    scrolling: 'no'
                });

            $('.photocrati_lightbox_always').fancybox();

        });
    </script>
<?php endif; ?>

<?php if(get_post_format() != 'aside') : ?>
    <script type="text/javascript">
        jQuery(function($){
            $('#promo-slides').slidesjs({
                width: 921,
                height: 263,
                play: {
                    active: false,
                    auto: true,
                    interval: 5000,
                    swap: true,
                    effect: 'fade'
                },
                navigation: false,
                pagination: false
            });
        });
    </script>
<?php endif; ?>

<?php if ($format == 'video') : ?>
    <script type="text/javascript">
        var player = new MediaElementPlayer('video', {
                autoplay: true
            }
        );
        player.play();
    </script>
<?php endif; ?>

<script type="text/javascript">
    jQuery(function($){

        $('#slides-section').hide();
        $("#slides-section").promise().done(function () {
            $(this).show();
        });

        $('#category-blog-slides').slidesjs({
            width: 921,
            height: 263,
            play: {
                active: false,
                auto: true,
                interval: 5000,
                swap: true,
                effect: 'fade'
            },
            navigation: false,
            pagination: false
        });

        $('#portfolio-slides').slidesjs({
            width: 882,
            height: 370,
            play: {
                active: false,
                auto: true,
                interval: 5000,
                swap: true,
                effect: 'fade'
            },
            navigation: false,
            pagination: false
        });

        $("#input_1_3").datepicker();

        $('.portfolio-thumbnail').hover(
            function () {
                $(this).find('.portfolio-overlay')
                    .css('visibility', 'visible')
                    .css('position', 'relative')
                    .css('top', '-200px')
                    .css('width', '300px !important')
                    .css('background-color', '#ffffff')
                    .css('height', '200px')
                    .css('color', '#92BFD5')
                    .animate({
                        color: "#000"
                    }, 1000);
            },
            function () {
                $(this).find('.portfolio-overlay')
                    .css('visibility', 'hidden')
                    .css('background', 'transparent')
                    .animate({ color: "#92BFD5" }, 'slow');
            });

        $('.wp-post-image').addClass('img-thumbnail');
    });
</script>




</body>
</html>