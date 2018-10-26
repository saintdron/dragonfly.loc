jQuery(document).ready(function ($) {

    let timerHoverId = null,
        timerNavigationId = null;

    $('.menu').hover(function () {
        let $elem = $(this);
        let $navigation = $(this).closest('.navigation');
        // if (!($navigation.hasClass('navigation_right-bottom'))) {
        timerHoverId = setTimeout(function ($elem) {
            $elem.addClass('show');
        }, 300, $elem);
        // }
    }, function () {
        $(this).removeClass('show');
        clearTimeout(timerHoverId);
    });

    $('.menu').on('click', function (e) {
        e.preventDefault();
        let $elem = $(this);
        let url = $(e.target).attr('href');
        let $navigation = $(this).closest('.navigation');

        if ($navigation.hasClass('inCorner')) {

            history.pushState({ url: url }, "DragonFly", '/');

            $navigation.addClass('navigation_center')
                .removeClass('navigation_left-top')
                .removeClass('navigation_right-top')
                .removeClass('navigation_left-bottom')
                .removeClass('navigation_right-bottom');
            $('.menu-content_house').fadeOut(350, function () {
                $navigation.removeClass('inCorner');
                $(this).removeClass('menu-content_house').fadeIn(350);
            });

            console.log(e.target);
            $.ajax({
                url: '/',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function (result) {
                    console.log(result);
                    $('#content').html(result);
                },
                error: function () {
                    console.log('error');
                }
            });

            return false;
        }

        history.pushState({ url: url }, "DragonFly", url);

        const pass = (e, sel) => {
            $navigation.removeClass('navigation_center');
            console.log(e.target);
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                success: function (result) {
                    console.log(result);
                    $('#content').html(result);
                },
                error: function () {
                    console.log('error');
                }
            });

            // $('.menu.show').removeClass('show');
            timerNavigationId = setTimeout(function () {
                // let href = $elem.find('a').attr('href');
                $navigation.addClass('inCorner');
                $(sel).fadeOut(200, function () {
                    $(this).addClass('menu-content_house').fadeIn(200);
                });
                // location.href = href;
                /*$(sel).animate({
                    opacity: 0
                }, 150, function () {
                    // $navigation.addClass('inCorner');
                    location.href = href;
                });*/
                /*$navigation.addClass('inCorner');
                $(sel).fadeOut(200, function () {
                    // $(this).addClass('menu-content_house').fadeIn(200, function() {
                    let href = $elem.find('a').attr('href');
                    location.href = href;
                    // });
                });*/
            }, 800);

            return false;
        };

        if ($elem.hasClass('menu_left-top')) {
            $navigation.addClass('navigation_right-bottom');
            pass(e, '.menu-content_left-top');
        } else if ($elem.hasClass('menu_right-top')) {
            $navigation.addClass('navigation_left-bottom');
            pass(e, '.menu-content_right-top');
        } else if ($elem.hasClass('menu_left-bottom')) {
            $navigation.addClass('navigation_right-top');
            pass(e, '.menu-content_left-bottom');
        } else if ($elem.hasClass('menu_right-bottom')) {
            $navigation.addClass('navigation_left-top');
            pass(e, '.menu-content_right-bottom');
        }

        return false;
    });
});