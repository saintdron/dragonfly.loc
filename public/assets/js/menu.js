jQuery(document).ready(function ($) {

    let timerId = null;

    $('.menu').hover(function () {
        let $elem = $(this);
        timerId = setTimeout(function ($elem) {
            $elem.addClass('show');
        }, 300, $elem);
    }, function () {
        $(this).removeClass('show');
        clearTimeout(timerId);
    });
});