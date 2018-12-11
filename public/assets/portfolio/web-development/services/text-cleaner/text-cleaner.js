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

    const uniDecode = (code) => String.fromCharCode(parseInt(code.slice(2), 16));

    const CLEANED_SOFT_HYPHENATION = [
        "україн ськ", "краї н", "іо нальн", "прий ня", "реє стр", "проб лем", "фак тичн", "спеціa л", "сис тем",
        "приватно правов", "законо проект", "вро пейс", "транс порт", "взаємо зв'яз", "час тин", "закріп л",
        "зобо в'яз", "вис новк", "особ лив", "пуб лі", "зар плат", "кноп к", "життє здатн", "здійс ню", "віт чизн",
        "пост радян", "зав дан", "трап ля", "конт рол", "інф ляц", "поперед н", "спів прац", "біз несмен", "конс тит",
        "інформа ці", "супереч лив", "зай ня", "нав паки", "будс мен", "на вчан", "фесіо нал", "контр агент", "лю юч",
        "спів роб", "Нац банк", "держ бюджет", "законодав ч", "транс фертн", "транс акц", "транз акц", "юрис кон",
        "охоп л", "прог ноз", "гос подар", "зрос та", "cою з", "cіль ськ"
    ];

    const SOFT_HYPHENATION = new Map([
        ["іональн", "іо\u00ADнальн"],
        ["онн", "он\u00ADн"],
        ["українськ", "україн\u00ADськ"],
        ["Україн(?=[\u0430-\u045F]{1,2})", "Украї\u00ADн"],
        ["прийня", "прий\u00ADня"],
        ["реєстр(?=[\u0430-\u045F])", "реє\u00ADстр"],
        ["проблем", "проб\u00ADлем"],
        ["фактичн", "фак\u00ADтичн"],
        ["країн(?=[\u0430-\u045F])", "краї\u00ADн"],
        ["відео(?=[\u0430-\u045F])", "відео\u00AD"],
        ["видео(?=[\u0430-\u045F])", "видео\u00AD"],
        ["радіо(?=[\u0430-\u045F])", "радіо\u00AD"],
        ["радио(?=[\u0430-\u045F])", "радио\u00AD"],
        ["айма", "ай\u00ADма"],
        ["спеціaл", "спеціa\u00ADл"],
        ["фільтр(?=[\u0430-\u045F])", "фільт\u00ADр"],
        ["оправов", "о\u00ADправов"],
        ["законопроект", "законо\u00ADпроект"],
        ["вропе", "вро\u00ADпе"],
        ["воєнн", "воєн\u00ADн"],
        ["транспорт", "транс\u00ADпорт"],
        ["взаємозв'яз", "взаємо\u00ADзв'яз"],
        ["частин", "час\u00ADтин"],
        ["кріпл", "кріп\u00ADл"],
        ["робля", "роб\u00ADля"],
        ["зобов'я", "зобо\u00ADв'я"],
        ["висновк", "вис\u00ADновк"],
        ["прийма", "прий\u00ADма"],
        ["ширше", "шир\u00ADше"],
        ["навко", "нав\u00ADко"],
        ["особлив", "особ\u00ADлив"],
        ["дієв", "діє\u00ADв"],
        ["публі", "пуб\u00ADлі"],
        ["зарплат", "зар\u00ADплат"],
        ["кнопк", "кноп\u00ADк"],
        ["життєздатн", "життє\u00ADздатн"],
        ["здійсню", "здійс\u00ADню"],
        ["неоднораз", "не\u00ADоднораз"],
        ["вітчизн", "віт\u00ADчизн"],
        ["самоосвіт", "само\u00ADосвіт"],
        ["ростанц", "ро\u00ADстанц"],
        ["означн", "о\u00ADзначн"],
        ["систем", "сис\u00ADтем"],
        ["трансформ", "транс\u00ADформ"],
        ["деяк", "де\u00ADяк"],
        ["пострадян", "пост\u00ADрадян"],
        ["завдан", "зав\u00ADдан"],
        ["трапля", "трап\u00ADля"],
        ["контрол", "конт\u00ADрол"],
        ["інфляц", "інф\u00ADляц"],
        ["банкрут", "банк\u00ADрут"],
        ["попередн", "поперед\u00ADн"],
        ["прийня", "прий\u00ADня"],
        ["регіон(?=[\u0430-\u045F])", "регіо\u00ADн"],
        ["зловжи", "зло\u00ADвжи"],
        ["акціон", "акціо\u00ADн"],
        ["співпрац", "спів\u00ADпрац"],
        ["повноваж", "повно\u00ADваж"],
        ["бізнесмен", "біз\u00ADнес\u00ADмен"],
        ["констит", "конс\u00ADтит"],
        ["формаці", "форма\u00ADці"],
        ["суперечлив", "супереч\u00ADлив"],
        ["передумов", "перед\u00ADумов"],
        ["ексн", "екс\u00ADн"],
        ["зайня", "зай\u00ADня"],
        ["приклад", "прик\u00ADлад"],
        ["дозв", "доз\u00ADв"],
        ["навпаки", "нав\u00ADпаки"],
        ["будсмен", "будс\u00ADмен"],
        ["навчан", "на\u00ADвчан"],
        ["фесіонал", "фесіо\u00ADнал"],
        ["контрагент", "контр\u00ADагент"],
        ["лююч", "лю\u00ADюч"],
        ["редн", "ред\u00ADн"],
        ["співроб", "спів\u00ADроб"],
        ["кошт(?=[\u0430-\u045F])", "кош\u00ADт"],
        ["Нацбанк", "Нац\u00ADбанк"],
        ["держбюд", "держ\u00ADбюд"],
        ["нее", "не\u00ADе"],
        ["суспільн", "су\u00ADспільн"],
        ["законодавч", "законодав\u00ADч"],
        ["трансфертн", "транс\u00ADфертн"],
        ["трансакц", "транс\u00ADакц"],
        ["транзакц", "транз\u00ADакц"],
        ["візн", "віз\u00ADн"],
        ["деяк", "де\u00ADяк"],
        ["своєчас", "своє\u00ADчас"],
        ["значн", "знач\u00ADн"],
        ["юрискон", "юрис\u00ADкон"],
        ["охопл", "охоп\u00ADл"],
        ["прогноз", "прог\u00ADноз"],
        ["господар", "гос\u00ADподар"],
        ["негласн", "не\u00ADгласн"],
        ["зроста", "зрос\u00ADта"],
        ["cоюз(?=[\u0430-\u045F])", "cою\u00ADз"],
        ["cільськ", "cіль\u00ADськ"],
    ]);


    function process() {
        let text = $('#original').val();
        prevOriginal = text;

        const r = (reg, str) => {
            text = text.replace(reg, str);
        };

        let corrs = 0;
        if (text) {
            let reg, m,
                beforeLength, afterLength;

            let options = $('.text-cleaner form').serializeArray();
            console.log(options);

            // UNICODE TIPS

            // \u0400-\u04FF' Cyrillic all
            // \u0430-\u045F' Cyrillic lowercase
            // \u0400-\u0429\u0460-\u04FF' Cyrillic uppercase

            // -\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63 Все тире
            // -(\u002D) Дефис-минус
            // \u2013 Среднее (короткое) тире
            // \u2014 Длинное тире

            // \u00A0 Неразрывный пробел
            // \u2011 Неразрывный дефис
            // \u2026 Многоточие
            // \u2022\u25E6\u25D8\u2219\u2024\u00B7 Круглые маркеры списка
            // \u02BC Модификатор буквы апостроф
            // \u00AD Мягкий перенос

            const DASH_SIGN = $('#dashes_text').val();
            m = text.match(new RegExp(DASH_SIGN, 'g'));
            let beforeDashesNumber = m ? m.length : 0;

            m = text.match(/\u00A0/g);
            let beforeNonBreakingSpacesNumber = m ? m.length : 0;

            m = text.match(/\u2026/g);
            let beforeEllipsisNumber = m ? m.length : 0;

            m = text.match(/\u00AD/g);
            let beforeSoftHyphenNumber = m ? m.length : 0;

            m = text.match(/\u2011/g);
            let beforeNonBreakingHyphenNumber = m ? m.length : 0;


            // TAGS
            if ($('#tags').is(':checked')) {
                beforeLength = text.length;
                // delete all tags
                r(/<\/?[a-z][^>]*>/gi, '');
                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }


            /* MANDATORY */

            // TRAILING_SPACES
            if ($('#trailing_spaces').is(':checked')) {
                beforeLength = text.length;
                // extra spaces around line breaks
                r(/[\t ]*(((\r\n)|(\n\r)|\r|\n)+)[\t ]*/g, '$1');
                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }

            // перевод многоточия в три точки
            r(/\u2026/g, '...');

            // перевод неразрывных и других пробелов в обычные
            r(/[\u00A0\uFEFF\u202F\u2007\u2002\u2003\u2009]/g, ' ');

            // перевод неразрывных дефисов в дефис-минусы
            r(/\u2011/g, '-');

            /* END OF MANDATORY */

            // TAB_TO_SPACE
            if ($('#tab_to_space').is(':checked')) {
                reg = /\t/g;
                m = text.match(reg);
                if (m) {
                    corrs += m.length;
                    r(reg, ' ');
                }
            }


            // PHONE_NUMBERS
            if ($('#phone_numbers').is(':checked')) {
                reg = /(?:\D|^)(?:(\+)?(3)?([87]))?[-(\s]*(\d{3,5})[-)\s]+(\d{2,3})[-\s]*(\d{2})[-\s]*(\d{2})(?=\D|$)/g;
                // console.log(text.match(reg));
                let template = $('#phone_numbers_text').val().trim(),
                    templateMatch = template.match(/(?:(\+)?([XХ])?([XХ]))?([^XХ]+)?([XХ]{3,5})([^XХ]+)([XХ]{2,3})([^XХ]+)([XХ]{2})([^XХ]+)([XХ]{2})/);
                // console.log(template);
                if (templateMatch) {
                    let [_, t_plus, t_three, t_eight, t_b_code, t_code, t_b_n1, t_n1, t_b_n2, t_n2, t_b_n3, t_n3] = templateMatch;
                    /*console.log('t_plus', t_plus);
                    console.log('t_three', t_three);
                    console.log('t_eight', t_eight);
                    console.log('t_b_code', t_b_code);
                    console.log('t_code', t_code);
                    console.log('t_b_n1', t_b_n1);
                    console.log('t_n1', t_n1);
                    console.log('t_b_n2', t_b_n2);
                    console.log('t_n2', t_n2);
                    console.log('t_b_n3', t_b_n3);
                    console.log('t_n3', t_n3);*/

                    r(reg, function (match) {
                        let [_, plus, three, eight, code, n1, n2, n3] = match.match(/(?:(\+)?(3)?([87]))?[-(\s]*(\d{3,5})[-)\s]+(\d{2,3})[-\s]*(\d{2})[-\s]*(\d{2})/);
                        /*console.log(plus);
                        console.log(three);
                        console.log(eight);
                        console.log(code);
                        console.log(n1);
                        console.log(n2);
                        console.log(n3);*/
                        if (plus && three && eight) {
                            corrs++;
                            return "" + (t_plus ? plus : '')
                                + (t_three ? three : '')
                                + (t_eight ? eight : '')
                                + (t_b_code ? t_b_code : '')
                                + (t_code ? code : '')
                                + (t_b_n1 ? t_b_n1 : '')
                                + (t_n1 ? n1 : '')
                                + (t_b_n2 ? t_b_n2 : '')
                                + (t_n2 ? n2 : '')
                                + (t_b_n3 ? t_b_n3 : '')
                                + (t_n3 ? n3 : '');
                        } else {
                            return match;
                        }
                    });
                } else {
                    // TODO: невалидный шаблон
                }
            }


            // DELETE_EXCESS_LINE_BREAKS
            if ($('#delete_line_breaks').is(':checked')) {
                beforeLength = text.length;
                r(/((\r\n)|(\n\r)|\r|\n){2,}/g, '$1');
                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }


            // LOWERCASE
            if ($('#lowercase').is(':checked')) {
                m = text.match(/[a-z\u0430-\u045F]/g);
                let beforeOpenQuotesNumber = m ? m.length : 0;

                // Sentence to lower case
                r(/(?<=[\r\n]|^)([^\r\na-z\u0430-\u045F]+)(?=[\r\n]|$)/g, function (match) {
                    if ($('#upper_first').is(':checked')) {
                        return match.slice(0, 1).toUpperCase() + match.slice(1).toLowerCase();
                    } else {
                        return match.toLowerCase();
                    }
                });

                m = text.match(/[a-z\u0430-\u045F]/g);
                let afterOpenQuotesNumber = m ? m.length : 0;
                corrs += afterOpenQuotesNumber - beforeOpenQuotesNumber;
            }


            // ABBREVIATIONS
            if ($('#abbreviations').is(':checked')) {
                // let abbrText = $('#abbreviations_text').val();

                // грн
                /*if (abbrText.contains(грн)) {

                }*/
                r(/грив[\u0430-\u045F]?н[\u0430-\u045F]*/g, "грн");

                // руб
                r(/рубл[\u0430-\u045F]*/g, "руб.");

                // дол
                reg = /доллар[\u0430-\u045F]*/g;
                if (/[ыэъ]/.test(prevOriginal)) {
                    // русский
                    r(reg, "долл.");
                } else {
                    // украинский
                    r(reg, "дол.");
                }

                // млрд
                r(/миллиард[\u0430-\u045F]*/g, "млрд");
                r(/мільярд[\u0430-\u045F]*/g, "млрд");

                // млн
                r(/миллион[\u0430-\u045F]*/g, "млн");
                r(/мільйон[\u0430-\u045F]*/g, "млн");

                // тис.
                r(/тысяч[\u0430-\u045F]*/g, "тыс.");
                r(/тисяч[\u0430-\u045F]*/g, "тис.");

                // ст.
                r(/стат[\u0430-\u045F]+\s[\d\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63-]+/gi, function (match) {
                    let numbers = match.match(/\d+[\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63-]\d+/g), // 26-35
                        number = match.match(/\d+/g); // 26
                    if (numbers) {
                        if ($('#non_breaking_spaces').is(':checked')) {
                            return "ст.ст.\u00A0" + numbers;
                        } else {
                            return "ст.ст. " + numbers;
                        }
                    }
                    if (number) {
                        if ($('#non_breaking_spaces').is(':checked')) {
                            return "ст.\u00A0" + number;
                        } else {
                            return "ст. " + number;
                        }
                    }
                    return match;
                });

                // табл.
                reg = /таблиц[\u0430-\u045F]+\s(?=\d)/gi;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "табл.\u00A0");
                } else {
                    r(reg, "табл. ");
                }

                // рис.
                reg = /рисун[\u0430-\u045F]+\s(?=\d)/gi;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "рис.\u00A0");
                } else {
                    r(reg, "рис. ");
                }

                // мал.
                reg = /малюн[\u0430-\u045F]+\s(?=\d)/gi;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "мал.\u00A0");
                } else {
                    r(reg, "мал. ");
                }
            }


            // DELETE_EXCESS_SPACES
            if ($('#delete_spaces').is(':checked')) {
                beforeLength = text.length;

                // e.g. Трудове право/
                // Соцзабезпечення
                r(/([/\\])(?:(?:\r\n)|(?:\n\r)|\r|\n)/g, '$1');

                // e.g. кое-
                // как
                r(/([\da-z\u0430-\u045F])-(?:(?:\r\n)|(?:\n\r)|\r|\n)([\da-z\u0430-\u045F])/g, '$1-$2');

                // e.g. 1982- 2018, 1982 -2018
                // reg = /(?<=[^№\d-]|^)([\d.,:-]+)\s*([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])\s*([\d.,:]+)/g;
                reg = /(?<=[^№\d-]|^)(\d{4})\s*([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])\s*(\d{4})/g;
                if (reg.test(text)) {
                    if ($('#date_intervals').is(':checked')) {
                        r(reg, function (match) {
                            match = match.replace(/\s/g, '');
                            let delimiter = match.match(/[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]/)[0];
                            let [start, end] = match.split(delimiter);
                            if (parseInt(start) + 1 === parseInt(end)) {
                                if (delimiter !== "\u2011") {
                                    corrs++;
                                }
                                return `${start}\u2011${end}`;
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
                reg = /([^.?! ]) *(?:(?:\r\n)|(?:\n\r)|\r|\n)([^A-Z\u0400-\u0429\u0460-\u04FF\u00ab\u201e\u201c\u2018\u0022\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63\u2022\u25E6\u25D8\u2219\u2024\u00B7\r\n-])/g;
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
                // r(/-­/g, '-');

                // extra spaces at the beginning of the text
                r(/^\s*/g, '');

                // extra spaces at the end of the text
                r(/\s*$/g, '');

                // double spaces
                r(/( ){2,}/g, '$1');

                // e.g. хз , че за ?
                r(/(?<=\S)\s+(?=[.,;:?!»%)\u2019\u201d/\\}\]>@])/g, '');

                // ненужный,
                // перенос
                r(/([,&\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63-])\s+/g, '$1 ');

                // e.g. ( скобки), « кавычки»
                r(/(?<=[^/][(«\u2018\u201e/\\{\[<@§])\s+(?=\S)/g, '');

                if ($('#number_sign').is(':checked')) {
                    // e.g. # hashtag, № 5436-2
                    r(/(?<=[№#])\s+(?=\S)/g, '');

                    // e.g. №5436 -2
                    r(/([№#][\d\w\u0400-\u04FF]+)\s*-\s*(\d)/g, '$1-$2');
                }

                // удаление принудительных переносов, превративщихся в пробел
                CLEANED_SOFT_HYPHENATION.forEach(v => r(new RegExp(v, 'g'), v.replace(/\s/, '')));

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }


            // ADD_SPACES
            if ($('#add_spaces').is(':checked')) {
                beforeLength = text.length;

                // TODO Аналіз ст. 119 ЗК  почему-то 2 пробела

                // e.g. забыли,зажали.Даже так
                r(/(?<=\D)([.,;:?!»%)])([\d\u0400-\u04FF])/g, '$1 $2');

                // e.g. потерянный– пробел с тире
                reg = /([^\s\d])([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])\s/g;
                if (reg.test(text)) {
                    if ($('#dashes').is(':checked')) {
                        if ($('#non_breaking_spaces').is(':checked')) {
                            r(reg, "$1\u00A0\u2014 ");
                        } else {
                            r(reg, "$1 \u2014 ");
                        }
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
                        r(reg, "$1\u2014 $3");
                    } else {
                        text = text.replace(reg, "$1$2 $3");
                    }
                }

                // e.g. пропущенный(пробел
                r(/([^\s\d§#№(«\u2018\u201E{\[<])([§#№(«\u2018\u201E{\[<])/g, '$1 $2');
                // e.g. пропущенный)пробел
                r(/([)»\u201d}\]>])([\w\u0400-\u04FF])/g, '$1 $2');

                // e.g. 1900р рр. г гг
                reg = /(?<=\d)((?:р)|(?:рр)|(?:г)|(?:гг))(\.?)(?=[^\w\u0400-\u04FF'.]|$)/g;
                if ($('#punctuation').is(':checked')) {
                    r(reg, " $1.");
                } else {
                    r(reg, " $1$2");
                }

                // пп45
                reg = /(?<=[^\w\u0400-\u04FF'.]|^)((?:п)|(?:п\.п)|(?:пп)|(?:гл)|(?:ст\.ст)|(?:ст)|(?:ч)|(?:розд)|(?:разд)|(?:рис)|(?:табл)|(?:c)|(?:стор)|(?:стр)|(?:подп)|(?:абз))(\.?)(?=\d)/gi;
                if ($('#non_breaking_spaces').is(':checked')) {
                    if ($('#punctuation').is(':checked')) {
                        r(reg, "$1.\u00A0");
                    } else {
                        r(reg, "$1$2\u00A0");
                    }
                } else {
                    if ($('#punctuation').is(':checked')) {
                        r(reg, "$1. ");
                    } else {
                        r(reg, "$1$2 ");
                    }
                }

                // пп.б
                reg = /(?<=[^\w\u0400-\u04FF'.]|^)((?:п)|(?:п\.п)|(?:пп)|(?:гл)|(?:ст\.ст)|(?:ст)|(?:ч)|(?:розд)|(?:разд)|(?:рис)|(?:табл)|(?:c)|(?:стор)|(?:стр)|(?:подп)|(?:абз))\.(?=[\w\u0400-\u04FF])/gi;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "$1.\u00A0");
                } else {
                    r(reg, "$1. ");
                }

                // м.Дарница, ул.Малышка
                reg = /(?<=[^\w\u0400-\u04FF'.]|^)((?:м)|(?:г)|(?:вул)|(?:ул)|(?:пгт)|(?:смт))\.(?=[\w\u0400-\u04FF])/gi;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "$1.\u00A0");
                } else {
                    r(reg, "$1. ");
                }

                // д.45
                reg = /(?<=[^\w\u0400-\u04FF'.]|^)((?:б)|(?:д))\.(?=\d)/gi;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "$1.\u00A0");
                } else {
                    r(reg, "$1. ");
                }

                // 74000
                reg = /(?<=^|\D)(\d{2,3})?(\d{3})(?=\D|$)/g;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "$1\u00A0$2");
                } else {
                    r(reg, "$1 $2");
                }

                // вернуть назад ст. ст.
                r(/ст\.\s+ст\./gi, 'ст.ст.');
                // вернуть назад п. п.
                r(/п\.\s+п\./gi, 'п.п.');
                // вернуть назад к. ю. н., д. ю. н.
                r(/к\. ю\. н\./g, "к.ю.н.");
                r(/д\. ю\. н\./g, "д.ю.н.");

                afterLength = text.length;
                corrs += afterLength - beforeLength;
            }


            // QUOTES
            if ($('#quotes').is(':checked')) {
                let [oQuote, cQuote] = $('#quotes_text').val().match(/\\\w+/g).map(uniDecode);

                m = text.match(new RegExp(oQuote, 'g'));
                let beforeOpenQuotesNumber = m ? m.length : 0;
                m = text.match(new RegExp(cQuote, 'g'));
                let beforeCloseQuotesNumber = m ? m.length : 0;

                // "открывающая кавычка
                reg = /(?<=^|\s)([\u00AB\u2039\u201E\u201A\u201C\u201F\u2018\u201B\u0022]+) ?(?=[\w\u0400-\u04FF$§#({\[<])/g;
                r(reg, oQuote);

                // закрывающая кавычка"
                reg = /(?<=[\w\u0400-\u04FF!?%)}\]>$]) ?([\u00BB\u203A\u201C\u2018\u201D\u2019\u0022]+)(?=$|[^\w\u0400-\u04FF'])/g;
                r(reg, cQuote);

                m = text.match(new RegExp(oQuote, 'g'));
                let afterOpenQuotesNumber = m ? m.length : 0;
                m = text.match(new RegExp(cQuote, 'g'));
                let afterCloseQuotesNumber = m ? m.length : 0;
                corrs += afterOpenQuotesNumber - beforeOpenQuotesNumber;
                corrs += afterCloseQuotesNumber - beforeCloseQuotesNumber;
            }


            // APOSTROPHES
            if ($('#apostrophes').is(':checked')) {
                m = text.match(/'/g);
                let beforeApostrophesNumber = m ? m.length : 0;

                // преобразуем всевозможные апострофы к единому виду
                r(/([a-z\u0400-\u04FF])['\u0060\u055A\u07F4\u2019\u02BC\u2018]([a-z\u0400-\u04FF])/gi, "$1'$2");

                m = text.match(/'/g);
                let afterApostrophesNumber = m ? m.length : 0;
                corrs += afterApostrophesNumber - beforeApostrophesNumber;
            }


            // YEARS WORD
            if ($('#years').is(':checked')) {
                m = text.match(/г\.|гг\.|р\.|рр\./g);
                let beforeYearsNumber = m ? m.length : 0;

                // 2001 год
                reg = /(?<=(^|\s)\d{4})\s?год[\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "\u00A0г.");
                } else {
                    r(reg, " г.");
                }

                // 2001–2015 года
                reg = /(?<=(^|\s)\d{4}\s?[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\s?\d{4})\s?год[\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "\u00A0гг.");
                } else {
                    r(reg, " гг.");
                }

                // 2001 рік/року
                reg = /(?<=(^|\s)\d{4})\s?р[іо]к[\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "\u00A0р.");
                } else {
                    r(reg, " р.");
                }

                // 2001–2015 роки/років
                reg = /(?<=(^|\s)\d{4}\s?[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\s?\d{4})\s?рок[\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "\u00A0рр.");
                } else {
                    r(reg, " рр.");
                }

                // 25.07.2014 року
                reg = /(?<=\d{2}\.\d{2}\.\d{4})\s?р[іо]к[\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "\u00A0р.");
                } else {
                    r(reg, " р.");
                }

                // 25.07.2014 (без року)
                reg = /(\d{2}\.\d{2}\.\d{4})(?=\s?[^рг\s]|$)/g;
                if ($('#non_breaking_spaces').is(':checked')) {
                    if (/[ыэъ]/.test(prevOriginal)) {
                        // русский
                        r(reg, "$1\u00A0г.");
                    } else {
                        // украинский
                        r(reg, "$1\u00A0р.");
                    }
                } else {
                    if (/[ыэъ]/.test(prevOriginal)) {
                        r(reg, "$1 г.");
                    } else {
                        r(reg, "$1 р.");
                    }
                }

                // 2000-2015 (без рр.)
                reg = /\d{4}[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\d{4}/g;
                r(reg, function (match) {
                    let [_, from, delimiter, to] = match.match(/(\d{4})([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])(\d{4})/);
                    if (from > 1900 && from < 2050 && to > 1901 && to < 2051 && to > from) {
                        if ($('#non_breaking_spaces').is(':checked')) {
                            return from + delimiter + to + "\u00A0рр.";
                        } else {
                            return from + delimiter + to + " рр.";
                        }
                    }
                    return match;
                });

                m = text.match(/г\.|гг\.|р\.|рр\./g);
                let afterYearsNumber = m ? m.length : 0;
                corrs += afterYearsNumber - beforeYearsNumber;
            }


            // PUNCTUATION
            if ($('#punctuation').is(':checked')) {
                beforeLength = text.length;

                // убираем лишние точки?!..
                r(/(?<=(\?!)|(!\?))\.+(?=\s|$)/g, "");

                // убираем лишние точки?.
                r(/(?<=[!?])\.(?=\s|$)/g, "");

                // убираем лишние точки?...
                r(/(?<=[!?])\.{3,}(?=\s|$)/g, "..");

                // убираем лишние точки..
                r(/(?<=[^!?.])\.{2}(?=\s|$|[^.])/g, ".");

                // убираем лишние точки....
                r(/\.{4,}/g, "...");

                m = text.match(/\./g);
                let beforeDotsNumber = m ? m.length : 0;

                // доставить точки в конце абзаца
                r(/(?<=[\r\n]|^)([\dA-Z\u0400-\u0429\u0460-\u04FF\u00AB\u2039\u201E\u201A\u201C\u201F\u2018\u201B\u0022\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63-][^\r\n]{81,}[^.:;?!\r\n])(?=[\r\n]|$)/g, "$1.");

                // доставить точки в 1900р гг
                r(/(?<=\d)(\s?)((?:р)|(?:рр)|(?:г)|(?:гг))(?=[^\w\u0400-\u04FF'.]|$)/g, "$1$2.");

                // доставить точки в п пп гл
                r(/(?<=[^\w\u0400-\u04FF'.]|^)((?:п)|(?:п\.п)|(?:пп)|(?:гл)|(?:ст\.ст)|(?:ст)|(?:ч)|(?:розд)|(?:разд)|(?:рис)|(?:табл)|(?:c)|(?:стор)|(?:стр)|(?:подп)|(?:абз))(\s)(?=[\w\u0400-\u04FF])/gi, "$1.$2");

                // доставить точки в д 45
                r(/(?<=[^\w\u0400-\u04FF'.]|^)((?:б)|(?:д))(\s)(?=\d)/gi, "$1.$2");

                // доставить точки в вул пгт
                r(/(?<=[^\w\u0400-\u04FF'.]|^)((?:м)|(?:г)|(?:вул)|(?:ул)|(?:пгт)|(?:смт))(\s)(?=[\w\u0400-\u04FF])/gi, "$1.$2");

                m = text.match(/\./g);
                let afterDotsNumber = m ? m.length : 0;
                corrs += 2 * (afterDotsNumber - beforeDotsNumber);

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }


            // HEADINGS
            if ($('#headings').is(':checked')) {

                // search headings
                reg = /((?:\r\n)|(?:\n\r)|\r|\n|^)([^-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63\u2022\u25E6\u25D8\u2219\u2024\u00B7 ])([^\r\n]{2,80})(?=[\r\n])/g;
                r(reg, function (match) {
                    // удалить точку в конце заголовка.
                    if ($('#punctuation').is(':checked') && /[^?!. ]\.$/.test(match) && !/\s[рг]+\.$/.test(match)) {
                        corrs++;
                        match = match.slice(0, -1);
                    }
                    // добавить строку и посчитать исправления
                    let firstCharIndex = match.search(/[^\r\n]/);
                    let lineBreaker = match.slice(0, firstCharIndex);
                    match = match.slice(firstCharIndex);
                    let index = prevOriginal.search(new RegExp(match.replace(/\)/g, '\\)'), 'i')),
                        matchedReg = /(\S)([^\r\n]{2,80})/;
                    if (index !== 0) {
                        if (/[\r\n]/.test(prevOriginal[index - 1])) {
                            if ($('#delete_line_breaks').is(':checked')) {
                                corrs--;
                                if ($('#upper_first').is(':checked')) {
                                    return match.replace(matchedReg, lineBreaker.repeat(2) + "$1".toUpperCase() + "$2");
                                } else {
                                    return match.replace(matchedReg, lineBreaker.repeat(2) + "$1$2");
                                }
                            }
                        } else {
                            corrs++;
                            if ($('#upper_first').is(':checked')) {
                                return match.replace(matchedReg, lineBreaker.repeat(2) + "$1".toUpperCase() + "$2");
                            } else {
                                return match.replace(matchedReg, "$1$1$2$3");
                            }
                        }
                    }
                    if ($('#upper_first').is(':checked')) {
                        return match.replace(matchedReg, lineBreaker + "$1".toUpperCase() + "$2");
                    } else {
                        return match.replace(matchedReg, lineBreaker + "$1$2");
                    }
                });
            }


            // ELLIPSIS
            if ($('#ellipsis').is(':checked')) {
                r(/\.{3}/g, "\u2026");
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


            // INDICES
            if ($('#indices').is(':checked')) {
                m = text.match(/[\u00B2\u00B3\u2103]/g);
                let beforeIndicesNumber = m ? m.length : 0;

                // cм²
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(/(\d) ?см2/g, "$1\u00A0см\u00B2");
                } else {
                    r(/(\d) ?см2/g, "$1 см\u00B2");
                }

                // м²
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(/(\d) ?м2/g, "$1\u00A0м\u00B2");
                } else {
                    r(/(\d) ?м2/g, "$1 м\u00B2");
                }

                // м³
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(/(\d) ?м3/g, "$1\u00A0м\u00B3");
                } else {
                    r(/(\d) ?м3/g, "$1 м\u00B3");
                }

                // км²
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(/(\d) ?км2/g, "$1\u00A0км\u00B2");
                } else {
                    r(/(\d) ?км2/g, "$1 км\u00B2");
                }

                // ℃
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(/(\d) ?[СC](?=[^\w\u0400-\u04FF'\u02BC])/g, "$1\u00A0\u2103");
                } else {
                    r(/(\d) ?[СC](?=[^\w\u0400-\u04FF'\u02BC])/g, "$1 \u2103");
                }

                m = text.match(/[\u00B2\u00B3\u2103]/g);
                let afterIndicesNumber = m ? m.length : 0;
                corrs += afterIndicesNumber - beforeIndicesNumber;
            }


            // DASHES
            if ($('#dashes').is(':checked')) {
                // in the middle of a sentence
                reg = /[ \t\u00A0][-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\s/g;
                if ($('#non_breaking_spaces').is(':checked')) {
                    r(reg, "\u00A0" + `${uniDecode(DASH_SIGN)} `);
                } else {
                    r(reg, ` ${uniDecode(DASH_SIGN)} `);
                }

                // in the start of a paragraph
                reg = /(?<=^|[\n\r])[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\s/g;
                r(reg, `${uniDecode(DASH_SIGN)} `);
            }


            // FOOTNOTES
            if ($('#footnotes').is(':checked')) {
                beforeLength = text.length;

                // [9]
                r(/\s?\[\d{1,3}]/g, '');

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }


            // UPPER_FIRST
            if ($('#upper_first').is(':checked')) {
                reg = /(?<=[\n\r]|^)[a-z\u0430-\u045F]/g;
                r(reg, function (match) {
                    corrs++;
                    return match.toUpperCase();
                });
            }


            // LISTS
            if ($('#lists').is(':checked')) {
                reg = /(?<=(?:[\r\n]|^)[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63\u2022\u25E6\u25D8\u2219\u2024\u00B7]\s*)(\S[^\r\n]+[^!?.;])(?=\s*(?:[\r\n]|$))/g;
                r(reg, function (match) {
                    corrs++;
                    return match + (/[A-Z\u0400-\u0429\u0460-\u04FF]/.test(match[0]) ? '.' : ';');
                });
            }


            // INITIALS
            if ($('#initials').is(':checked')) {
                const INITIALS_POSITION = $('#initials_text').val();

                // Т. Г. Шевченко
                reg = /([A-Z\u0400-\u0429\u0460-\u04FF][a-z]?\.) ?([A-Z\u0400-\u0429\u0460-\u04FF][a-z]?\.) ?([A-Z\u0400-\u0429\u0460-\u04FF][a-z\u0430-\u045F'\u02BC]+)(?=[^a-z\u0430-\u045F'\u02BC]|$)/g;
                if (INITIALS_POSITION === 'start') {
                    if ($('#non_breaking_spaces').is(':checked')) {
                        r(reg, "$1\u00A0$2\u00A0$3");
                    } else {
                        r(reg, "$1 $2 $3");
                    }
                } else {
                    if ($('#non_breaking_spaces').is(':checked')) {
                        r(reg, "$3\u00A0$1\u00A0$2");
                    } else {
                        r(reg, "$3 $1 $2");
                    }
                }

                // Шевченко Т. Г.
                reg = /([A-Z\u0400-\u0429\u0460-\u04FF][a-z\u0430-\u045F'\u02BC]+) ([A-Z\u0400-\u0429\u0460-\u04FF][a-z]?\.) ?([A-Z\u0400-\u0429\u0460-\u04FF][a-z]?\.)(?=[^a-z\u0430-\u045F'\u02BC]|$)/g;
                if (INITIALS_POSITION === 'start') {
                    if ($('#non_breaking_spaces').is(':checked')) {
                        r(reg, "$2\u00A0$3\u00A0$1");
                    } else {
                        r(reg, "$2 $3 $1");
                    }
                } else {
                    if ($('#non_breaking_spaces').is(':checked')) {
                        r(reg, "$1\u00A0$2\u00A0$3");
                    } else {
                        r(reg, "$1 $2 $3");
                    }
                }
            }


            // NON_BREAKING_SPACES
            if ($('#non_breaking_spaces').is(':checked')) {
                // 564_енотов, 1_000
                r(/(\d)\s([\w\u0400-\u04FF])/g, "$1\u00A0$2");

                // п._145
                r(/(?<=[^\w\u0400-\u04FF'.]|^)((?:п)|(?:п\.п)|(?:пп)|(?:гл)|(?:ст\.ст)|(?:ст)|(?:ч)|(?:розд)|(?:разд)|(?:рис)|(?:табл)|(?:c)|(?:стор)|(?:стр)|(?:подп)|(?:абз))\.\s/gi, "$1.\u00A0");

                // м._Київ
                r(/(?<=[^\w\u0400-\u04FF'.]|^)((?:м)|(?:г)|(?:вул)|(?:ул)|(?:пгт)|(?:смт))\.\s/gi, "$1.\u00A0");

                // д._45
                r(/(?<=[^\w\u0400-\u04FF'.]|^)((?:б)|(?:д))\.\s(?=\d)/gi, "$1.\u00A0");

                // И
                // потерялся
                r(/(?<=[^a-zA-Z\u0400-\u04FF])([a-zA-Z\u0400-\u04FF])\s([\w\u0400-\u04FF])/g, "$1\u00A0$2");

                // _грн, _руб, _дол
                r(/\s((?:грн)|(?:руб)|(?:дол)|(?:євро)|(?:евро))(?=[^\w\u0400-\u04FF])/g, "\u00A0$1");

                // не переносил
                // бы
                r(/\s(б[иы]?)(?=[^\w\u0400-\u04FF'\u2011-]|$)/g, "\u00A0$1");
            }


            // SOFT_HYPHENATION
            if ($('#soft_hyphenation').is(':checked')) {
                // мягкие переносы из массива
                SOFT_HYPHENATION.forEach((v, k) => {
                    r(new RegExp(k, 'g'), v);
                });

                // перенос по дефису
                r(/(?<=[a-z\u0400-\u04FF]{3,})-(?=[a-z\u0400-\u04FF]{3,})/gi, "-\u00AD");

                // перенос по =
                r(/=/g, "=\u00AD");
            }


            // NON_BREAKING_HYPHEN
            if ($('#non_breaking_hyphen').is(':checked')) {
                // запретить перенос коротких слов по дефису
                r(/(?<=[\w\u0400-\u04FF]{1,2})-(?=[\w\u0400-\u04FF]{1,2})/g, "\u2011");

                // 1900-1901, 220-18-03
                r(/(?<=\d{2,})-(?=\d{2,})/g, "\u2011");
            }

            // CUSTOM_REPLACE
            if ($('#custom_replace').is(':checked')) {
                let from = $('#custom_replace_from').val(),
                    to = $('#custom_replace_to').val();

                if (from && to) {
                    m = text.match(new RegExp(to, 'gi'));
                    let beforeToNumber = m ? m.length : 0;

                    if (/\/.+\/[a-z]*/.test(from)) {
                        // регулярное выражение
                        let [_, exp, mods] = from.match(/\/(.+)\/([a-z]*)/);
                        r(new RegExp(exp, mods), to);
                    } else {
                        // простая замена
                        r(new RegExp(from, 'gi'), to);
                    }

                    m = text.match(new RegExp(to, 'gi'));
                    let afterToNumber = m ? m.length : 0;
                    corrs += afterToNumber - beforeToNumber;
                }
            }


            /* MANDATORY IN THE END */

            // исправление некоторых нестандартных словосочетаний:
            // юридична особа - підприємець
            reg = /(юридичн[\u0430-\u045F]{1,3}\s*особ[\u0430-\u045F]{1,3}\s*)[\u2014](\s*підприєм)/gi;
            r(reg, "$1\u2013$2");

            /* END OF MANDATORY */

            m = text.match(new RegExp(DASH_SIGN, 'g'));
            let afterDashesNumber = m ? m.length : 0;
            corrs += Math.abs(afterDashesNumber - beforeDashesNumber);

            m = text.match(/\u2026/g);
            let afterEllipsisNumber = m ? m.length : 0;
            corrs += Math.abs(afterEllipsisNumber - beforeEllipsisNumber);

            m = text.match(/\u00A0/g);
            let afterNonBreakingSpacesNumber = m ? m.length : 0;
            corrs += Math.abs(afterNonBreakingSpacesNumber - beforeNonBreakingSpacesNumber);

            m = text.match(/\u00AD/g);
            let afterSoftHyphenNumber = m ? m.length : 0;
            corrs += Math.abs(afterSoftHyphenNumber - beforeSoftHyphenNumber);

            m = text.match(/\u2011/g);
            let afterNonBreakingHyphenNumber = m ? m.length : 0;
            corrs += Math.abs(afterNonBreakingHyphenNumber - beforeNonBreakingHyphenNumber);


            // corrs = (corrs > 0) ? corrs : 0;
        }
        $('#processed').val(text);
        $('#corrections__count').text(corrs);
        // $('#corrections__word').text(wordend(corrs, ['исправление', 'исправления', 'исправлений']));
        $('#corrections__word').text(wordend(corrs, ['изменение', 'изменения', 'изменений']));
    }

    $('#original').on('input change keyup', function () {
        let text = $('#original').val();
        if (text.length !== prevOriginal.length || text !== prevOriginal) {
            process();
        }
    });
    $('[type=checkbox], [type=text], select').on('change keyup paste', process);

    // Init copy button
    new ClipboardJS('#button-copy');
    $('#button-copy').on('click', function (e) {
        $(this).attr('title', 'Скопировано').tooltip('show');
        $(this).on('shown.bs.tooltip', function () {
            setTimeout(function () {
                $('#button-copy').tooltip('dispose');
            }, 2500);
        });
        e.preventDefault();
    });

    $('#button-check-all').on('click', function (e) {
        $('[type=checkbox]:not(:disabled)').prop('checked', true);
        process();
        e.preventDefault();
    });

    $('#button-uncheck-all').on('click', function (e) {
        $('[type=checkbox]:not(:disabled)').prop('checked', false);
        process();
        e.preventDefault();
    });

    $('#abbreviations_text').multiselect({
        // nonSelectedText: 'Не выбраны',
        enableClickableOptGroups: true,
        enableHTML: false,
        // buttonClass: 'btn btn-link',
        // inheritClass: true,
        // dropUp: true,
        checkboxName: function (option) {
            return 'abbreviations_text';
        },
        allSelectedText: 'Выбраны все сокращения...',
        buttonText: function (options, select) {

            if (options.length === 0) {
                return 'Не выбрано ни одно сокращение...';
            }
            else if (options.length === 9) {
                // return 'Выбрано более трех сокращений...';
                return 'Выбраны все сокращения...';
            } else {
                let labels = [];
                options.each(function () {
                    if ($(this).attr('label') !== undefined) {
                        labels.push($(this).attr('label'));
                    }
                    else {
                        labels.push($(this).html());
                    }
                });
                return labels.join(', ') + '';
            }
        }
    });

    $('#abbreviations').on('change', function(e) {
        if ($(this).prop('checked') === false) {
            $('#abbreviations_text').multiselect('disable');
        } else {
            $('#abbreviations_text').multiselect('enable');
        }
    });

});