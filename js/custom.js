'use strict';

//back to top new btn
if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}

$(".dropdown").hover(
    function() {
        $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).fadeIn("50");
        $(this).toggleClass('open');
    },
    function() {
        $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).fadeOut("50");
        $(this).toggleClass('open');
    }
);

$(function () {
    $.material.init();
});



