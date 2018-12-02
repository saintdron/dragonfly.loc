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

    let prevOriginal = '';

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
            // \u2026 Многоточие

            // MANDATORY
            // extra spaces around line breaks
            beforeLength = text.length;
            r(/[\t ]*(((\r\n)|(\n\r)|\r|\n)+)[\t ]*/g, '$1');
            afterLength = text.length;
            corrs += beforeLength - afterLength;

            // временный перевод многоточия в три точки
            r(/\u2026/g, '...');

            // TAB_TO_SPACE
            if ($('#tab_to_space').is(':checked')) {
                reg = /\t/g;
                m = text.match(reg);
                if (m) {
                    corrs += m.length;
                    r(reg, ' ');
                }
            }

            // DELETE_EXCESS_LINE_BREAKS
            if ($('#delete_line_breaks').is(':checked')) {
                beforeLength = text.length;
                r(/((\r\n)|(\n\r)|\r|\n){2,}/g, '$1');
                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }

            // DELETE_EXCESS_SPACES
            if ($('#delete_spaces').is(':checked')) {
                beforeLength = text.length;
                // console.log('beforeLength:', beforeLength);

                // e.g. Трудове право/
                // Соцзабезпечення
                r(/([/\\])(?:(?:\r\n)|(?:\n\r)|\r|\n)/g, '$1');

                // e.g. кое-
                // как
                r(/([\da-z\u0430-\u045F])-(?:(?:\r\n)|(?:\n\r)|\r|\n)([\da-z\u0430-\u045F])/g, '$1-$2');

                // e.g. 1982- 2018, 1982 -2018
                reg = /(?<=[^№\d-]|^)([\d.,:-]+)\s*([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])\s*([\d.,:]+)/g;
                if (reg.test(text)) {
                    if ($('#date_intervals').is(':checked')) {
                        r(reg, function (match) {
                            match = match.replace(/\s/g, '');
                            let delimiter = match.match(/[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]/)[0];
                            let [start, end] = match.split(delimiter);
                            if (parseInt(start) + 1 === parseInt(end)) {
                                if (delimiter !== "\u002D") {
                                    corrs++;
                                }
                                return `${start}\u002D${end}`;
                            } else {
                                if (delimiter !== "\u2013") {
                                    corrs++;
                                }
                                return `${start}\u2013${end}`;
                            }
                        });
                    } else {
                        r(reg, '$1$2$3');
                    }
                }

                // e.g. не конец
                // предложения
                reg = /([^.?! ]) *(?:(?:\r\n)|(?:\n\r)|\r|\n)([^A-Z\u0400-\u0429\u0460-\u04FF'\u00ab\u201e\u201c\u2018\u0022\r\n])/g;
                // console.log('not end sentence', text.match(reg));
                if (reg.test(text)) {
                    m = text.match(/ /g);
                    let beforeSpacesNumber = m ? m.length : 0;
                    r(reg, '$1 $2');
                    m = text.match(/ /g);
                    let afterSpacesNumber = m ? m.length : 0;
                    corrs += afterSpacesNumber - beforeSpacesNumber;
                }

                // e.g. кое--
                // что (принудительный перенос слова с дефисом)
                r(/-­/g, '-');

                // extra spaces at the beginning of the text
                r(/^\s*/g, '');

                // extra spaces at the end of the text
                r(/\s*$/g, '');

                // double spaces
                r(/( ){2,}/g, '$1');

                // апостро ' фы
                r(/([a-z\u0400-\u04FF])\s*(')\s*([a-z\u0400-\u04FF])/gi, '$1$2$3');

                // e.g. хз , че за ?
                r(/(?<=\S)\s+(?=[.,;:?!»%)\u2019\u201d/\\}\]>@])/g, '');

                // ненужный,
                // перенос
                r(/([,&])\s+/g, '$1 ');

                // e.g. ( скобки), « кавычки»
                r(/(?<=[(«\u2018\u201e/\\{\[<@§])\s+(?=\S)/g, '');

                if ($('#number_sign').is(':checked')) {
                    // e.g. # hashtag, № 5436-2
                    r(/(?<=[№#])\s+(?=\S)/g, '');

                    // e.g. №5436 -2
                    r(/([№#][\d\w\u0400-\u04FF]+)\s*-\s*(\d)/g, '$1-$2');
                }

                afterLength = text.length;
                // console.log('afterLength:', afterLength);
                corrs += beforeLength - afterLength;
            }

            // ADD_SPACES
            if ($('#add_spaces').is(':checked')) {
                beforeLength = text.length;
                // console.log('beforeLength:', beforeLength);

                // e.g. забыли,зажали.Даже так
                r(/((?<=\D)[.,;:?!»%)])([\w\u0400-\u04FF])/g, '$1 $2');

                // e.g. потерянный– пробел с тире
                reg = /([^\s\d])([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])\s/g;
                if (reg.test(text)) {
                    if ($('#dashes').is(':checked')) {
                        m = text.match(/\u2014/g);
                        let beforeDashes = m ? m.length : 0;
                        if ($('#non_breaking_spaces').is(':checked')) {
                            r(reg, "$1\u00A0\u2014 ");
                        } else {
                            r(reg, "$1 \u2014 ");
                        }
                        m = text.match(/\u2014/g);
                        let afterDashes = m ? m.length : 0;
                        corrs += afterDashes - beforeDashes;
                    } else {
                        if ($('#non_breaking_spaces').is(':checked')) {
                            r(reg, "$1\u00A0$2 ");
                        } else {
                            r(reg, "$1 $2 ");
                        }
                    }
                }

                // e.g. потерянный –пробел с тире
                reg = /(\s)([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])([^\d ])/g;
                if (reg.test(text)) {
                    if ($('#dashes').is(':checked')) {
                        m = text.match(/\u2014/g);
                        let beforeDashes = m ? m.length : 0;
                        r(reg, "$1\u2014 $3");
                        m = text.match(/\u2014/g);
                        let afterDashes = m ? m.length : 0;
                        corrs += afterDashes - beforeDashes;
                    } else {
                        text = text.replace(reg, "$1$2 $3");
                    }
                }

                // e.g. пропущенный(пробел
                r(/(\S)([§#№(«\u2018\u201E{\[<])/g, '$1 $2');

                // e.g. пропущенный)пробел
                r(/([)»\u201d}\]>])([\w\u0400-\u04FF])/g, '$1 $2');

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
                r(/([a-z\u0400-\u04FF])\s?['\u0060\u055A\u07F4\u2019\u02BC\u2018]\s?([a-z\u0400-\u04FF])/gi, "$1'$2");

                m = text.match(/'/g);
                let afterApostrophesNumber = m ? m.length : 0;
                corrs += afterApostrophesNumber - beforeApostrophesNumber;
            }

            // FINAL_PUNCTUATION
            if ($('#final_punctuation').is(':checked')) {
                beforeLength = text.length;

                // убираем лишние точки?!..
                r(/(?<=(\?!)|(!\?))\.+(?=\s|$)/g, "");

                // убираем лишние точки?.
                r(/(?<=[!?])\.(?=\s|$)/g, "");

                // убираем лишние точки?...
                r(/(?<=[!?])\.{3,}(?=\s|$)/g, "..");

                // убираем лишние точки..
                r(/(?<=[^!?.])\.{2}(?=\s|$)/g, ".");

                // доставить точки в конце абзаца
                reg = /(?<=[\r\n]|^)([\dA-Z\u0400-\u0429\u0460-\u04FF][^\r\n]{101,}[^.?!\r\n])(?=[\r\n]|$)/g;
                // console.log('add dotes:', text.match(reg));
                if (reg.test(text)) {
                    m = text.match(/\./g);
                    let beforeDotsNumber = m ? m.length : 0;
                    r(reg, "$1.");
                    m = text.match(/\./g);
                    let afterDotsNumber = m ? m.length : 0;
                    corrs += 2 * (afterDotsNumber - beforeDotsNumber);
                }

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }

            // HEADINGS
            if ($('#headings').is(':checked')) {
                // beforeLength = text.length;

                // search headings
                reg = /((?:\r\n)|(?:\n\r)|\r|\n|^)(\S)([^\r\n]{2,100})(?=[\r\n])/g;
                // console.log(text.match(reg));
                r(reg, function (match) {
                    // удалить точку в конце заголовка.
                    if ($('#final_punctuation').is(':checked') && /[^?!. ]\.$/.test(match)) {
                        corrs++;
                        match = match.slice(0, -1);
                    }

                    let index = prevOriginal.search(match);
                    // console.log(index);
                    // console.log(!/(\r\n)|(\n\r)|\r|\n/.test(prevOriginal[index - 1]));
                    if (index !== 0) {
                        if (!/(\r\n)|(\n\r)|\r|\n/.test(prevOriginal[index - 1])) {
                            // console.log('not r');
                            corrs++;
                            return match.replace(/((?:\r\n)|(?:\n\r)|\r|\n|^)(\S)([^\r\n]{2,100})/, "$1$1" + "$2".toUpperCase() + "$3");
                        } else {
                            // console.log('r');
                            if ($('#delete_line_breaks').is(':checked')) {
                                corrs--;
                                return match.replace(/((?:\r\n)|(?:\n\r)|\r|\n|^)(\S)([^\r\n]{2,100})/, "$1$1" + "$2".toUpperCase() + "$3");
                            } else {
                                return match.replace(/((?:\r\n)|(?:\n\r)|\r|\n|^)(\S)([^\r\n]{2,100})/, "$1" + "$2".toUpperCase() + "$3");
                            }
                        }
                    }
                    // console.log('0 index');
                    return match.replace(/((?:\r\n)|(?:\n\r)|\r|\n|^)(\S)([^\r\n]{2,100})/, "$1" + "$2".toUpperCase() + "$3");
                });

                // afterLength = text.length;
                // corrs += beforeLength - afterLength;
            }

            // ELLIPSIS
            if ($('#ellipsis').is(':checked')) {
                m = prevOriginal.match(/\u2026/g);
                let beforeEllipsisNumber = m ? m.length : 0;

                // заменять много точек многоточием
                reg = /\.{3}/g;
                if (reg.test(text)) {
                    r(reg, "\u2026");
                }

                m = text.match(/\u2026/g);
                let afterEllipsisNumber = m ? m.length : 0;
                corrs += afterEllipsisNumber - beforeEllipsisNumber;
            }

            // NUMBER_SIGN
            if ($('#number_sign').is(':checked')) {
                // заменяем хеш номером
                reg = /# *(?=\d)/g;
                if (reg.test(text)) {
                    m = text.match(/№/g);
                    let beforeNumberSignNumber = m ? m.length : 0;
                    r(reg, "№");
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