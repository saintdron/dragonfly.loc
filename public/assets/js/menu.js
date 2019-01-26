jQuery(document).ready(function ($) {

    history.replaceState({url: window.location.href}, "", window.location.href);

    let timerHoverId = null,
        timerNavigationId = null;

    window.onpopstate = function (e) {
        if (e.state && e.state.url) {
            window.location = e.state.url;
        }
    };

    function loadContent(url) {
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            success: function (result) {
                $('#content').html(result);
                loadWorks();
                changeTitle();
                runProgressBars();
                setFeedbackFormHandler();
                checkRestAnimation();
            },
            error: function () {
                $('#content').html("<div class='container-fluid error error-runtime' data-title='Ошибка'>" +
                    "<div class='content'>" +
                    "<figure>" +
                    "<img src='/assets/images/gif/error-runtime.gif' alt='Стрекоза у пруда'>" +
                    "<figcaption>Затянулась бурой тиной<br>Гладь старинного пруда...</figcaption>" +
                    "</figure>" +
                    "<p>При загрузке страницы произошла ошибка.<br>Попробуйте обновить страницу</p>" +
                    "</div></div>");
            }
        });
    }


    $('.menu').hover(function () {
        let $elem = $(this);
        let $navigation = $(this).closest('.navigation');
        timerHoverId = setTimeout(function ($elem) {
            $elem.addClass('show');
        }, 300, $elem);
    }, function () {
        $(this).removeClass('show');
        clearTimeout(timerHoverId);
    });


    $('.menu').on('click', function (e) {

        // From Home page transition function
        const pass = (sel) => {
            $navigation.removeClass('navigation_center');
            loadContent(url);
            timerNavigationId = setTimeout(function () {
                $navigation.addClass('inCorner');
                $(sel).fadeOut(200, function () {
                    $(this).addClass('menu-content_house').fadeIn(200);
                });
            }, 300);
        };

        e.preventDefault();

        let $elem = $(this);
        let url = $elem.find('a').attr('href');
        let $navigation = $(this).closest('.navigation');

        // Not from Home page
        if ($navigation.hasClass('inCorner')) {
            $navigation.addClass('navigation_center')
                .removeClass('navigation_left-top navigation_right-top navigation_left-bottom navigation_right-bottom');

            $('.menu-content_house').fadeOut(350, function () {
                $navigation.removeClass('inCorner');
                $(this).removeClass('menu-content_house').fadeIn(350);
            });

            loadContent('/');
            unloadWorks();
            history.pushState({url: '/'}, "", '/');
            return false;
        }

        if ($elem.hasClass('menu_left-top')) {
            $navigation.addClass('navigation_right-bottom');
            pass('.menu-content_left-top');
        } else if ($elem.hasClass('menu_right-top')) {
            $navigation.addClass('navigation_left-bottom');
            pass('.menu-content_right-top');
        } else if ($elem.hasClass('menu_left-bottom')) {
            $navigation.addClass('navigation_right-top');
            pass('.menu-content_left-bottom');
        } else if ($elem.hasClass('menu_right-bottom')) {
            $navigation.addClass('navigation_left-top');
            pass('.menu-content_right-bottom');
        }

        history.pushState({url: url}, "", url);

        return false;
    });
});