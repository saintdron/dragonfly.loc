jQuery(document).ready(function ($) {

    // Hide sticky note
    $('.description').on('click', function () {
        let $desc = $(this);
        $(this).addClass('animated swing');
        setTimeout(function () {
            $desc.addClass('fadeOutDownBig');
            setTimeout(function () {
                $desc.hide();
            }, 250);
        }, 750);
    });


    // Text processing
    function wordend(num, words) {
        return words[((num % 100 > 10 && num % 100 < 15) || num % 10 > 4 || num % 10 === 0) ? 2 : +(num % 10 !== 1)];
    }

    var prevOriginal = '';

    $('#original').on('input change keyup', function () {
        let text = $(this).val();
        if (text.length === prevOriginal.length && text === prevOriginal) {
            return false;
        }
        prevOriginal = text;

        const r = (reg, str) => {
            text = text.replace(reg, str);
        };

        let corrs = 0;
        if (text) {
            let reg, m,
                beforeLength, afterLength;

            // UNICODE

            // \u0400-\u04FF' Cyrillic all
            // \u0430-\u045F' Cyrillic lowercase
            // \u0400-\u0429\u0460-\u04FF' Cyrillic uppercase

            // -\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63 Все тире
            // -(\u002D) Дефис-минус
            // \u2013 Среднее (короткое) тире
            // \u2014 Длинное тире

            // \u00A0 Неразрывный пробел

            // TAB_TO_SPACE
            if ($('#tab_to_space').is(':checked')) {
                reg = /\t/g;
                m = text.match(reg);
                if (m) {
                    corrs += m.length;
                    text = text.replace(reg, ' ');
                }
            }

            // DELETE_EXCESS_SPACES
            if ($('#delete_spaces').is(':checked')) {
                beforeLength = text.length;
                // console.log('beforeLength:', beforeLength);

                // e.g. Трудове право/
                // Соцзабезпечення
                reg = /\/(?:(?:\r\n)|(?:\n\r)|\r|\n)/g;
                text = text.replace(reg, '/');

                // e.g. напри-
                // мер
                r(/([a-z\u0430-\u045F])-(?:(?:\r\n)|(?:\n\r)|\r|\n)([a-z\u0430-\u045F])/g, '$1$2');

                /*// e.g. 1982-
                // 2018
                reg = /(\d)-(?:(?:\r\n)|(?:\n\r)|\r|\n)(\d)/g;
                    text = text.replace(reg, '$1-$2');*/

                // e.g. 1982- 2018, 1982 -2018
                // TODO: пробел после №
                reg = /(?<=[^№\d-])([\d.,:-]+)\s*([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])\s*([\d.,:]+)/g;
                if (reg.test(text)) {
                    console.log(text.match(reg));
                    if ($('#date_intervals').is(':checked')) {
                        text = text.replace(reg, function (match) {
                            match = match.replace(/\s/g, '');
                            let delimiter = match.match(/[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]/)[0];
                            let [start, end] = match.split(delimiter);
                            if (parseInt(start) + 1 === parseInt(end)) {
                                if (delimiter !== "\u002D") {
                                    corrs++;
                                    /*  console.log(delimiter);
                                      console.log("add for \u002D");*/
                                }
                                return `${start}\u002D${end}`;
                            } else {
                                if (delimiter !== "\u2013") {
                                    corrs++;
                                    /*   console.log(delimiter);
                                       console.log("add for \u2013");*/
                                }
                                return `${start}\u2013${end}`;
                            }
                        });
                    } else {
                        text = text.replace(reg, '$1$2$3');
                    }
                }

                // e.g. не конец
                // предложения
                reg = /([^.?! ])(?:(?:\r\n)|(?:\n\r)|\r|\n){1}([^A-Z\u0400-\u0429\u0460-\u04FF])/g;
                if (reg.test(text)) {
                    m = text.match(/ /g);
                    let beforeSpacesNumber = m ? m.length : 0;
                    // console.log('beforeSpacesNumber', beforeSpacesNumber);
                    text = text.replace(reg, '$1 $2');
                    m = text.match(/ /g);
                    let afterSpacesNumber = m ? m.length : 0;
                    corrs += 2 * (afterSpacesNumber - beforeSpacesNumber);
                }

                // e.g. кое-
                // что
                reg = /-­/g;
                if (reg.test(text)) {
                    // corrs += text.match(reg).length;
                    text = text.replace(reg, '-');
                }

                // e.g. пробел плюс
                // перенос строки
                reg = /(?<=[^.?!;:]) ((\r\n)|(\n\r)|\r|\n)(?=[^\n\r])/g;
                console.log(text.match(reg));
                if (reg.test(text)) {
                    text = text.replace(reg, ' ');
                }

                // extra spaces around line breaks
                reg = /\s*((\r\n)|(\n\r)|\r|\n)\s*/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '$1');
                }

                // extra spaces at the beginning of the text
                reg = /^\s*/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '');
                }

                // extra spaces at the end of the text
                reg = /\s*$/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '');
                }

                // double spaces
                reg = /( ){2,}/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '$1');
                }

                // e.g. хз , че за ?
                reg = /(?<=\S)\s+(?=[.,;:?!»%$')\u2019\u201d/\\}\]>@])/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '');
                }

                // e.g. ( скобки), « кавычки»
                reg = /(?<=['(«\u2018\u201e/\\{\[<@§])\s+(?=\S)/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '');
                }

                // e.g. # hashtag, № 5436-2
                if ($('#number_sign').is(':checked')) {
                    reg = /(?<=[№#])\s+(?=\S)/g;
                    if (reg.test(text)) {
                        text = text.replace(reg, '');
                    }
                }

                afterLength = text.length;
                // console.log('afterLength:', afterLength);
                corrs += beforeLength - afterLength;
            }

            // DELETE_EXCESS_LINE_BREAKS
            if ($('#delete_line_breaks').is(':checked')) {
                reg = /((\r\n)|(\n\r)|\r|\n){2,}/g;
                if (reg.test(text)) {
                    beforeLength = text.length;
                    text = text.replace(reg, '$1');

                    // HEADINGS
                    if ($('#headings').is(':checked')) {
                        // search headings
                        reg = /((\r\n)|(\n\r)|\r|\n|^)(\S)([^\r\n]{2,100}[^.])(?=\.?[\r\n]|$)/;
                        console.log(text.match(reg));
                        if (reg.test(text)) {
                            text = text.replace(reg, "$1" + "$2".toUpperCase() + "$3");
                        }
                    }

                    afterLength = text.length;
                    corrs += beforeLength - afterLength;
                }
            } else {
                // TODO !!!
            }

            // ADD_SPACES
            if ($('#add_spaces').is(':checked')) {
                beforeLength = text.length;
                // console.log('beforeLength:', beforeLength);

                // e.g. забыли,зажали.Даже так
                reg = /((?<=\D)[.,;:?!"»%$)])([\w\u0400-\u04FF])/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '$1 $2');
                }

                // e.g. потерянный– пробел с тире
                reg = /([^\s\d])([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])\s/g;
                if (reg.test(text)) {
                    if ($('#dashes').is(':checked')) {
                        m = text.match(/\u2014/g);
                        let beforeDashes = m ? m.length : 0;
                        if ($('#non_breaking_spaces').is(':checked')) {
                            text = text.replace(reg, "$1\u00A0\u2014 ");
                        } else {
                            text = text.replace(reg, "$1 \u2014 ");
                        }
                        m = text.match(/\u2014/g);
                        let afterDashes = m ? m.length : 0;
                        corrs += afterDashes - beforeDashes;
                    } else {
                        if ($('#non_breaking_spaces').is(':checked')) {
                            text = text.replace(reg, "$1\u00A0$2 ");
                        } else {
                            text = text.replace(reg, "$1 $2 ");
                        }
                    }
                }

                // e.g. потерянный –пробел с тире
                reg = /(\s)([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])([^\d ])/g;
                if (reg.test(text)) {
                    if ($('#dashes').is(':checked')) {
                        // console.log(text.match(reg));
                        m = text.match(/\u2014/g);
                        let beforeDashes = m ? m.length : 0;
                        text = text.replace(reg, "$1\u2014 $3");
                        m = text.match(/\u2014/g);
                        let afterDashes = m ? m.length : 0;
                        corrs += afterDashes - beforeDashes;
                    } else {
                        text = text.replace(reg, "$1$2 $3");
                    }
                }

                // e.g. пропущенный(пробел
                reg = /(\S)([#№(«\u2018\u201E{\[<])/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '$1 $2');
                }

                // e.g. пропущенный)пробел
                reg = /([)»\u201d}\]>])([\d\w\u0400-\u04FF])/g;
                if (reg.test(text)) {
                    // console.log(text.match(reg));
                    text = text.replace(reg, '$1 $2');
                }

                afterLength = text.length;
                // console.log('afterLength:', afterLength);
                corrs += afterLength - beforeLength;
            }

            // QUOTES
            if ($('#quotes').is(':checked')) {
                // TODO: !!!
            }

            // APOSTROPHES
            if ($('#apostrophes').is(':checked')) {
                m = text.match(/'/g);
                let beforeApostrophesNumber = m ? m.length : 0;

                // преобразуем всевозможные апострофы к единому виду
                reg = /([\w\u0400-\u04FF])(?:\s?['\u0060\u055A\u07F4\u2019\u02BC\u2018]\s?)([\w\u0400-\u04FF])/g;
                // console.log(text.match(reg));
                if (reg.test(text)) {
                    text = text.replace(reg, "$1'$2");
                }

                m = text.match(/'/g);
                let afterApostrophesNumber = m ? m.length : 0;
                corrs += afterApostrophesNumber - beforeApostrophesNumber;
            }

            // FINAL_PUNCTUATION
            if ($('#final_punctuation').is(':checked')) {
                beforeLength = text.length;

                // убираем лишние точки?!..
                reg = /(?<=(\?!)|(!\?))\.{2,}(?=\s|$)/g;
                if (reg.test(text)) {
                    text = text.replace(reg, ".");
                }

                // убираем лишние точки?.
                reg = /(?<=[!?])\.(?=\s|$)/g;
                if (reg.test(text)) {
                    text = text.replace(reg, "");
                }

                // убираем лишние точки?...
                reg = /(?<=[!?])\.{3,}(?=\s|$)/g;
                if (reg.test(text)) {
                    text = text.replace(reg, "..");
                }

                // убираем лишние точки..
                reg = /(?<=[^!?.])\.{2}(?=\s|$)/g;
                if (reg.test(text)) {
                    text = text.replace(reg, ".");
                }

                // доставить точки в конце абзаца
                reg = /(?<=[\r\n]|^)([\dA-Z\u0400-\u0429\u0460-\u04FF][^\r\n]{101,}[^.?!:;])(?=[\r\n]|$)/g;
                if (reg.test(text)) {
                    m = text.match(/\./g);
                    let beforeDotsNumber = m ? m.length : 0;
                    text = text.replace(reg, "$1.");
                    m = text.match(/\./g);
                    let afterDotsNumber = m ? m.length : 0;
                    // console.log(afterDotsNumber - beforeDotsNumber);
                    corrs += 2 * (afterDotsNumber - beforeDotsNumber);
                }

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }

            // ELLIPSIS
            if ($('#ellipsis').is(':checked')) {
                beforeLength = text.length;

                // заменять много точек многоточием
                reg = /\.{3}/g;
                if (reg.test(text)) {
                    text = text.replace(reg, "\u2026");
                }

                afterLength = text.length;
                corrs += Math.round((beforeLength - afterLength) / 2);
            }

            // NUMBER_SIGN
            if ($('#number_sign').is(':checked')) {
                // заменяем хеш номером
                reg = /#(?=\d)/g;
                if (reg.test(text)) {
                    m = text.match(/№/g);
                    let beforeNumberSignNumber = m ? m.length : 0;
                    text = text.replace(reg, "№");
                    m = text.match(/№/g);
                    let afterNumberSignNumber = m ? m.length : 0;
                    corrs += afterNumberSignNumber - beforeNumberSignNumber;
                }
            }
        }
        $('#processed').val(text);
        $('#corrections__count').text(corrs);
        $('#corrections__word').text(wordend(corrs, ['исправление', 'исправления', 'исправлений']));
    });

    // Init copy button
    new ClipboardJS('#button-copy');
    $('#button-copy').on('click', function (e) {
        e.preventDefault();
    });

});