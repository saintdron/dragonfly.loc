function change() {
    if ($('td>input[type=checkbox]:checked').length === $('td>input[type=checkbox]:not(:disabled)').length) {
        $('th>input[type="checkbox"]').prop('checked', true);
    } else {
        $('th>input[type="checkbox"]').prop('checked', false);
    }
    $('#reallySelect').text($('td>input[type=checkbox]:checked').length);
}

$('.problemEmail').on('blur', function () {
    re = /(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))/gi;
    let newValue = '';
    newValue = $(this).parent().html().match(re);
    if (newValue) {
        newValue = newValue.join(', ');
    }
    $(this).parent().parent().children('td:first-child').children('input[type="checkbox"]').attr('value', newValue);
    tester = re.test($(this).text());
    if (!tester) {
        $(this).addClass('redSpan');
        if (newValue === null) {
            $(this).parent().parent().children('td:first-child').children('input[type="checkbox"]').prop('checked', false);
            $(this).parent().parent().children('td:first-child').children('input[type="checkbox"]').attr('disabled', 'disabled');
            $(this).parent().parent().removeClass('success');
            $(this).parent().parent().addClass('danger');
        }
    } else {
        $(this).removeClass('redSpan');
        $(this).parent().parent().children('td:first-child').children('input[type="checkbox"]').removeAttr("disabled");
        $(this).parent().parent().removeClass('danger');
    }
});

$('.problemEmail').on('keypress', function (e) {
    if (e.key === "Enter" || e.key === " ") {
        return false;
    }
});

$('td>input[type="checkbox"]').on('change', function () {
    if (this.checked) {
        $(this).parent().parent().addClass('success');
    } else {
        $(this).parent().parent().removeClass('success');
    }
    change();
});

$('th>input[type="checkbox"]').on('change', function () {
    if (this.checked) {
        $('td>input[type="checkbox"]').prop('checked', true);
        $('td>input[type="checkbox"]').parent().parent().addClass('success');
        $('td>input[type="checkbox"]:disabled').prop('checked', false);
        $('td>input[type="checkbox"]:disabled').parent().parent().removeClass('success');
    } else {
        $('td>input[type="checkbox"]').prop('checked', false);
        $('td>input[type="checkbox"]').parent().parent().removeClass('success');
    }
    $('#reallySelect').text($('td>input[type=checkbox]:checked').length);
});

$('#selectFromTo').on('click', function () {
    let selectFrom = $('#selectFrom').val();
    let selectTo = $('#selectTo').val();
    $('td>input[type="checkbox"]:checked').prop('checked', false);
    for (let i = selectFrom - 1; i < selectTo; i++) {
        let selector = 'td>input[type="checkbox"]:eq(' + i + ')';
        $(selector).prop('checked', true);
        $(selector).parent().parent().addClass('success');
        $(selector + ':disabled').prop('checked', false);
        $(selector + ':disabled').parent().parent().removeClass('success');
    }
    change();
});

$('#selectFrom').on('change', function () {
    if (Number($(this).val()) < 1 || isNaN(Number($(this).val()))) {
        $(this).val(1);
    }
});

$('#selectTo').on('change', function () {
    if (Number($(this).val()) > Number($('.numberColumn:last').html())
        || isNaN(Number($(this).val()))) {
        $(this).val(Number($('.numberColumn:last').html()));
    }
});

$('#emaillist').on('submit', function (e) {
    e.preventDefault();
    let emaillist = [];
    $('tbody input[type=checkbox]:checked').each(function () {
        let mail = $(this).val().split(',').map(v => v.trim());
        emaillist = emaillist.concat(mail);
    });
    sessionStorage.emaillist = JSON.stringify(emaillist);
    window.location = '/web-development/services/mailing';
});