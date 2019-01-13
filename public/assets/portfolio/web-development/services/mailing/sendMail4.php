<?php

$attach = array(
    'http://vk-book.ru/img/scroll_mouse.jpg',
    'http://vk-book.ru/img/ugly.png'
);
// чтобы отображалась картинка и ее не было в аттаче
// путь к картинке задается через CID: - Content-ID
// тестовый текст
$text = '
    <div>
        <h1>тело письма с картинкой</h1>
        <h2>Блок по центру</h2>
        <p>
            <img style="float: left; margin-right: 15px; margin-bottom: 15px;" src="cid:scroll_mouse.jpg" width="128" height="128" />
            Какой-то текст вокруг картинки. Какой-то текст вокруг картинки. Какой-то текст вокруг картинки. Какой-то текст вокруг картинки.
        </p>
    </div>
<div style="clear: left"></div>
    <div>
         <p>
            <img style="float: left; margin-right: 15px; margin-bottom: 15px;" src="cid:ugly.png" width="128" height="128" />
            Какой-то текст вокруг картинки. Какой-то текст вокруг картинки. Какой-то текст вокруг картинки. Какой-то текст вокруг картинки.
        </p>
    </div>
';

$from = "saintdronchik@gmail.com";
$to = "saintdron@bigmir.net";
$subject = "Тема письма";

// Заголовки письма === >>>
$headers = "From: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/alternative;\r\n";
$baseboundary = "------------" . strtoupper(md5(uniqid(rand(), true)));
$headers .= "  boundary=\"$baseboundary\"\r\n";
// <<< ====================

// Тело письма === >>>
$message  =  "--$baseboundary\r\n";
$message .= "Content-Type: text/plain;\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= "--$baseboundary\r\n";
$newboundary = "------------" . strtoupper(md5(uniqid(rand(), true)));
$message .= "Content-Type: multipart/related;\r\n";
$message .= "  boundary=\"$newboundary\"\r\n\r\n\r\n";
$message .= "--$newboundary\r\n";
$message .= "Content-Type: text/html; charset=utf-8\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$message .= $text . "\r\n\r\n";
// <<< ==============

// прикрепляем файлы ===>>>
foreach($attach as $filename){
    $mimeType='image/png';
    $fileContent = file_get_contents($filename,true);
    $filename=basename($filename);
    $message.="--$newboundary\r\n";
    $message.="Content-Type: $mimeType;\r\n";
    $message.=" name=\"$filename\"\r\n";
    $message.="Content-Transfer-Encoding: base64\r\n";
    $message.="Content-ID: <$filename>\r\n";
    $message.="Content-Disposition: inline;\r\n";
    $message.=" filename=\"$filename\"\r\n\r\n";
    $message.=chunk_split(base64_encode($fileContent));
}
// <<< ====================

// заканчиваем тело письма, дописываем разделители
$message.="--$newboundary--\r\n\r\n";
$message.="--$baseboundary--\r\n";

// отправка письма
$result = mail($to, $subject, $message , $headers);
var_dump($result);