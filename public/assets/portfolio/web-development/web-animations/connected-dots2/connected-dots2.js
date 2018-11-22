var webAnimationIntervalId; // single identifier for all web animations

(function () {
    // Optimal values: 180 5 6000
    let dotsCount = 200; // Amount of points
    let neighborsCount = 10; // Number of links
    let maxRange = 6000; // Maximum line length
    let showDots = true; // Show dots in nodes

    const BACKGROUND_COLOR = '#0c636d';

    let canvas, c,
        fillColor, dots;

    let dynamicImage = document.querySelector('[data-alias=connected-dots2]'),
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
            /*canvas.width = parseInt(window.getComputedStyle(image).width);
            canvas.height = parseInt(window.getComputedStyle(image).height);*/
            canvas.width = 770;
            canvas.height = 385;

            dynamicImage.innerHTML = '';
            dynamicImage.appendChild(canvas);

            c = canvas.getContext("2d");
            fillColor = BACKGROUND_COLOR;
            dots = new Array(dotsCount);

            c.lineWidth = 0.2;
            c.strokeStyle = "#fff";
            getStartCoords();
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
                bind: new Array(neighborsCount)
            };
            for (let k = 0; k < neighborsCount; k++) {
                dots[i].bind[k] = -1;
            }
        }
    }

    function newCoords() {
        eraseField();
        let offset;
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

    function showField() {
        if (showDots) {
            c.fillStyle = "#fff";
            paintDots();
        }
        bindDots();
    }

    function eraseField() {
        c.fillStyle = fillColor;
        c.fillRect(0, 0, c.canvas.width, c.canvas.height);
    }

    function paintDots() {
        for (let i = 0; i < dots.length; i++) {
            c.beginPath();
            c.arc(dots[i].x, dots[i].y, 2.5, 0, 2 * Math.PI);
            c.closePath();
            c.fill();
        }
    }

    function bindDots() {
        let squareRange,
            b1, b2,
            canBind, canBind2,
            neighbor;
        for (let i = 0; i < dots.length; i++) {
            for (let k = 0; k < neighborsCount; k++) {
                neighbor = dots[i].bind[k];
                if (neighbor !== -1) {
                    squareRange = Math.pow((dots[neighbor].x - dots[i].x), 2) + Math.pow((dots[neighbor].y - dots[i].y), 2);
                    if (squareRange >= 2 * maxRange) {
                        for (let k1 = 0; k1 < neighborsCount; k1++) {
                            if (dots[neighbor].bind[k1] === i) {
                                dots[neighbor].bind[k1] = -1;
                                break;
                            }
                        }
                        dots[i].bind[k] = -1;
                    }
                }
            }

            canBind = false;
            for (b1 = 0; b1 < neighborsCount; b1++) {
                if (dots[i].bind[b1] === -1) {
                    canBind = true;
                    break;
                }
            }

            if (canBind) {
                top:
                    for (let j = 0; j < dots.length; j++) {
                        squareRange = Math.pow((dots[j].x - dots[i].x), 2) + Math.pow((dots[j].y - dots[i].y), 2);
                        if (squareRange < maxRange) {
                            canBind2 = false;
                            for (b2 = 0; b2 < neighborsCount; b2++) {
                                if (dots[j].bind[b2] === i) continue top;
                                if (dots[j].bind[b2] === -1) {
                                    canBind2 = true;
                                    break;
                                }
                            }

                            if (canBind2) {
                                dots[i].bind[b1] = j;
                                dots[j].bind[b2] = i;
                            }
                        }
                    }
            }

            for (let k = 0; k < neighborsCount; k++) {
                neighbor = dots[i].bind[k];
                if (neighbor !== -1) {
                    squareRange = Math.pow((dots[i].x - dots[neighbor].x), 2) + Math.pow((dots[i].y - dots[neighbor].y), 2);
                    c.globalAlpha = Math.sqrt(Math.sqrt(3 * maxRange - squareRange)) / 11;
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