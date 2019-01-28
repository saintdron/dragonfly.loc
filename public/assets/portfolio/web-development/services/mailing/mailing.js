jQuery(document).ready(function ($) {

    let emaillist = [];

    if (sessionStorage.emaillist) {
        emaillist = JSON.parse(sessionStorage.emaillist);
        $('#to').val(emaillist.join(', '));
    }

    $('#to').on('change keyup paste', function () {
        sessionStorage.emaillist = JSON.stringify($(this).val().split(',').map(v => v.trim()));
    });

    $('#fileForm')[0].reset();

    $('.relative-group input[type=text]').attr('disabled', 'disabled');

    const re = /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i;
    const reEasy = /(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))/i;
    let to = document.getElementById("to");
    let subject = document.getElementById("subject");
    let firstname = document.getElementById("firstname");
    let surname = document.getElementById("surname");
    let senderEmail = document.getElementById("senderEmail");
    let status = document.getElementById("status");


    $("#bodyMail").summernote({
        lang: 'ru-RU',
        height: 300,
        minHeight: 200,
        maxHeight: 400,
//		focus:true,
//		placeholder:'Введите данные',
        toolbar: [
            //[groupname,[list buttons]]
            // ['insert', ['picture', 'link', 'video', 'table']],
            ['insert', ['link', 'table']],
            ['style', ['bold', 'italic', 'underline']],
//			['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize', 'fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'style']],
            ['height', ['height', 'codeview']]
        ],
        disableDragAndDrop: true
    });

    // Fix summernote bag
    $('.note-popover').css('top', '-100px');

    if (localStorage.subjectS) subject.value = localStorage.subjectS;
    if (localStorage.bodyMailS) $("#bodyMail").summernote('code', localStorage.bodyMailS);
    if (localStorage.firstnameS) firstname.value = localStorage.firstnameS;
    if (localStorage.surnameS) surname.value = localStorage.surnameS;
    if (localStorage.senderEmailS) senderEmail.value = localStorage.senderEmailS;

    to.focus();

    let alertTimerId = null;
    const showStatus = () => {
        alertTimerId = setTimeout(function () {
            $('#status').slideUp();
        }, 5000);
    };

    $('#sendForm').on('click', '[type=submit]', function (e) {
        let $alert = $(status).find('ul');
        $alert.text('');
        if (to.value.trim() === "") {
            $alert.append("<li>Не указан адресат</li>");
        }
        if (to.value.trim() && !reEasy.test(to.value.trim())) {
            $alert.append("<li>Электронная почта адресата указана неверно</li>");
        }
        if ($("#bodyMail").summernote('code') === "<p><br></p>"
            || $("#bodyMail").summernote('code') === "") {
            $alert.append("<li>Отсутствует тело письма</li>");
        }
        if (senderEmail.value.trim() === "") {
            $alert.append("<li>Не указана электронная почта отправителя</li>");
        }
        if (senderEmail.value.trim() && !re.test(senderEmail.value.trim())) {
            $alert.append("<li>Электронная почта отправителя указана неверно</li>");
        }
        saveInfo();
        if ($alert.text()) {
            clearTimeout(alertTimerId);
            $('#status').slideDown(showStatus);
            return false;
        }
    });

    $('#baseupload').on('change', function () {
        let file = this.files[0];
        if (file.type !== 'application/vnd.ms-excel') {
            alert('Неправильный формат файла.\nПожалуйста, выберите файл с расширением .CSV');
            return false;
        }
        saveInfo();
        $('#fileForm').submit();
    });

    function saveInfo() {
        localStorage.subjectS = subject.value;
        localStorage.bodyMailS = $("#bodyMail").summernote('code');
        localStorage.firstnameS = firstname.value;
        localStorage.surnameS = surname.value;
        localStorage.senderEmailS = senderEmail.value;
    }

});
