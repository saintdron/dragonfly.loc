jQuery(document).ready(function ($) {

    let timerHoverId = null,
        timerNavigationId = null;

    $('.menu').hover(function () {
        let $elem = $(this);
        let $navigation = $(this).closest('.navigation');
        if (!($navigation.hasClass('inCorner'))) {
            timerHoverId = setTimeout(function ($elem) {
                $elem.addClass('show');
            }, 300, $elem);
        }
    }, function () {
        $(this).removeClass('show');
        clearTimeout(timerHoverId);
    });

    $('.menu').on('click', function () {
        let $elem = $(this);
        let $navigation = $(this).closest('.navigation');
        if ($navigation.hasClass('inCorner')) {
            $navigation.removeClass('navigation_left-top')
                .removeClass('navigation_right-top')
                .removeClass('navigation_left-bottom')
                .removeClass('navigation_right-bottom');
            $('.menu-content_house').fadeOut(350, function () {
                $(this).removeClass('menu-content_house').fadeIn(350, function () {
                    $navigation.removeClass('inCorner');
                });
            });
            return false;
        }

        const changeIcon = (sel) => {
            timerNavigationId = setTimeout(function () {
                $navigation.addClass('inCorner');
                $(sel).fadeOut(200, function () {
                    $(this).addClass('menu-content_house').fadeIn(200);
                });
            }, 800);
        };

        if ($elem.hasClass('menu_left-top')) {
            $navigation.addClass('navigation_right-bottom');
            changeIcon('.menu-content_left-top');
        } else if ($elem.hasClass('menu_right-top')) {
            $navigation.addClass('navigation_left-bottom');
            changeIcon('.menu-content_right-top');
        } else if ($elem.hasClass('menu_left-bottom')) {
            $navigation.addClass('navigation_right-top');
            changeIcon('.menu-content_left-bottom');
        } else if ($elem.hasClass('menu_right-bottom')) {
            $navigation.addClass('navigation_left-top');
            changeIcon('.menu-content_right-bottom');
        }
    });
});