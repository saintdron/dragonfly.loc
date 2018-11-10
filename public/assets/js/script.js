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

jQuery(document).ready(function ($) {
    runProgressBars();
});