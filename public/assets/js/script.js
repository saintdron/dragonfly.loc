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
                colorText: "#e4e4e4",
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

jQuery(document).ready(function ($) {
        runProgressBars();
        loadWorks();
        setFeedbackFormHandler();
    }
);