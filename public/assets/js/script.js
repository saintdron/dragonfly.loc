var webAnimationIntervalId;     // Single identifier for all web animations

function runProgressBars() {
    if ($('.skills').length) {

        const BAR_COLORS = [
            [90, '#26d019'],
            [80, '#96d311'],
            [70, '#c7e210'],
            [60, '#edda14'],
            [50, '#efa209'],
            [40, '#e54b00'],
            [30, '#de0000']
        ];

        let $bars = $('.bar');
        let barArr = [];
        $bars.each(function (i, v) {
            let level = v.dataset.progress;
            let color = '#ff0000';
            for (let [l, c] of BAR_COLORS) {
                if (level >= l) {
                    color = c;
                    break;
                }
            }
            barArr[i] = new RadialProgress(v, {
                colorBg: "#DDDDDD",
                colorFg: color,
                colorText: "#d0d0d0",
                progress: level / 100,
                thick: 12,
                round: true,
                spin: true,
                animationSpeed: 0.1 + level / 1000,
                // noPercentage: true,
            });
        });
    }
}

function changeTitle() {
    let $dataTitleElem = $('[data-title]');
    if ($dataTitleElem) {
        $('title').text($dataTitleElem.attr('data-title') || 'DragonFly');
    }
}

function loadWorks() {
    $('.dynamic').each(function (_, elem) {
        let style = $(elem).attr('data-style'),
            script = $(elem).attr('data-script');
        if (style) {
            if (document.createStyleSheet) {
                document.createStyleSheet(style);
            } else {
                $("head").append($("<link rel='stylesheet' href='" + style + "' type='text/css'/>"));
            }
        }
        if (script) {
            $.getScript(script);
        }
    });
}

function unloadWorks() {
    clearInterval(webAnimationIntervalId);
}

function setFeedbackFormHandler() {
    let alertTimerId = null;
    const showStatus = () => {
        alertTimerId = setTimeout(function () {
            $('#status').slideUp();
        }, 5000);
    };

    $('#mail-form').on('click', '[type=submit]', function (e) {
        e.preventDefault();
        let form = e.delegateTarget;
        $.ajax({
            url: $(form).attr('action'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(form).serializeArray(),
            datatype: 'JSON',
            type: 'POST',
            success: function (result) {
                clearTimeout(alertTimerId);
                $('#status').html(result).slideDown(showStatus);
                if ($('.alert-success').length) {
                    $(form).find('input').val('');
                    $(form).find('textarea').val('');
                }
            },
            error: function () {
                $('#status').slideDown(showStatus);
            }
        });
    });
}

// Add (or remove) "wow" class for first "work-desc" on mobile device
function checkWow() {
    if ($(window).width() > '1000') {
        console.log('>1000');
        $('.work-desc:first').removeClass('wow slideInRight');
    } else {
        $('.work-desc:first').addClass('wow slideInRight');
    }
}

function checkRestAnimation() {

    // wow.js initialization
    new WOW({
        offset: 200, // default 0
    }).init();

    // Hide sticky note
    $('.description_note').on('click', function () {
        let $desc = $(this);
        $(this).addClass('animated swing');
        setTimeout(function () {
            $desc.addClass('fadeOutDownBig');
            setTimeout(function () {
                $desc.hide();
            }, 250);
        }, 750);
    });

    // Change service button image when hover it
    $('.service-button').hover(function () {
        let $img = $(this).find('img');
        let name = $img.attr('class');
        $img.attr('src', '/assets/portfolio/web-development/services/' + name + '/' + name + '_white.png');
    }, function () {
        let $img = $(this).find('img');
        let name = $img.attr('class');
        $img.attr('src', '/assets/portfolio/web-development/services/' + name + '/' + name + '.png');
    });

    // Animate site buttons when hover it
    $('.site-button').hover(function () {
        let $wing = $('#wing');
        $(this).append($wing).addClass('animate');
        $wing.show().addClass('animate');
    }, function () {
        let $wing = $('#wing');
        $('body').append($wing);
        $(this).removeClass('animate');
        $wing.hide().removeClass('animate');
    });
}

jQuery(document).ready(function ($) {
        runProgressBars();
        loadWorks();
        setFeedbackFormHandler();
        checkRestAnimation();
    }
);