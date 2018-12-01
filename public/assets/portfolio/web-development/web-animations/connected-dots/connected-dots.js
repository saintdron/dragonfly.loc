(function () {
    let dotsCount = 180;        // Amount of points
    let neighborsCount = 10;    // The number of connections at one node
    let maxRange = 6000;        // Connection radius
    let showDots = true;        // Show points

    const CANVAS_WIDTH = 770;
    const CANVAS_HEIGHT = 385;
    const BACKGROUND_COLOR = '#0c636d';

    let canvas, c,
        fillColor, dots;

    let dynamicImage = document.querySelector('.connected-dots'),
        image = dynamicImage.querySelector('img');

    image.onload = function () {
        run();
    };
    image.src = image.src;

    window.onunload = function () {
        clearInterval(webAnimationIntervalId);
    };

    function run() {
        if (!canvas) {
            canvas = document.createElement('canvas');
            canvas.width = CANVAS_WIDTH;
            canvas.height = CANVAS_HEIGHT;
            fillColor = BACKGROUND_COLOR;

            c = canvas.getContext("2d");
            c.lineWidth = 0.2;
            c.strokeStyle = "#fff";

            dots = new Array(dotsCount);
            getStartCoords();

            dynamicImage.innerHTML = '';
            dynamicImage.appendChild(canvas);

            // ACTIVATION OF THIRD-PARTY COMPONENTS
            $('#dots').rangeslider({
                polyfill: false,
                onSlide: function (position, value) {
                    $('.tuning__dots output').text(value);
                    dotsCount = value;
                },
                onSlideEnd: function (position, value) {
                    dots = new Array(dotsCount);
                    getStartCoords();
                }
            });

            let nodesSwitch = new Switch(document.querySelector('.checkbox-switch'), {
                size: 'small',
                checked: true,
                offJackColor: '#f2f2f2',
                onJackColor: '#f2f2f2',
                offSwitchColor: '#d1d1d1',
                onSwitchColor: '#34b3a0',
                onChange: function () {
                    showDots = !showDots;
                }
            });

            $('#connections').rangeslider({
                polyfill: false,
                onSlide: function (position, value) {
                    $('.tuning__connections output').text(value);
                },
                onSlideEnd: function (position, value) {
                    neighborsCount = value;
                    dots = new Array(dotsCount);
                    getStartCoords();
                }
            });

            $('#range').rangeslider({
                polyfill: false,
                onSlide: function (position, value) {
                    $('.tuning__range output').text(Math.round(Math.sqrt(value)));

                },
                onSlideEnd: function (position, value) {
                    maxRange = value;
                    dots = new Array(dotsCount);
                    getStartCoords();
                }
            });

            webAnimationIntervalId = setInterval(newCoords, 30);
        }
    }

    function getStartCoords() {
        let dx, dy;
        for (let i = 0; i < dots.length; i++) {
            dx = Math.random() * 4 - 2;
            dy = Math.random() * 4 - 2;
            dots[i] = {
                x: Math.random() * canvas.width,
                y: Math.random() * canvas.height,
                dx: dx,
                dy: dy,
                binds: new Array(neighborsCount).fill(-1)
            };
        }
    }

    function newCoords() {
        eraseField();
        for (let i = 0; i < dots.length; i++) {
            if (dots[i].x < -25 || dots[i].x > canvas.width + 25) {
                dots[i].dx = -dots[i].dx;
            }
            dots[i].x += dots[i].dx;
            if (dots[i].y < -25 || dots[i].y > canvas.height + 25) {
                dots[i].dy = -dots[i].dy;
            }
            dots[i].y += dots[i].dy;
        }
        showField();
    }

    function eraseField() {
        c.fillStyle = fillColor;
        c.fillRect(0, 0, c.canvas.width, c.canvas.height);
    }

    function showField() {
        if (showDots) {
            c.fillStyle = "#fff";
            paintDots();
        }
        bindsDots();
    }

    function paintDots() {
        for (let i = 0; i < dots.length; i++) {
            c.beginPath();
            c.arc(dots[i].x, dots[i].y, 2.5, 0, 2 * Math.PI);
            c.closePath();
            c.fill();
        }
    }

    function bindsDots() {
        let squareRange,
            n1, n2,
            canBind, canBind2,
            neighbor;
        for (let i = 0; i < dots.length; i++) {
            for (let n = 0; n < neighborsCount; n++) {
                neighbor = dots[i].binds[n];
                if (neighbor !== -1) {
                    squareRange = Math.pow((dots[neighbor].x - dots[i].x), 2) + Math.pow((dots[neighbor].y - dots[i].y), 2);
                    if (squareRange > 2 * maxRange) {
                        for (let k = 0; k < neighborsCount; k++) {
                            if (dots[neighbor].binds[k] === i) {
                                dots[neighbor].binds[k] = -1;
                                break;
                            }
                        }
                        dots[i].binds[n] = -1;
                    }
                }
            }

            canBind = false;
            for (n1 = 0; n1 < neighborsCount; n1++) {
                if (dots[i].binds[n1] === -1) {
                    canBind = true;
                    break;
                }
            }

            if (canBind) {
                top:
                    for (let j = 0; j < dots.length; j++) {
                        if (i === j) continue;
                        squareRange = Math.pow((dots[j].x - dots[i].x), 2) + Math.pow((dots[j].y - dots[i].y), 2);
                        if (squareRange < maxRange) {
                            canBind2 = false;
                            for (n2 = 0; n2 < neighborsCount; n2++) {
                                if (dots[j].binds[n2] === i) continue top;
                                if (dots[j].binds[n2] === -1) {
                                    canBind2 = true;
                                    break;
                                }
                            }
                            if (canBind2) {
                                dots[i].binds[n1] = j;
                                dots[j].binds[n2] = i;
                                break;
                            }
                        }
                    }
            }

            for (let n = 0; n < neighborsCount; n++) {
                neighbor = dots[i].binds[n];
                if (neighbor !== -1) {
                    squareRange = Math.pow((dots[i].x - dots[neighbor].x), 2) + Math.pow((dots[i].y - dots[neighbor].y), 2);
                    if (squareRange > maxRange) {
                        c.globalAlpha = 1 - (squareRange - maxRange) / maxRange;
                    }
                    paintLine(dots[i].x, dots[i].y, dots[neighbor].x, dots[neighbor].y);
                    c.globalAlpha = 1;
                }
            }
        }
    }

    function paintLine(x1, y1, x2, y2) {
        c.beginPath();
        c.moveTo(x1, y1);
        c.lineTo(x2, y2);
        c.closePath();
        c.stroke();
    }

}());