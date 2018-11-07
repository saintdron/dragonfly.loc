jQuery(document).ready(function ($) {

    /*   let myplugin;

       // if (!myplugin) {
           myplugin = $('#p1').cprogress({
               percent: 10, // starting position
               img1: '/assets/extra/jcprogress/v1.png', // background
               img2: '/assets/extra/jcprogress/v3.png', // foreground
               speed: 100, // speed (timeout)
               PIStep: 0.1, // every step foreground area is bigger about this val
               limit: 70, // end value
               loop: false, //if true, no matter if limit is set, progressbar will be running
               showPercent: true, //show hide percent
               onInit: function () {
                   console.log('onInit');
               },
               onProgress: function (p) {
                   console.log('onProgress', p);
                   if (p >= 50) {
                       // this.speed = 1000;
                       // myplugin.stop();
                       myplugin.options({img2: '/assets/extra/jcprogress/v2.png'});
                       // myplugin.reset();
                       // myplugin.draw();
                       console.log('this', this);
                   }

               }, //p=current percent
               onComplete: function (p) {
                   console.log('onComplete', p);
               }
           });
       // }*/

    const BAR_COLORS = [
        [90, '#41f441'],
        [80, '#7cf441'],
        [70, '#b8f441'],
        [60, '#f4f441'],
        [50, '#f4b841'],
        [40, '#f47c41'],
        [30, '#f44141']
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
            colorText: "#202020",
            progress: level / 100,
            thick: 12,
            round: true,
            spin: true,
            animationSpeed: 0.5,
            noPercentage: true,
        });
    });

    /*    var bar = new RadialProgress(document.getElementById("bar"), {
            colorBg: "#DDDDDD",
            colorFg: "#202020",
            colorText: "#202020",
            progress: 0.8,
            thick: 12,
            // fixedTextSize: 0.25,
            round: true,
            spin: true,
            animationSpeed: 0.5,
            noPercentage: true,
        });*/

    // bar.setValue(0.8);
});