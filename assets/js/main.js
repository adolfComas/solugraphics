(function($){
    "use strict";
    $(document).ready(function() {

/* Responsive Menu */
$('#dl-menu').dlmenu({
    animationClasses: {
        classin: 'dl-animate-in-5',
        classout: 'dl-animate-out-5'
    }
});
/* Responsive Menu */

/* Flex Slider (Testimonial Customers) */
$('.testi-slider.flexslider').flexslider({
    animation: "fade",
    slideshow: true,
    slideshowSpeed: 5000,
});
$('.next-slider').click(function () {
    $('.flexslider.pf-carousel').flexslider("Siguiente");
});
$('.prev-slider').click(function () {
    $('.flexslider.pf-carousel').flexslider("Anterior");
});
/* Flex Slider (Testimonial Customers) */


/* Tabs */
$('.shortcode_tabs').each(function (index) {
    var i = 1;
    $('.shortcode_tab_item_title').each(function (
        index) {
        $(this).addClass('it' + i);
        $(this).attr('whatopen', 'body' + i);
        $(this).addClass('head' + i);
        $(this).parents('.shortcode_tabs').find(
            '.all_heads_cont').append(this);
        i++;
    });
    var i = 1;
    $('.shortcode_tab_item_body').each(function (
        index) {
        $(this).addClass('body' + i);
        $(this).addClass('it' + i);
        $(this).parents('.shortcode_tabs').find(
            '.all_body_cont').append(this);
        i++;
    });
});
$('.shortcode_tabs .all_body_cont div:first-child')
    .addClass('active');
$(
    '.shortcode_tabs .all_heads_cont div:first-child').addClass(
    'active');

$('.shortcode_tab_item_title').click(function () {
    $(this).parents('.shortcode_tabs').find(
        '.shortcode_tab_item_body').removeClass('active');
    $(this).parents('.shortcode_tabs').find(
        '.shortcode_tab_item_title').removeClass('active');
    var whatopen = $(this).attr('data-open');
    $(this).parents('.shortcode_tabs').find('.' +
        whatopen).addClass('active');
    $(this).addClass('active');
});
/* Tabs */

/* Tooltip  */
$(function ($) {
    $('.tooltip_s').tooltip()
});
/* Tooltip  */

$('.jcarousel')

.on('jcarousel:reload jcarousel:create', function () {
    var carousel = $(this),
        width = carousel.innerWidth();

    if (width >= 600) {
        width = width / 3;
    } else if (width >= 350) {
        width = width / 1;
    }

    carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
})
.jcarousel({
    wrap: 'circular'
})
.jcarouselAutoscroll({
    interval: 3000,
    target: '+=1',
    autostart: true
});

$(function () {
    $('.zoom').zoomy();
    if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
         $('.zoomy').jqzoom({
                    zoomType: 'standard',
                    lens:true,
                    preloadImages: false,
                    alwaysOn:false,
                    zoomWidth: 600,  
                    zoomHeight: 420,
                    position:'right' 
                });
        }
});

/* Animation */
$(window).on('scroll',function() {
    $(".animated-area").each(function () {
        if ($(window).height() + $(window).scrollTop() -
            $(this).offset().top > 0) {
            $(this).trigger("animate-it");
        }
    });
});
$(".animated-area").on("animate-it", function () {
    var cf = $(this);
    cf.find(".animated").each(function () {
        $(this).css("-webkit-animation-duration",
            "0.9s");
        $(this).css("-moz-animation-duration", "0.9s");
        $(this).css("-ms-animation-duration", "0.9s");
        $(this).css("animation-duration", "0.9s");
        $(this).css("-webkit-animation-delay", $(this).attr(
            "data-animation-delay"));
        $(this).css("-moz-animation-delay", $(this).attr(
            "data-animation-delay"));
        $(this).css("-ms-animation-delay", $(this).attr(
            "data-animation-delay"));
        $(this).css("animation-delay", $(this).attr(
            "data-animation-delay"));
        $(this).addClass($(this).attr("data-animation"));
    });
});
/* Animation */


    });
})(jQuery);