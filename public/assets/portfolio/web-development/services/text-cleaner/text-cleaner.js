jQuery(document).ready(function ($) {

    let prevOriginal = '';

    const ABBR_OPTIONS_COUNT = $('#abbreviations_text option').length;
    const ABBR_OPTIONS_SHOW_LENGTH = 30;
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
        allSelectedText: 'Выбраны все сокращения!',
        buttonText: function (opts, select) {
            if (opts.length === 0) {
                return 'Не выбрано ни одно сокращение!';
            } else if (opts.length === ABBR_OPTIONS_COUNT) {
                return 'Выбраны все сокращения!';
            } else {
                let labels = [];
                opts.each(function () {
                    if ($(this).attr('label') !== undefined) {
                        labels.push($(this).attr('label'));
                    }
                    else {
                        labels.push($(this).html());
                    }
                });
                let result = labels.join(', ');
                return (labels.length > 1 && result.length > ABBR_OPTIONS_SHOW_LENGTH) ? result.match(new RegExp(`^(.{1,${ABBR_OPTIONS_SHOW_LENGTH}})(?=,)`))[0] + ' ...' : result;
            }
        },
        onChange: function (option, checked, select) {
            if (checked) {
                $(option).attr('selected', 'selected');
            } else {
                $(option).removeAttr('selected');
            }
        }
    });

    /* jQuery.values: get or set all of the name/value pairs from child input controls
    * @argument data {array} If included, will populate all child controls.
    * @returns element if data was provided, or array of values if not
    */
    $.fn.values = function (data) {
        let els = $(this).find(':input').get();

        if (typeof data !== 'object') {
            // return all data
            data = {};
            $.each(els, function () {
                if (this.name && !this.disabled && (this.checked
                    || /select|textarea/i.test(this.nodeName)
                    || /text|hidden|password/i.test(this.type))) {
                    if (data[this.name]) {
                        data[this.name] = [].concat(data[this.name], $(this).val());
                    } else {
                        data[this.name] = $(this).val();
                    }
                }
            });
            return data;
        } else {
            $.each(els, function () {
                if (this.name && data[this.name] !== undefined) {
                    if (this.name !== 'abbreviations_text') {
                        if (this.type === 'checkbox' || this.type === 'radio') {
                            $(this).prop("checked", true);
                        } else {
                            $(this).val(data[this.name]);
                        }
                    }
                }
            });

            if (data['abbreviations'] && data['abbreviations_text'] && data['abbreviations_text'].length) {
                data['abbreviations_text'].forEach(v => {
                    $(`.multiselect-native-select option[value='${v}']`).attr("selected", "selected");
                    $(`.multiselect-native-select input[value='${v}']`).prop("checked", true);
                });
            }
            $(`.multiselect-native-select input[value=грн]`).click().click();

            return $(this);
        }
    };

    $.fn.check = function () {
        $(this).parent().parent().find('select, [type=text], [type=button]').prop('disabled', !$(this).prop('checked'));
        if ($('#abbreviations').prop('checked')) {
            $('.multiselect').removeClass('disabled');
        } else {
            $('.multiselect').addClass('disabled');
        }
    };

    $('#button-check-all').on('click', function (e) {
        let $elems = $('[type=checkbox]:not(:disabled)');
        $elems.each(function () {
            if ($(this).attr('name') !== 'abbreviations_text') {
                $(this).prop('checked', true).check();
            }
        });
        $(`.multiselect-native-select input[value=грн]`).click().click();
        process();
        saveOptions();
        e.preventDefault();
    });

    $('#button-uncheck-all').on('click', function (e) {
        let $elems = $('[type=checkbox]:not(:disabled)');
        $elems.each(function () {
            if ($(this).attr('name') !== 'abbreviations_text') {
                $(this).prop('checked', false).check();
            }
        });
        $(`.multiselect-native-select input[value=грн]`).click().click();
        process();
        saveOptions();
        e.preventDefault();
    });

    let options = localStorage.getItem('options');

    function saveOptions() {
        options = $('.text-cleaner form').values();
        localStorage.setItem('options', JSON.stringify(options));
    }

    if (options) {
        options = JSON.parse(options);
        let $elems = $('[type=checkbox]:not(:disabled)');
        $elems.each(function () {
            if ($(this).attr('name') !== 'abbreviations_text') {
                $(this).prop('checked', false);
            }
        });
        $('.text-cleaner form').values(options);
        $elems.each(function () {
            $(this).check();
        });
    } else {
        $('.multiselect-native-select option').prop("selected", "selected");
        $('.multiselect-native-select input').prop("checked", true);
        $('.multiselect-native-select [value=грн]').click().click();
        options = $('.text-cleaner form').values();
    }

    function uniDecode(code) {
        return String.fromCharCode(parseInt(code.slice(2), 16))
    }

    const CLEANED_SOFT_HYPHENATION = [
        "україн ськ", "іо нальн", "прий ня", "реє стр", "проб лем", "фак тичн", "спеціa л", "сис тем",
        "приватно правов", "законо проект", "вро пейс", "транс порт", "взаємо зв'яз", "час тин", "закріп л",
        "зобо в'яз", "вис новк", "особ лив", "пуб лі", "зар плат", "кноп к", "життє здатн", "здійс ню", "віт чизн",
        "пост радян", "зав дан", "трап ля", "конт рол", "інф ляц", "поперед н", "спів прац", "біз несмен", "конс тит",
        "інформа ці", "супереч лив", "зай ня", "нав паки", "будс мен", "на вчан", "фесіо нал", "контр агент", "лю юч",
        "спів роб", "Нац банк", "держ бюджет", "законодав ч", "транс фертн", "транс акц", "транз акц", "юрис кон",
        "охоп л", "прог ноз", "гос подар", "зрос та", "cою з", "cіль ськ", "праце в", "конф лікт"
    ];

    const SOFT_HYPHENATION = new Map([
        ["іональн", "іо\u00ADнальн"],
        ["онн", "он\u00ADн"],
        ["Україн(?=[\u0430-\u045F]{1,2})", "Украї\u00ADн"],
        ["прийня", "прий\u00ADня"],
        ["реєстр(?=[\u0430-\u045F])", "реє\u00ADстр"],
        ["проблем", "проб\u00ADлем"],
        ["фактичн", "фак\u00ADтичн"],
        ["країн(?=[\u0430-\u045F]{3})", "країн\u00AD"],
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
        ["виснов", "вис\u00ADнов"],
        ["прийма", "прий\u00ADма"],
        ["ширш", "шир\u00ADш"],
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
        ["кціон", "к\u00ADціон"],
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
        ["йн(?=[\u0430-\u045F])", "й\u00ADн"],
        ["автомат", "авто\u00ADмат"],
        ["тообіг", "то\u00ADобіг"],
        ["вище(?=[\u0430-\u045F])", "вище\u00AD"],
        ["діє(?=[\u0430-\u045F]{2})", "діє\u00AD"],
        ["часто", "час\u00ADто"],
        ["часті", "час\u00ADті"],
        ["працев", "праце\u00ADв"],
        ["конфлікт", "конф\u00ADлікт"],
        ["([\u0430-\u045F])(цією)", "$1\u00ADцією"],
    ]);

    const HTML_ENTITIES = {
        '&lsaquo;': '\u2039',
        '&rsaquo;': '\u203A',
        '&laquo;': '\u00AB',
        '&raquo;': '\u00BB',
        '&sbquo;': '\u201A',
        '&lsquo;': '\u2018',
        '&rsquo;': '\u2019',
        '&bdquo;': '\u201E',
        '&ldquo;': '\u201C',
        '&rdquo;': '\u201D',
        '&quot;': '\u0022',
        '&prime;': '\u2032',
        '&Prime;': '\u2033',
        '&mdash;': '\u2014',
        '&ndash;': '\u2013',
        '&hellip;': '\u2026',
        '&iexcl;': '\u00A1',
        '&iquest;': '\u00BF',
        '&larr;': '\u2190',
        '&rarr;': '\u2192',
        '&uarr;': '\u2191',
        '&darr;': '\u2193',
        '&lArr;': '\u21D0',
        '&rArr;': '\u21D2',
        '&uArr;': '\u21D1',
        '&dArr;': '\u21D3',
        '&harr;': '\u2194',
        '&hArr;': '\u21D4',
        '&crarr;': '\u21B5',
        '&bull;': '\u2022',
        '&middot;': '\u00B7',
        '&sdot;': '\u22C5',
        '&lowast;': '\u2217',
        '&clubs;': '\u2663',
        '&diams;': '\u2666',
        '&hearts;': '\u2665',
        '&spades;': '\u2660',
        '&loz;': '\u25CA',
        '&nbsp;': '\u00A0',
        '&ensp;': '\u2002',
        '&emsp;': '\u2003',
        '&thinsp;': '\u2009',
        '&zwj;': '\u200D',
        '&zwnj;': '\u200C',
        '&times;': '\u00D7',
        '&divide;': '\u00F7',
        '&frasl;': '\u2044',
        '&minus;': '\u2212',
        '&plusmn;': '\u00B1',
        '&lt;': '\u003C',
        '&gt;': '\u003E',
        '&le;': '\u2264',
        '&ge;': '\u2265',
        '&asymp;': '\u2248',
        '&cong;': '\u2245',
        '&equiv;': '\u2261',
        '&ne;': '\u2260',
        '&deg;': '\u00B0',
        '&frac12;': '\u00BD',
        '&frac14;': '\u00BC',
        '&frac34;': '\u00BE',
        '&sup1;': '\u00B9',
        '&sup2;': '\u00B2',
        '&sup3;': '\u00B3',
        '&amp;': '\u0026',
        '&sim;': '\u223C',
        '&and;': '\u2227',
        '&or;': '\u2228',
        '&not;': '\u00AC',
        '&alefsym;': '\u2135',
        '&ang;': '\u2220',
        '&cap;': '\u2229',
        '&cup;': '\u222A',
        '&sub;': '\u2282',
        '&sube;': '\u2286',
        '&sup;': '\u2283',
        '&supe;': '\u2287',
        '&ni;': '\u220B',
        '&isin;': '\u2208',
        '&notin;': '\u2209',
        '&nsub;': '\u2284',
        '&exist;': '\u2203',
        '&fnof;': '\u0192',
        '&forall;': '\u2200',
        '&infin;': '\u221E',
        '&int;': '\u222B',
        '&micro;': '\u00B5',
        '&nabla;': '\u2207',
        '&part;': '\u2202',
        '&perp;': '\u22A5',
        '&prod;': '\u220F',
        '&prop;': '\u221D',
        '&radic;': '\u221A',
        '&sum;': '\u2211',
        '&empty;': '\u2205',
        '&oplus;': '\u2295',
        '&otimes;': '\u2297',
        '&there4;': '\u2234',
        '&lang;': '\u2329',
        '&rang;': '\u232A',
        '&lceil;': '\u2308',
        '&lfloor;': '\u230A',
        '&rceil;': '\u2309',
        '&rfloor;': '\u230B',
        '&curren;': '\u00A4',
        '&cent;': '\u00A2',
        '&euro;': '\u20AC',
        '&pound;': '\u00A3',
        '&yen;': '\u00A5',
        '&copy;': '\u00A9',
        '&trade;': '\u2122',
        '&reg;': '\u00AE',
        '&sect;': '\u00A7',
        '&brvbar;': '\u00A6',
        '&dagger;': '\u2020',
        '&Dagger;': '\u2021',
        '&image;': '\u2111',
        '&real;': '\u211C',
        '&weierp;': '\u2118',
        '&oline;': '\u203E',
        '&ordf;': '\u00AA',
        '&ordm;': '\u00BA',
        '&para;': '\u00B6',
        '&permil;': '\u2030',
        '&shy;': '\u00AD',
        '&lrm;': '\u200E',
        '&rlm;': '\u200F',
        '&Alpha;': '\u0391',
        '&alpha;': '\u03B1',
        '&Beta;': '\u0392',
        '&beta;': '\u03B2',
        '&Gamma;': '\u0393',
        '&gamma;': '\u03B3',
        '&Delta;': '\u0394',
        '&delta;': '\u03B4',
        '&Epsilon;': '\u0395',
        '&epsilon;': '\u03B5',
        '&Zeta;': '\u0396',
        '&zeta;': '\u03B6',
        '&Eta;': '\u0397',
        '&eta;': '\u03B7',
        '&Theta;': '\u0398',
        '&theta;': '\u03B8',
        '&thetasym;': '\u03D1',
        '&Iota;': '\u0399',
        '&iota;': '\u03B9',
        '&Kappa;': '\u039A',
        '&kappa;': '\u03BA',
        '&Lambda;': '\u039B',
        '&lambda;': '\u03BB',
        '&Mu;': '\u039C',
        '&mu;': '\u03BC',
        '&Nu;': '\u039D',
        '&nu;': '\u03BD',
        '&Xi;': '\u039E',
        '&xi;': '\u03BE',
        '&Omicron;': '\u039F',
        '&omicron;': '\u03BF',
        '&Pi;': '\u03A0',
        '&pi;': '\u03C0',
        '&piv;': '\u03D6',
        '&Rho;': '\u03A1',
        '&rho;': '\u03C1',
        '&Sigma;': '\u03A3',
        '&sigma;': '\u03C3',
        '&sigmaf;': '\u03C2',
        '&Tau;': '\u03A4',
        '&tau;': '\u03C4',
        '&Upsilon;': '\u03A5',
        '&upsilon;': '\u03C5',
        '&upsih;': '\u03D2',
        '&Phi;': '\u03A6',
        '&phi;': '\u03C6',
        '&Chi;': '\u03A7',
        '&chi;': '\u03C7',
        '&Psi;': '\u03A8',
        '&psi;': '\u03C8',
        '&Omega;': '\u03A9',
        '&omega;': '\u03C9',
        '&acute;': '\u00B4',
        '&cedil;': '\u00B8',
        '&circ;': '\u02C6',
        '&macr;': '\u00AF',
        '&tilde;': '\u02DC',
        '&uml;': '\u00A8',
        '&Aacute;': '\u00C1',
        '&aacute;': '\u00E1',
        '&Acirc;': '\u00C2',
        '&acirc;': '\u00E2',
        '&AElig;': '\u00C6',
        '&aelig;': '\u00E6',
        '&Agrave;': '\u00C0',
        '&agrave;': '\u00E0',
        '&Aring;': '\u00C5',
        '&aring;': '\u00E5',
        '&Atilde;': '\u00C3',
        '&atilde;': '\u00E3',
        '&Auml;': '\u00C4',
        '&auml;': '\u00E4',
        '&Ccedil;': '\u00C7',
        '&ccedil;': '\u00E7',
        '&Eacute;': '\u00C9',
        '&eacute;': '\u00E9',
        '&Ecirc;': '\u00CA',
        '&ecirc;': '\u00EA',
        '&Egrave;': '\u00C8',
        '&egrave;': '\u00E8',
        '&ETH;': '\u00D0',
        '&eth;': '\u00F0',
        '&Euml;': '\u00CB',
        '&euml;': '\u00EB',
        '&Iacute;': '\u00CD',
        '&iacute;': '\u00ED',
        '&Icirc;': '\u00CE',
        '&icirc;': '\u00EE',
        '&Igrave;': '\u00CC',
        '&igrave;': '\u00EC',
        '&Iuml;': '\u00CF',
        '&iuml;': '\u00EF',
        '&Ntilde;': '\u00D1',
        '&ntilde;': '\u00F1',
        '&Oacute;': '\u00D3',
        '&oacute;': '\u00F3',
        '&Ocirc;': '\u00D4',
        '&ocirc;': '\u00F4',
        '&OElig;': '\u0152',
        '&oelig;': '\u0153',
        '&Ograve;': '\u00D2',
        '&ograve;': '\u00F2',
        '&Oslash;': '\u00D8',
        '&oslash;': '\u00F8',
        '&Otilde;': '\u00D5',
        '&otilde;': '\u00F5',
        '&Ouml;': '\u00D6',
        '&ouml;': '\u00F6',
        '&Scaron;': '\u0160',
        '&scaron;': '\u0161',
        '&szlig;': '\u00DF',
        '&THORN;': '\u00DE',
        '&thorn;': '\u00FE',
        '&Uacute;': '\u00DA',
        '&uacute;': '\u00FA',
        '&Ucirc;': '\u00DB',
        '&ucirc;': '\u00FB',
        '&Ugrave;': '\u00D9',
        '&ugrave;': '\u00F9',
        '&Uuml;': '\u00DC',
        '&uuml;': '\u00FC',
        '&Yacute;': '\u00DD',
        '&yacute;': '\u00FD',
        '&Yuml;': '\u0178',
        '&yuml;': '\u00FF'
    };


    // TEXT PROCESSING
    function process() {
        let text = $('#original').val();
        prevOriginal = text;
        options = $('.text-cleaner form').values();

        const r = (reg, str) => {
            text = text.replace(reg, str);
        };

        let corrs = 0;
        if (text) {
            let reg, m,
                beforeLength, afterLength;

            // UNICODE TIPS

            // \u0400-\u04FF' Cyrillic all
            // \u0430-\u045F' Cyrillic lowercase
            // \u0400-\u042F\u0460-\u04FF' Cyrillic uppercase

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


            // LISTS(1/2)
            if (options.lists) {
                m = text.match(/•/g);
                let beforeListMarkersNumber = m ? m.length : 0;

                // добавить потерянные маркеры []
                r(/([\r\n])([\uf0fc]\s)(?=\S)/g, '$1• ');

                m = text.match(/•/g);
                let afterListMarkersNumber = m ? m.length : 0;
                corrs += afterListMarkersNumber - beforeListMarkersNumber;
            }

            // TAGS
            if (options.tags) {
                beforeLength = text.length;

                // delete all tags
                r(/<\/?[a-z][^>]*>/gi, '');

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }

            // HTML_ENTITIES
            if (options.html_entities) {
                m = text.match(/&/g);
                let beforeEntitiesNumber = m ? m.length : 0;

                // &nbsp;
                for (let k in HTML_ENTITIES) {
                    r(new RegExp(k, 'g'), HTML_ENTITIES[k]);
                }

                m = text.match(/&/g);
                let afterEntitiesNumber = m ? m.length : 0;
                corrs += beforeEntitiesNumber - afterEntitiesNumber;
            }

            /* MANDATORY */

            // TRAILING_SPACES
            beforeLength = text.length;
            // extra spaces around line breaks
            r(/\s*((\r\n)|(\n\r)|\r|\n)+\s*/g, '$1');
            afterLength = text.length;
            corrs += beforeLength - afterLength;

            // перевод многоточия в три точки
            r(/\u2026/g, '...');

            // перевод неразрывных и других пробелов в обычные
            r(/[\u00A0\uFEFF\u202F\u2007\u2002\u2003\u2009]/g, ' ');

            // перевод неразрывных дефисов в дефис-минусы
            r(/\u2011/g, '-');

            /* END OF MANDATORY */

            // TAB_TO_SPACE
            if (options.tab_to_space) {
                reg = /\t/g;
                m = text.match(reg);
                if (m) {
                    corrs += m.length;
                    r(reg, ' ');
                }
            }


            // PHONE_NUMBERS
            if (options.phone_numbers) {
                reg = /(?:\D|^)(?:(\+)?(3)?([87]))?[-(\s]*(\d{3,5})[-)\s]+(\d{2,3})[-\s]*(\d{2})[-\s]*(\d{2})(?=\D|$)/g;
                let template = options.phone_numbers_text.trim(),
                    templateMatch = template.match(/^(?:(\+)?([XХ])?([XХ]))?([^XХ]+)?([XХ]{3,5})([^XХ]+)([XХ]{2,3})([^XХ]+)([XХ]{2})([^XХ]+)([XХ]{2})$/);
                if (templateMatch) {
                    $('#phone_numbers_text').css('color', '#495057');
                    let [_, t_plus, t_three, t_eight, t_b_code, t_code, t_b_n1, t_n1, t_b_n2, t_n2, t_b_n3, t_n3] = templateMatch;
                    r(reg, function (match) {
                        let [_, plus, three, eight, code, n1, n2, n3] = match.match(/(?:\D|^)(?:(\+)?(3)?([87]))?[-(\s]*(\d{3,5})[-)\s]+(\d{2,3})[-\s]*(\d{2})[-\s]*(\d{2})(?=\D|$)/);
                        corrs++;
                        let result = "" + (t_plus ? plus : '')
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
                        return result ? result : match;
                    });
                } else {
                    $('#phone_numbers_text').css('color', 'red');
                }
            }


            // DELETE_EXCESS_LINE_BREAKS
            if (options.delete_line_breaks) {
                beforeLength = text.length;

                r(/((\r\n)|(\n\r)|\r|\n){2,}/g, '$1');

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }


            // LOWERCASE
            if (options.lowercase) {
                m = text.match(/[a-z\u0430-\u045F]/g);
                let beforeOpenQuotesNumber = m ? m.length : 0;

                // Sentence to lower case
                reg = /([\r\n]|^)([^\r\na-z\u0430-\u045F]+)(?=[\r\n]|$)/g;
                r(reg, function (match) {
                    let [_, $1, $2] = match.match(/([\r\n]|^)([^\r\na-z\u0430-\u045F]+)(?=[\r\n]|$)/);
                    if (options.upper_first) {
                        return match.replace(reg, $1 + $2.slice(0, 1).toUpperCase() + $2.slice(1).toLowerCase());
                    } else {
                        return match.replace(reg, $1 + $2.toLowerCase());
                    }
                });

                m = text.match(/[a-z\u0430-\u045F]/g);
                let afterOpenQuotesNumber = m ? m.length : 0;
                corrs += afterOpenQuotesNumber - beforeOpenQuotesNumber;
            }


            // ABBREVIATIONS
            if (options.abbreviations && options.abbreviations_text) {
                m = text.match(/(грн)|(руб.)|(дол.)|(долл.)|(млрд)|(млн)|(тис.)|(ст.)|(ст.ст.)|(табл.)|(мал.)|(рис.)|(к.ю.н.)|(д.ю.н.)|(к.е.н.)|(к.э.н.)|(д.е.н.)|(д.э.н.)/g);
                let beforeAbbreviationsNumber = m ? m.length : 0;

                // грн
                if (options.abbreviations_text.includes('грн')) {
                    r(/(\d\s)грив[\u0430-\u045F]?н[\u0430-\u045F]*/g, "$1грн");
                }

                // руб.
                if (options.abbreviations_text.includes('руб.')) {
                    r(/(\d\s)рубл[\u0430-\u045F]*/g, "$1руб.");
                }

                // дол.
                if (options.abbreviations_text.includes('дол.')) {
                    reg = /(\d\s)доллар[\u0430-\u045F]*/g;
                    if (/[ыэъ]/.test(prevOriginal)) {
                        // русский
                        r(reg, "$1долл.");
                    } else {
                        // украинский
                        r(reg, "$1дол.");
                    }
                }

                // млрд
                if (options.abbreviations_text.includes('млрд')) {
                    r(/(\d\s)миллиард[\u0430-\u045F]*/g, "$1млрд");
                    r(/(\d\s)мільярд[\u0430-\u045F]*/g, "$1млрд");
                }

                // млн
                if (options.abbreviations_text.includes('млн')) {
                    r(/(\d\s)миллион[\u0430-\u045F]*/g, "$1млн");
                    r(/(\d\s)мільйон[\u0430-\u045F]*/g, "$1млн");
                }

                // тис.
                if (options.abbreviations_text.includes('тис.')) {
                    r(/(\d\s)тысяч[\u0430-\u045F]*/g, "$1тыс.");
                    r(/(\d\s)тисяч[\u0430-\u045F]*/g, "$1тис.");
                }

                // ст.
                if (options.abbreviations_text.includes('ст.')) {
                    r(/стат[\u0430-\u045F]+\s[\d\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63-]+/gi, function (match) {
                        let numbers = match.match(/\d+[\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63-]\d+/g), // 26-35
                            number = match.match(/\d+/g); // 26
                        if (numbers) {
                            if (options.non_breaking_spaces) {
                                return "ст.ст.\u00A0" + numbers;
                            } else {
                                return "ст.ст. " + numbers;
                            }
                        }
                        if (number) {
                            if (options.non_breaking_spaces) {
                                return "ст.\u00A0" + number;
                            } else {
                                return "ст. " + number;
                            }
                        }
                        return match;
                    });
                }

                // табл.
                if (options.abbreviations_text.includes('табл.')) {
                    reg = /таблиц[\u0430-\u045F]+\s(?=\d)/gi;
                    if (options.non_breaking_spaces) {
                        r(reg, "табл.\u00A0");
                    } else {
                        r(reg, "табл. ");
                    }
                }

                // рис., мал.
                if (options.abbreviations_text.includes('мал.')) {
                    reg = /рисун[\u0430-\u045F]+\s(?=\d)/gi;
                    if (options.non_breaking_spaces) {
                        r(reg, "рис.\u00A0");
                    } else {
                        r(reg, "рис. ");
                    }
                    reg = /малюн[\u0430-\u045F]+\s(?=\d)/gi;
                    if (options.non_breaking_spaces) {
                        r(reg, "мал.\u00A0");
                    } else {
                        r(reg, "мал. ");
                    }
                }

                // к.ю.н.
                if (options.abbreviations_text.includes('к.ю.н.')) {
                    r(/канд[\u0430-\u045F.]+\s?юрид[\u0430-\u045F.]+\s?наук/gi, "к.ю.н.");
                }

                // к.е.н., к.э.н.
                if (options.abbreviations_text.includes('к.ю.н.')) {
                    r(/канд[\u0430-\u045F.]+\s?екон[\u0430-\u045F.]+\s?наук/gi, "к.е.н.");
                    r(/канд[\u0430-\u045F.]+\s?экон[\u0430-\u045F.]+\s?наук/gi, "к.э.н.");
                }

                // д.ю.н.
                if (options.abbreviations_text.includes('д.ю.н.')) {
                    r(/докт[\u0430-\u045F.]+\s?юрид[\u0430-\u045F.]+\s?наук/gi, "д.ю.н.");
                }

                // д.е.н., д.э.н.
                if (options.abbreviations_text.includes('к.ю.н.')) {
                    r(/докт[\u0430-\u045F.]+\s?екон[\u0430-\u045F.]+\s?наук/gi, "д.е.н.");
                    r(/докт[\u0430-\u045F.]+\s?экон[\u0430-\u045F.]+\s?наук/gi, "д.э.н.");
                }

                m = text.match(/(грн)|(руб.)|(дол.)|(долл.)|(млрд)|(млн)|(тис.)|(ст.)|(ст.ст.)|(табл.)|(мал.)|(рис.)|(к.ю.н.)|(д.ю.н.)|(к.е.н.)|(к.э.н.)|(д.е.н.)|(д.э.н.)/g);
                let afterAbbreviationsNumber = m ? m.length : 0;
                corrs += afterAbbreviationsNumber - beforeAbbreviationsNumber;
            }


            // DELETE_EXCESS_SPACES
            if (options.delete_spaces) {
                beforeLength = text.length;

                //

                // e.g. Трудове право/
                // Соцзабезпечення
                r(/([/\\])(?:(?:\r\n)|(?:\n\r)|\r|\n)/g, '$1');

                // e.g. кое-
                // как
                r(/([\da-z\u0430-\u045F])-(?:(?:\r\n)|(?:\n\r)|\r|\n)([\da-z\u0430-\u045F])/g, '$1-$2');

                // e.g. 1982- 2018, 1982 -2018
                reg = /([^№\d-]|^)(\d{4})\s*([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])\s*(\d{4})/g;
                if (reg.test(text)) {
                    if (options.date_intervals) {
                        r(reg, function (match) {
                            let [_, lb, from, delimiter, to] = match.match(/([^№\d-]|^)(\d{4})\s*([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])\s*(\d{4})/);
                            if (parseInt(from) + 1 === parseInt(to)) {
                                if (delimiter !== "\u2011") {
                                    corrs++;
                                }
                                return `${lb}${from}\u2011${to}`;
                            } else {
                                if (delimiter !== "\u2013") {
                                    corrs++;
                                }
                                return `${lb}${from}\u2013${to}`;
                            }
                        });
                    } else {
                        r(reg, '$1$2$3$4');
                    }
                }

                // Переносы каретки:
                m = text.match(/ /g);
                let beforeSpacesNumber = m ? m.length : 0;

                // e.g. не конец
                // предложения
                r(/((?:р.)|(?:г.)|[^.?!:; ]) *(?:(?:\r\n)|(?:\n\r)|\r|\n)([^A-Z\d\u0400-\u042F\u0460-\u04FF\u00ab\u201e\u201c\u2018\u0022\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63\u2022\u25E6\u25D8\u2219\u2024\u00B7\r\n-])/g, '$1 $2');

                m = text.match(/ /g);
                let afterSpacesNumber = m ? m.length : 0;
                corrs += afterSpacesNumber - beforeSpacesNumber;

                // extra spaces at the beginning of the text
                r(/^\s*/g, '');

                // extra spaces at the end of the text
                r(/\s*$/g, '');

                // пробелы в конце абзацев
                r(/ *(?=[\r\n])/g, '');

                // double spaces
                r(/( ){2,}/g, '$1');

                // e.g. хз , че за ?
                r(/(\S)\s+(?=[.,;:?!»%)\u2019\u201d/\\}\]>@])/g, '$1');

                // ненужный,
                // перенос
                r(/([,&\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63-])\s+/g, '$1 ');

                // e.g. ( скобки), « кавычки»
                r(/([^/][(«\u2018\u201e/\\{\[<@§])\s+(?=\S)/g, '$1');

                if (options.number_sign) {
                    // e.g. # hashtag, № 5436-2
                    r(/([№#])\s+(?=\S)/g, '$1');

                    // e.g. №5436 -2
                    r(/([№#][\d\w\u0400-\u04FF]+)\s*-\s*(\d)/g, '$1-$2');
                }

                // удаление принудительных переносов, превративщихся в пробел
                CLEANED_SOFT_HYPHENATION.forEach(v => r(new RegExp(v, 'gi'), v.replace(/\s/, '')));

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }


            // ADD_SPACES
            if (options.add_spaces) {
                beforeLength = text.length;

                // e.g. забыли,зажали.Даже так
                r(/(\D)([.,;:?!»%)])([\d\u0400-\u04FF])/g, '$1$2 $3');

                // e.g. потерянный –пробел с тире
                reg = /(\s)([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])([^\d ])/g;
                if (reg.test(text)) {
                    if (options.dashes) {
                        r(reg, "$1\u2014 $3");
                    } else {
                        text = text.replace(reg, "$1$2 $3");
                    }
                }

                // e.g. пропущенный(пробел
                r(/([^\s\d§#№(«\u201E{\[<])([§#№(«\u201E{\[<])/g, '$1 $2');
                // e.g. пропущенный)пробел
                r(/([)»\u201d}\]>])([\w\u0400-\u04FF])/g, '$1 $2');

                // e.g. 1900р рр. г гг
                reg = /(\d)((?:р)|(?:рр)|(?:г)|(?:гг))(\.?)(?=[^\w\u0400-\u04FF'.]|$)/g;
                if (options.punctuation) {
                    r(reg, "$1 $2.");
                } else {
                    r(reg, "$1 $2$3");
                }

                // пп45
                reg = /([^\w\u0400-\u04FF'.]|^)((?:п)|(?:п\.п)|(?:пп)|(?:гл)|(?:ст\.ст)|(?:ст)|(?:ч)|(?:розд)|(?:разд)|(?:рис)|(?:табл)|(?:c)|(?:стор)|(?:стр)|(?:подп)|(?:абз))(\.?)(?=\d)/gi;
                if (options.non_breaking_spaces) {
                    if (options.punctuation) {
                        r(reg, "$1$2.\u00A0");
                    } else {
                        r(reg, "$1$2$3\u00A0");
                    }
                } else {
                    if (options.punctuation) {
                        r(reg, "$1$2. ");
                    } else {
                        r(reg, "$1$2$3 ");
                    }
                }

                // пп.б
                reg = /([^\w\u0400-\u04FF'.]|^)((?:п)|(?:п\.п)|(?:пп)|(?:гл)|(?:ст\.ст)|(?:ст)|(?:ч)|(?:розд)|(?:разд)|(?:рис)|(?:табл)|(?:c)|(?:стор)|(?:стр)|(?:подп)|(?:абз))\.(?=[\w\u0400-\u04FF])/gi;
                if (options.non_breaking_spaces) {
                    r(reg, "$1$2.\u00A0");
                } else {
                    r(reg, "$1$2. ");
                }

                // м.Дарница, ул.Малышка
                reg = /([^\w\u0400-\u04FF'.]|^)((?:м)|(?:г)|(?:вул)|(?:ул)|(?:пгт)|(?:смт))\.(?=[\w\u0400-\u04FF])/gi;
                if (options.non_breaking_spaces) {
                    r(reg, "$1$2.\u00A0");
                } else {
                    r(reg, "$1$2. ");
                }

                // д.45
                reg = /([^\w\u0400-\u04FF'.]|^)(д)\.(?=\d)/gi;
                if (options.non_breaking_spaces) {
                    r(reg, "$1$2.\u00A0");
                } else {
                    r(reg, "$1$2. ");
                }

                // 74000 -> 74 000
                reg = /(^|[^\d№/=])(\d{2,3})(\d{3})(?=\D|$)/g;
                if (options.non_breaking_spaces) {
                    r(reg, "$1$2\u00A0$3");
                } else {
                    r(reg, "$1$2 $3");
                }

                // вернуть назад ст. ст.
                r(/ст\.\s+ст\./gi, 'ст.ст.');
                // вернуть назад п. п.
                r(/п\.\s+п\./gi, 'п.п.');
                // вернуть назад к. ю. н., д. ю. н.
                r(/к\.\s?ю\.\s?н\./g, "к.ю.н.");
                r(/д\.\s?ю\.\s?н\./g, "д.ю.н.");
                r(/к\.\s?е\.\s?н\./g, "к.е.н.");
                r(/д\.\s?е\.\s?н\./g, "д.е.н.");
                r(/к\.\s?э\.\s?н\./g, "к.э.н.");
                r(/д\.\s?э\.\s?н\./g, "д.э.н.");

                afterLength = text.length;
                corrs += afterLength - beforeLength;
            }


            // APOSTROPHES
            if (options.apostrophes) {
                m = text.match(/'/g);
                let beforeApostrophesNumber = m ? m.length : 0;

                // преобразуем всевозможные апострофы к единому виду
                r(/([a-z\u0400-\u04FF])['\u0060\u055A\u07F4\u2019\u02BC\u2018]([a-z\u0400-\u04FF])/gi, "$1'$2");

                m = text.match(/'/g);
                let afterApostrophesNumber = m ? m.length : 0;
                corrs += afterApostrophesNumber - beforeApostrophesNumber;
            }


            // QUOTES
            if (options.quotes) {
                let [oQuote, cQuote] = $('#quotes_text').val().match(/\\\w+/g).map(uniDecode);

                m = text.match(new RegExp(oQuote, 'g'));
                let beforeOpenQuotesNumber = m ? m.length : 0;
                m = text.match(new RegExp(cQuote, 'g'));
                let beforeCloseQuotesNumber = m ? m.length : 0;

                // "открывающая кавычка
                reg = /(^|\s|[/\\])([\u00AB\u2039\u201E\u201A\u201C\u201F\u2018\u201B\u0022])(?=[\w\u0400-\u04FF$§#({\[<])/g;
                r(reg, "$1" + oQuote);

                // закрывающая кавычка"
                reg = /([\w\u0400-\u04FF!?%)}\]>$]) ?([\u00BB\u203A\u201C\u2018\u201D\u2019\u0022]+)(?=$|[^\w\u0400-\u04FF'])/g;
                r(reg, "$1" + cQuote);

                m = text.match(new RegExp(oQuote, 'g'));
                let afterOpenQuotesNumber = m ? m.length : 0;
                m = text.match(new RegExp(cQuote, 'g'));
                let afterCloseQuotesNumber = m ? m.length : 0;
                corrs += afterOpenQuotesNumber - beforeOpenQuotesNumber;
                corrs += afterCloseQuotesNumber - beforeCloseQuotesNumber;
            }


            // YEARS WORD
            if (options.years) {
                m = text.match(/г\.|гг\.|р\.|рр\./g);
                let beforeYearsNumber = m ? m.length : 0;

                // 2001 год
                reg = /(^|\s)(\d{4})\s?год[\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if (options.non_breaking_spaces) {
                    r(reg, "$1$2\u00A0г.");
                } else {
                    r(reg, "$1$2 г.");
                }

                // 2001–2015 года
                reg = /(^|\s)(\d{4}\s?[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\s?\d{4})\s?год[\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if (options.non_breaking_spaces) {
                    r(reg, "$1$2\u00A0гг.");
                } else {
                    r(reg, "$1$2 гг.");
                }

                // 2001 рік/року
                reg = /(^|\s)(\d{4})\s?р[іо][кц][\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if (options.non_breaking_spaces) {
                    r(reg, "$1$2\u00A0р.");
                } else {
                    r(reg, "$1$2 р.");
                }

                // 2001–2015 роки/років
                reg = /(^|\s)(\d{4}\s?[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\s?\d{4})\s?рок[\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if (options.non_breaking_spaces) {
                    r(reg, "$1$2\u00A0рр.");
                } else {
                    r(reg, "$1$2 рр.");
                }

                // 25.07.2014 року
                reg = /(\d{2}\.\d{2}\.\d{4})\s?р[іо][кц][\u0430-\u045F]*(?=[^\u0430-\u045F]|$)/g;
                if (options.non_breaking_spaces) {
                    r(reg, "$1\u00A0р.");
                } else {
                    r(reg, "$1 р.");
                }

                // 25.07.2014 (без року)
                reg = /(\d{2}\.\d{2}\.\d{4})(?=\s?[^рг\s]|$)/g;
                if (options.non_breaking_spaces) {
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
                reg = /\d{4}[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\d{4}(?=\s?[^рг\s]|$)/g;
                r(reg, function (match) {
                    let [_, from, delimiter, to] = match.match(/(\d{4})([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63])(\d{4})/);
                    if (from > 1900 && from < 2050 && to > 1901 && to < 2051 && to > from) {
                        if (options.non_breaking_spaces) {
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
            if (options.punctuation) {
                beforeLength = text.length;

                // убираем лишние точки?!..
                r(/((\?!)|(!\?))\.+(?=\s|$)/g, "$1");

                // убираем лишние точки?.
                r(/([!?])\.(?=\s|$)/g, "$1");

                // убираем лишние точки?...
                r(/([!?])\.{3,}(?=\s|$)/g, "$1..");

                // убираем лишние точки..
                r(/([^!?.])\.{2}(?=\s|$|[^.])/g, "$1.");

                // убираем лишние точки....
                r(/\.{4,}/g, "...");

                m = text.match(/\./g);
                let beforeDotsNumber = m ? m.length : 0;

                // доставить точки в конце абзаца
                r(/([\r\n]|^)([\dA-Z\u0400-\u042F\u0460-\u04FF\u00AB\u2039\u201E\u201A\u201C\u201F\u2018\u201B\u0022\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63-][^\r\n]{81,}[^.:;?!\r\n])(?=[\r\n]|$)/g, "$1$2.");

                // доставить точки в 1900р гг
                r(/(\d)(\s?)((?:р)|(?:рр)|(?:г)|(?:гг))(?=[^\w\u0400-\u04FF'.]|$)/g, "$1$2$3.");

                // доставить точки в п пп гл
                r(/([^\w\u0400-\u04FF'.-]|^)((?:п)|(?:п\.п)|(?:пп)|(?:гл)|(?:ст\.ст)|(?:ст)|(?:ч)|(?:розд)|(?:разд)|(?:табл)|(?:c)|(?:стор)|(?:стр)|(?:подп)|(?:абз))(\s)(?=[\w\u0400-\u04FF])/gi, "$1$2.$3");

                // доставить точки в д 45, рис 5
                r(/([^\w\u0400-\u04FF'.]|^)(д|рис)(\s)(?=\d)/gi, "$1$2.$3");

                // доставить точки в вул пгт
                r(/([^\w\u0400-\u04FF'.]|^)((?:м)|(?:г)|(?:вул)|(?:ул)|(?:пгт)|(?:смт))(\s)(?=[\w\u0400-\u04FF])/gi, "$1$2.$3");

                m = text.match(/\./g);
                let afterDotsNumber = m ? m.length : 0;
                corrs += 2 * (afterDotsNumber - beforeDotsNumber);

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }


            // HEADINGS
            if (options.headings) {

                // search headings
                reg = /((?:\r\n)|(?:\n\r)|\r|\n|^)+([^-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63\u2022\u25E6\u25D8\u2219\u2024\u00B7 ])([^\r\n]{2,80})(?=[\r\n])/g;
                r(reg, function (match) {
                    // удалить точку в конце заголовка.
                    if (options.punctuation && /[^?!. ]\.$/.test(match) && !/\s[рг]+\.$/.test(match)) {
                        corrs++;
                        match = match.slice(0, -1);
                    }
                    // добавить строку и посчитать исправления
                    let firstCharIndex = match.search(/[^\r\n]/);
                    let lineBreaker = match.match(/(?:\r\n)|(?:\n\r)|\r|\n|^/)[0];
                    match = match.slice(firstCharIndex);
                    let index;
                    try {
                        index = prevOriginal.search(match, 'i');
                    } catch (e) {
                        return match;
                    }
                    let matchedReg = /(\S)([^\r\n]{2,80})/;
                    if (!matchedReg.test(match)) {
                        return match;
                    }
                    let [_, $1, $2] = match.match(matchedReg);
                    if (index !== 0) {
                        if (/[\r\n]/.test(prevOriginal[index - 1])) {
                            if (options.delete_line_breaks) {
                                corrs--;
                                if (options.upper_first) {
                                    return match.replace(matchedReg, lineBreaker.repeat(2) + $1.toUpperCase() + $2);
                                } else {
                                    return match.replace(matchedReg, lineBreaker.repeat(2) + $1 + $2);
                                }
                            }
                        } else {
                            corrs++;
                            if (options.upper_first) {
                                return match.replace(matchedReg, lineBreaker.repeat(2) + $1.toUpperCase() + $2);
                            } else {
                                return match.replace(matchedReg, $1 + $1 + $2);
                            }
                        }
                    }
                    if (options.upper_first) {
                        return match.replace(matchedReg, lineBreaker + $1.toUpperCase() + $2);
                    } else {
                        return match.replace(matchedReg, lineBreaker + $1 + $2);
                    }
                });
            }


            // ELLIPSIS
            if (options.ellipsis) {
                r(/\.{3}/g, "\u2026");
            }


            // NUMBER_SIGN
            if (options.number_sign) {
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
            if (options.indices) {
                m = text.match(/[\u00B2\u00B3\u2103]/g);
                let beforeIndicesNumber = m ? m.length : 0;

                // cм²
                if (options.non_breaking_spaces) {
                    r(/(\d) ?см2/g, "$1\u00A0см\u00B2");
                } else {
                    r(/(\d) ?см2/g, "$1 см\u00B2");
                }

                if (options.non_breaking_spaces) {
                    r(/(\d) ?кв(([\u0430-\u045F']* )|(\. ?))см/g, "$1\u00A0см\u00B2");
                } else {
                    r(/(\d) ?кв(([\u0430-\u045F']* )|(\. ?))см/g, "$1 см\u00B2");
                }

                // м²
                if (options.non_breaking_spaces) {
                    r(/(\d) ?м2/g, "$1\u00A0м\u00B2");
                } else {
                    r(/(\d) ?м2/g, "$1 м\u00B2");
                }

                if (options.non_breaking_spaces) {
                    r(/(\d) ?кв(([\u0430-\u045F']* )|(\. ?))м/g, "$1\u00A0м\u00B2");
                } else {
                    r(/(\d) ?кв(([\u0430-\u045F']* )|(\. ?))м/g, "$1 м\u00B2");
                }

                // м³
                if (options.non_breaking_spaces) {
                    r(/(\d) ?м3/g, "$1\u00A0м\u00B3");
                } else {
                    r(/(\d) ?м3/g, "$1 м\u00B3");
                }

                if (options.non_breaking_spaces) {
                    r(/(\d) ?куб(([\u0430-\u045F']* )|(\. ?))м/g, "$1\u00A0м\u00B3");
                } else {
                    r(/(\d) ?куб(([\u0430-\u045F']* )|(\. ?))м/g, "$1 м\u00B3");
                }

                // км²
                if (options.non_breaking_spaces) {
                    r(/(\d) ?км2/g, "$1\u00A0км\u00B2");
                } else {
                    r(/(\d) ?км2/g, "$1 км\u00B2");
                }

                if (options.non_breaking_spaces) {
                    r(/(\d) ?кв(([\u0430-\u045F']* )|(\. ?))км/g, "$1\u00A0км\u00B2");
                } else {
                    r(/(\d) ?кв(([\u0430-\u045F']* )|(\. ?))км/g, "$1 км\u00B2");
                }

                // ℃
                if (options.non_breaking_spaces) {
                    r(/(\d) ?[СC](?=[^\w\u0400-\u04FF'\u02BC])/g, "$1\u00A0\u2103");
                } else {
                    r(/(\d) ?[СC](?=[^\w\u0400-\u04FF'\u02BC])/g, "$1 \u2103");
                }

                m = text.match(/[\u00B2\u00B3\u2103]/g);
                let afterIndicesNumber = m ? m.length : 0;
                corrs += afterIndicesNumber - beforeIndicesNumber;
            }


            // DASHES
            if (options.dashes) {
                // in the middle of a sentence
                reg = /[ \t\u00A0][-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\s/g;
                if (options.non_breaking_spaces) {
                    r(reg, "\u00A0" + `${uniDecode(DASH_SIGN)} `);
                } else {
                    r(reg, ` ${uniDecode(DASH_SIGN)} `);
                }

                // in the start of a paragraph
                reg = /(^|[\n\r])[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63]\s/g;
                r(reg, "$1" + `${uniDecode(DASH_SIGN)} `);
            }


            // FOOTNOTES
            if (options.footnotes) {
                beforeLength = text.length;

                // [9]
                r(/\s?\[\d{1,3}]/g, '');

                afterLength = text.length;
                corrs += beforeLength - afterLength;
            }


            // UPPER_FIRST
            if (options.upper_first) {
                reg = /([\n\r]|^)([a-z\u0430-\u045F])/g;
                r(reg, function (match) {
                    corrs++;
                    let [_, $1, $2] = match.match(/([\n\r]|^)([a-z\u0430-\u045F])/);
                    return match.replace(reg, $1 + $2.toUpperCase());
                });
            }


            // LISTS(2/2)
            if (options.lists) {
                reg = /(\r\n|\n\r|\r|\n)([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63\u2022\u25E6\u25D8\u2219\u2024\u00B7]\s*)(\S[^\r\n]+[^!?.;\r\n])(?=(?:\r\n|\n\r|\r|\n)[-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63\u2022\u25E6\u25D8\u2219\u2024\u00B7]\s[a-z\u0430-\u045F])/g;
                r(reg, function (match) {
                    corrs++;
                    return match + ';';
                });
                reg = /(\r\n|\n\r|\r|\n)([-\u2010\u2012\u2013\u2014\u2043\u2212\u2796\u2E3A\u2E3B\uFE63\u2022\u25E6\u25D8\u2219\u2024\u00B7]\s*)(\S[^\r\n]+[^!?.;\r\n])(?=\r\n|\n\r|\r|\n|$)/g;
                r(reg, function (match) {
                    corrs++;
                    return match + '.';
                });
            }


            // INITIALS
            if (options.initials) {
                const INITIALS_POSITION = $('#initials_text').val();

                // Т. Г. Шевченко
                reg = /([A-Z\u0400-\u042F\u0460-\u04FF][a-z]?\.) ?([A-Z\u0400-\u042F\u0460-\u04FF][a-z]?\.) ?([A-Z\u0400-\u042F\u0460-\u04FF][a-z\u0430-\u045F'\u02BC]+)(?=[^a-z\u0430-\u045F'\u02BC]|$)/g;
                if (INITIALS_POSITION === 'start') {
                    if (options.non_breaking_spaces) {
                        r(reg, "$1\u00A0$2\u00A0$3");
                    } else {
                        r(reg, "$1 $2 $3");
                    }
                } else {
                    if (options.non_breaking_spaces) {
                        r(reg, "$3\u00A0$1\u00A0$2");
                    } else {
                        r(reg, "$3 $1 $2");
                    }
                }

                // Шевченко Т. Г.
                // Не правит в конце предложения, так как невозможно отличить фамилию от первого (заглавного) слова последующего предложения
                reg = /([A-Z\u0400-\u042F\u0460-\u04FF][a-z\u0430-\u045F'\u02BC]+) ([A-Z\u0400-\u042F\u0460-\u04FF][a-z]?\.) ?([A-Z\u0400-\u042F\u0460-\u04FF][a-z]?\.)(?=[^a-z\u0430-\u045F'\u02BC]|$)/g;
                if (INITIALS_POSITION === 'start') {
                    if (options.non_breaking_spaces) {
                        r(reg, "$2\u00A0$3\u00A0$1");
                    } else {
                        r(reg, "$2 $3 $1");
                    }
                } else {
                    if (options.non_breaking_spaces) {
                        r(reg, "$1\u00A0$2\u00A0$3");
                    } else {
                        r(reg, "$1 $2 $3");
                    }
                }
            }


            // NON_BREAKING_SPACES
            if (options.non_breaking_spaces) {
                // 564_енотов, 1_000
                r(/([^/])(\d+)\s([\w\u0400-\u04FF])/g, "$1$2\u00A0$3");

                // XIX століття
                r(/([IVX])\s(?=стол)/g, "$1\u00A0");

                // п._145
                r(/([^\w\u0400-\u04FF'.]|^)((?:п)|(?:п\.п)|(?:пп)|(?:гл)|(?:ст\.ст)|(?:ст)|(?:ч)|(?:розд)|(?:разд)|(?:рис)|(?:табл)|(?:c)|(?:стор)|(?:стр)|(?:подп)|(?:абз))\.\s/gi, "$1$2.\u00A0");

                // м._Київ
                r(/([^\w\u0400-\u04FF'.]|^)((?:м)|(?:г)|(?:вул)|(?:ул)|(?:пгт)|(?:смт))\.\s(?=[\u0400-\u042F\u0460-\u04FF])/gi, "$1$2.\u00A0");

                // д._45
                r(/([^\w\u0400-\u04FF'.]|^)(д)\.\s(?=\d)/gi, "$1$2.\u00A0");

                // И
                // потерялся
                r(/([^a-zA-Z\u0400-\u04FF])([a-zA-Z\u0400-\u04FF])\s([\w\u0400-\u04FF]{2,})/g, "$1$2\u00A0$3");

                // у 6 годині
                r(/([^a-zA-Z\u0400-\u04FF])([a-zA-Z\u0400-\u04FF])\s(\d)/g, "$1$2\u00A0$3");

                // _грн, _руб, _дол
                r(/\s((?:грн)|(?:руб)|(?:дол)|(?:євро)|(?:евро))(?=[^\w\u0400-\u04FF])/g, "\u00A0$1");

                // не переносил
                // бы
                reg = /\s(б[иы]?)([^\w\u0400-\u04FF'\u2011-]|$)/g;
                r(reg, function (match) {
                    if (/[ \u00A0]б[иы]?\s/.test(match)) {
                        return match.replace(reg, "\u00A0$1 ");
                    } else {
                        return match.replace(reg, "\u00A0$1$2");
                    }
                });

                // аналогично_же
                reg = /\s(же?)([^\w\u0400-\u04FF'\u2011-]|$)/g;
                r(reg, function (match) {
                    if (/[ \u00A0]же?\s/.test(match)) {
                        return match.replace(reg, "\u00A0$1 ");
                    } else {
                        return match.replace(reg, "\u00A0$1$2");
                    }
                });
            }


            // SOFT_HYPHENATION
            if (options.soft_hyphenation) {
                // мягкие переносы из массива
                SOFT_HYPHENATION.forEach((v, k) => {
                    r(new RegExp(k, 'g'), v);
                });

                // перенос по дефису
                r(/([a-z\u0400-\u04FF]{3,})-(?=[a-z\u0400-\u04FF]{3,})/gi, "$1-\u00AD");

                // перенос по =
                r(/=/g, "=\u00AD");
            }


            // NON_BREAKING_HYPHEN
            if (options.non_breaking_hyphen) {
                // запретить перенос коротких слов по дефису
                r(/([\w\u0400-\u04FF]{1,2})-(?=[\w\u0400-\u04FF]{1,2})/g, "$1\u2011");

                // 1900-1901, 220-18-03
                r(/(\d{2,})-(?=\d{2,})/g, "$1\u2011");

                // топ-5
                r(/([\w\u0400-\u04FF])-(?=\d)/g, "$1\u2011");

                // №7-б
                r(/(\d)-(?=[\w\u0400-\u04FF])/g, "$1\u2011");
            }

            // CUSTOM_REPLACE
            if (options.custom_replace) {
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

            corrs = (corrs > 0) ? corrs : 0;
        }
        $('#processed').val(text);
        $('#corrections__count').text(corrs);
        $('#corrections__word').text(wordend(corrs, ['изменение', 'изменения', 'изменений']));
    }


    function wordend(num, words) {
        return words[((num % 100 > 10 && num % 100 < 15) || num % 10 > 4 || num % 10 === 0) ? 2 : +(num % 10 !== 1)];
    }

    $('#original').on('input change keyup', function () {
        let text = $('#original').val();
        if (text.length !== prevOriginal.length || text !== prevOriginal) {
            process();
        }
    });
    $('[type=checkbox], [type=text], select').on('change keyup paste', function () {
        process();
        saveOptions();
    });


    $('#original').on('mouseup', function () {
        $('#processed').outerHeight($(this).outerHeight());
    });

    $('#processed').on('mouseup', function () {
        $('#original').outerHeight($(this).outerHeight());
    });

    // Init copy button
    new ClipboardJS('#button-copy');
    $('#button-copy').on('click', function (e) {
        $(this).attr('title', 'Текст скопирован').tooltip('show');
        $(this).on('shown.bs.tooltip', function () {
            setTimeout(function () {
                $('#button-copy').tooltip('dispose');
            }, 2500);
        });
        e.preventDefault();
    });

    $('[type=checkbox]').on('change', function () {
        $(this).check();
    });
});