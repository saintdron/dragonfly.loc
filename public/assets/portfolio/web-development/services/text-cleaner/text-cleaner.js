jQuery(document).ready(function ($) {

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

    // Copy to clipboard
    new ClipboardJS('#button-copy');
    $('#button-copy').on('click', function (e) {
        e.preventDefault();
    });

    // Text processing
    /*const output_elem = $('#processed');
    const output = (text) => {
        output_elem.val(text);
    };*/

    function wordend(num, words) {
        return words[((num % 100 > 10 && num % 100 < 15) || num % 10 > 4 || num % 10 === 0) ? 2 : +(num % 10 !== 1)];
    }

    var prevOriginal = '';

    $('#original').on('input change keyup', function () {
        // console.log('1');
        let text = $(this).val();
        if (text.length === prevOriginal.length && text === prevOriginal) {
            return false;
        }
        prevOriginal = text;
        // console.log('2');

        let corrs = 0;
        if (text) {

            let reg, m,
                beforeLength, afterLength;

            // tab_to_space
            if ($('#tab_to_space').is(':checked')) {
                reg = /\t/g;
                m = text.match(reg);
                if (m) {
                    corrs += m.length;
                    text = text.replace(reg, ' ');
                }
            }

            // delete_line_breaks
            if ($('#delete_line_breaks').is(':checked')) {
                reg = /((\r\n)|(\n\r)|\r|\n){2,}/g;
                // let testReg = /(\r\n)|(\n\r)|\r|\n/g;
                // m = text.match(reg);
                if (reg.test(text)) {
                    // console.log('true');
                    beforeLength = text.length;
                    text = text.replace(reg, '$1');
                    afterLength = text.length;
                    corrs += beforeLength - afterLength;
                }
            }

            // delete_spaces
            if ($('#delete_spaces').is(':checked')) {
                beforeLength = text.length;
                console.log('beforeLength:', beforeLength);

                // \u0400-\u04FF Cyrillic all
                // \u0430-\u045F' Cyrillic lowercase

                // some forced hyphenation
                reg = /([a-z\u0430-\u045F])-(?:(?:\r\n)|(?:\n\r)|\r|\n)([a-z\u0430-\u045F])/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '$1$2');
                }
                reg = /([^.?!;:])(?:(?:\r\n)|(?:\n\r)|\r|\n)([^A-Z\u0400-\u0429\u0460-\u04FF])/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '$1 $2');
                }
                reg = /([.?!;])(?:(?:\r\n)|(?:\n\r)|\r|\n)([a-z\u0430-\u045F])/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '$1 $2');
                }
                reg = /-­/g;
                if (reg.test(text)) {
                    text = text.replace(reg, '-');
                }
                reg = /(?<=[^.?!;:]) ((\r\n)|(\n\r)|\r|\n)/g;
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

                afterLength = text.length;
                console.log('afterLength:', afterLength);
                corrs += beforeLength - afterLength;
            }
        }
        $('#processed').val(text);
        $('#corrections__count').text(corrs);
        $('#corrections__word').text(wordend(corrs, ['исправление', 'исправления', 'исправлений']));
    });


});