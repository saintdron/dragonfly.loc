jQuery(document).ready(function ($) {

    $.fn.sortSelectByText = function () {
        this.each(function () {
            let selected = $(this).val();
            let $options = $(this).find('option');
            $options.sort((a, b) => $(a).text().localeCompare($(b).text()));
            $(this).html('').append($options);
            $(this).val(selected);
        });
        return this;
    };

    function showCurrentRate() {
        $.ajax({
            method: "POST",
            url: "/assets/portfolio/web-development/services/currency/inc/current_rate.inc.php",
            data: {
                currency: $('#currency').val()
            }
        })
            .done(function (data) {
                $('#current_rate').html((data.length < 20) ? data : 'не удалось получить');
            });
    }

    function showChart() {
        let from = $('#from').val().split('.').reverse().join('-'), // From d.m.Y to Y-m-d
            to = $('#to').val().split('.').reverse().join('-'),
            dateFrom = new Date(from),
            dateTo = new Date(to),
            minDate = new Date(),
            maxDate = new Date();
        maxDate.setMinutes(maxDate.getMinutes() + 60 * 2);
        minDate.setFullYear(minDate.getFullYear() - 20);
        minDate.setDate(minDate.getDate() - 1);
        if (!dateFrom || !dateTo
            || dateFrom < minDate || dateFrom > maxDate
            || dateTo < minDate || dateTo > maxDate) {
            $('#status').text("Неправильный выбор даты").slideDown();
            return false;
        }
        if (dateTo - dateFrom < 2 * 24 * 60 * 60 * 1000) {
            $('#status').text("Слишком короткий временной диапазон").slideDown();
            return false;
        }

        $('#diagram').attr('src', '/assets/portfolio/web-development/services/currency/style/images/dynamic/diagram.php?currency=' +
            $('#currency').val() + '&from=' + from + '&to=' + to).hide();
        $('.cssload-container').show();
        $('#status').text("").hide();
    }

    function loadData() {
        showCurrentRate();
        showChart();
        $('#currency-button').blur();
    }

    $(function () {
        loadData();

        $('form').on('submit', function () {
            showChart();
            return false;
        });

        $('#diagram').on('load', function () {
            $('.cssload-container').hide();
            $(this).show();
        });

        $('#currency').selectmenu({
            change: function () {
                loadData();
            }
        }).sortSelectByText().selectmenu("menuWidget").addClass("overflow");

        $.datepicker.setDefaults({
            showOn: "both",
            buttonImage: "/assets/portfolio/web-development/services/currency/style/images/datepicker-128.png",
            buttonImageOnly: true,
            autoSize: true,
            dateFormat: 'dd.mm.yy',
            monthNames: ["Январь", "Февраль", "Март",
                "Апрель", "Май", "Июнь", "Июль", "Август",
                "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
            monthNamesShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
            dayNames: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
            dayNamesMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
            firstDay: 1,
            changeYear: true,
            changeMonth: true,
            minDate: '-20y',
            maxDate: '0'
        });

        $('#diagram').on('error', function () {
            $('#status').text("Не удалось найти данные за указанный период").slideDown();
            $('.cssload-container').hide();
        });


        $('#from').datepicker();
        $('#to').datepicker();

        $('.ui-datepicker-trigger').attr('title', 'Открыть календарь');
    });
});