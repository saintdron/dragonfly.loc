<?php

date_default_timezone_set("Europe/Kiev");
define("PASSWORD", '$2y$10$SyXC5yI2NyitRZCgScMLmOiaEzFZSV6pxY0JqMMGfI.kd3G1DpXFG');
define("FILE", 'log/sending.log');

//    header("location:sendMailProcess.php");
if (empty($_REQUEST['to']) or empty($_REQUEST['bodyMail']) or empty($_REQUEST['senderEmail'])) {
    header("location: /web-development/services/mailing");
}

//var_dump($_FILES);
$firstname = $_REQUEST['firstname'] ?: '';
$surname = $_REQUEST['surname'] ?: '';
$senderEmail = $_REQUEST['senderEmail'];
$meCopy = $_REQUEST['meCopy'] ? true : false;
$emails = explode(', ', $_REQUEST['to']);
if ($meCopy) {
    $emails[] = $senderEmail;
}
sort($emails, SORT_STRING | SORT_FLAG_CASE);
$subject = $_REQUEST['subject'] ?: '';
$bodyMail = $_REQUEST['bodyMail'];
$access = password_verify($_REQUEST['pass'], '$2y$10$SyXC5yI2NyitRZCgScMLmOiaEzFZSV6pxY0JqMMGfI.kd3G1DpXFG');
$sizeTotal = 0;

// письмо с вложением состоит из нескольких частей, которые разделяются разделителем

// генерируем разделитель
$boundary = "--" . md5(uniqid(time()));

// Заголовки письма === >>>
$headers = "MIME-Version: 1.0;\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
$headers .= "From: $firstname $surname <$senderEmail>\r\n";
$headers .= "Reply-To: $senderEmail\r\n";
// <<< ====================

// Тело письма === >>>
$multipart = "--$boundary\r\n";
$multipart .= "Content-Type: text/html; charset=utf-8\r\n";
$multipart .= "Content-Transfer-Encoding: base64\r\n\r\n";
$multipart .= chunk_split(base64_encode($bodyMail));
$multipart .= "\r\n";

if ($_FILES["fileAttachment"]["name"][0]) {
    // прикрепляем файлы ===>>>
    foreach ($_FILES["fileAttachment"]["name"] as $key => $filename) {
        $mimeType = $_FILES["fileAttachment"]["type"][$key];
        $filepath = $_FILES["fileAttachment"]["tmp_name"][$key];
        $error = $_FILES["fileAttachment"]["error"][$key];
        $size = $_FILES["fileAttachment"]["size"][$key];
        $sizeTotal += $size;
        if ($error === 0 and $sizeTotal < 21000000) {
            $fileContent = file_get_contents($filepath);
            $message_part = "\r\n--$boundary\r\n";
            $message_part .= "Content-Type: $mimeType; name=\"$filename\"\r\n";
            $message_part .= "Content-Transfer-Encoding: base64\r\n";
            $message_part .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
            $message_part .= chunk_split(base64_encode($fileContent));
        } else {
            header("location: /web-development/services/mailing");
        }
    }
    // <<< ====================
    $multipart .= $message_part;
}

// заканчиваем тело письма, дописываем разделители
$multipart .= "\r\n--$boundary--\r\n";


$mailing = function ($email) use ($subject, $multipart, $headers) {
    // отправка письма
    $sent = mail($email, $subject, $multipart, $headers);
    /*var_dump($email);
    var_dump($subject);
    var_dump($headers);
    var_dump($multipart);*/
    file_put_contents(FILE, date('H:i d.m.Y', time()) . " "
        . ($sent ? 'Отправлено' : 'Не удалось отправить') . " "
        . $email . "\r\n", FILE_APPEND);
    return $sent;
};

function simulation()
{
    usleep(50000);
    if (rand(0, 100) > 99) {
        return false;
    }
    return true;
}

$sending = function ($email) use ($access, $mailing) {
    if ($access) {
        return $mailing($email);
    } else {
        return simulation();
    }
};
?>

<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link rel="stylesheet" type="text/css" media="all"
          href="/assets/extra/fontawesome-free-5.4.1-web/css/all.css"/>
    <link rel="stylesheet" href="mailing.css">
</head>
<body class="mailing">
<div class="container-fluid sending">
    <a class="btn-d" href="/web-development/services/mailing"><i class="fas fa-arrow-left"></i> Вернуться</a>
    <table class="table sending-table">
        <thead>
        <th>#</th>
        <th>E-mail</th>
        <th>Статус</th>
        </thead>
        <tbody>
        <?php
        foreach ($emails as $key => $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if ($sending($email)) {
                    $status = 'Отправлено';
                    echo "<tr class='success'>";
                } else {
                    $status = 'Не удалось отправить';
                    echo "<tr class='danger'>";
                }
            } else {
                $status = 'Несуществующий адрес';
                echo "<tr class='danger'>";
            }
            echo "<td>" . ($key + 1) . "</td><td>" . $email . "</td><td>" . $status . "</td>";
            echo "</tr>";
            ob_flush();
            flush();
        }
        ob_end_flush();
        ?>
        </tbody>
    </table>
    <div class="alert alert-warning attention" role="alert">
        <h5>Обратите внимание!</h5>
        <p>В качестве защиты от спам рассылки программа осуществляет отправление писем только в том случае, если
            введен пароль доступа, иначе она лишь симулирует их отправление. Но, чтобы убедить вас в работоспособности
            программы, вы получите копию письма (конечно, если только вы не сняли галочку «Отправить мне
            копию письма»).</p>
        <p>Если вы заметили ошибку или у вас есть предложение по улучшению данной программы, пожалуйста,
            используйте <a href="{{ route('cv') . '#feedback' }}">форму&nbsp;обратной&nbsp;связи</a>.</p>
    </div>
    <a class="btn-d" href="/web-development/services/mailing"><i class="fas fa-arrow-left"></i> Вернуться</a>
</div>
</body>