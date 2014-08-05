jQuery.noConflict();
jQuery(document).ready(function() {

    jQuery('#menu-main-nav li a').hover(
        function() {
            jQuery('.sub-menu').animate({
                width: "236px",
                padding: "0 1px 0 1px",
                position: "absolute",
                left: "-1px",
                top: "52px",
                display: "none",
                zIndex: "999"
            }, 10);
    },
    function() {
        //jQuery(this).animate({ color: "#fff" }, 10);
    });

    jQuery('.post_footer a').hover(
    function() {
        jQuery(this).animate({ color: "#ED1C24" }, 'slow');
    },function() {
        jQuery(this).animate({ color: "#5A7C87" }, 'slow');
    }
    );

    jQuery('.album_grid').each(function(i) {
        if(this.style.clear == 'both') {
        jQuery(this).removeAttr("style");
        }
    });

    jQuery('.ecommerce').each(function(i) {
        if(this.style.clear == 'both') {
        jQuery(this).removeAttr("style");
        }
    });

    jQuery('#gform_wrapper_1').each(function(i) {
        if(this.style.display == 'none') {
        jQuery(this).removeAttr("style");
        }
    });

//    jQuery('.homePageBtn').click(function() {
//        window.location.href="http://ctaylorphotos.com";
//        });

    jQuery('.galleria-thumbnails').show();
    jQuery('.galleria-thumbnails-container').show();

    jQuery('img').bind('contextmenu', function(e) {
        return false;
        });

    jQuery('div.iframe_wrapper').show();

});
