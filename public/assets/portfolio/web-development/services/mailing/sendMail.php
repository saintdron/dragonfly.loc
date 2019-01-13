<?php

$subject = "тема письма";

$message ="Текст сообщения";
// текст сообщения, здесь вы можете вставлять таблицы, рисунки, заголовки, оформление цветом и т.п.

$filename = "JavaScriptEvents.html";
// название файла

$filepath = "files/JavaScriptEvents.html";
// месторасположение файла

$user_email = "saintdron@bigmir.net";
$firstname = "Андрей";
$lastname = "Семянович";
$to = "saintdronchik@gmail.com";

// письмо с вложением состоит из нескольких частей, которые разделяются разделителем

$boundary = "--".md5(uniqid(time()));
// генерируем разделитель

$mailheaders = "MIME-Version: 1.0;\r\n";
$mailheaders .="Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
// разделитель указывается в заголовке в параметре boundary

$mailheaders .= "From: $firstname $lastname <$user_email>\r\n";
$mailheaders .= "Reply-To: $user_email\r\n";

$multipart = "--$boundary\r\n";
$multipart .= "Content-Type: text/html; charset=windows-1251\r\n";
$multipart .= "Content-Transfer-Encoding: base64\r\n";
$multipart .= "\r\n";
//$multipart .= chunk_split(base64_encode(iconv("utf8", "windows-1251", $message)));
$multipart .= chunk_split(base64_encode($message));
// первая часть само сообщение

// Закачиваем файл
	$fp = fopen($filepath,"r");
		if (!$fp)
		{
			print "Не удается открыть файл.";
			exit();
		}
$file = fread($fp, filesize($filepath));
fclose($fp);
// чтение файла


$message_part = "\r\n--$boundary\r\n";
$message_part .= "Content-Type: application/octet-stream; name=\"$filename\"\r\n";
$message_part .= "Content-Transfer-Encoding: base64\r\n";
$message_part .= "Content-Disposition: attachment; filename=\"$filename\"\r\n";
$message_part .= "\r\n";
$message_part .= chunk_split(base64_encode($file));
$message_part .= "\r\n--$boundary--\r\n";
// второй частью прикрепляем файл, можно прикрепить два и более файла

$multipart .= $message_part;

mail($to,$subject,$multipart,$mailheaders);
// отправляем письмо

//удаляем файлы через 60 сек.
if (time_nanosleep(60, 0)) {
		unlink($filepath);
}