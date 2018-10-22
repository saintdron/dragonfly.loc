jQuery(document).ready(function ($) {

    let timerHoverId = null,
        timerNavigationId = null;

    $('.menu').hover(function () {
        let $elem = $(this);
        timerHoverId = setTimeout(function ($elem) {
            $elem.addClass('show');
        }, 300, $elem);
    }, function () {
        $(this).removeClass('show');
        clearTimeout(timerHoverId);
    });

    $('.menu').on('click', function () {
        let $elem = $(this);
        let $navigation = $(this).closest('.navigation');
        if ($elem.hasClass('menu-content_house')) {

        }

        if ($elem.hasClass('menu_left-top')) {
            $navigation.addClass('navigation_right-bottom');
            timerNavigationId = setTimeout(function () {
                $('.menu-content_left-top').animate({
                    opacity: 0
                }, 300, function () {
                    $(this).addClass('.menu-content_house')
                        .css('background-image', 'url(../assets/css/icons/house_green.png)')
                        .animate({
                            opacity: 1
                        }, 300);
                });
            }, 1500);
        } else if ($elem.hasClass('menu_right-top')) {
            $navigation.addClass('navigation_left-bottom');
        } else if ($elem.hasClass('menu_left-bottom')) {
            $navigation.addClass('navigation_right-top');
        } else if ($elem.hasClass('menu_right-bottom')) {
            $navigation.addClass('navigation_left-top');
        }
    });
});