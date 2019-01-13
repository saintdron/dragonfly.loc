<?php
//error_reporting(0);
const BACKGROUND = '../noise.jpg';
const FONT_DIR = __DIR__ . '/../../fonts/';
const LETTERS_COUNT = 6;

function randString($length) {
	define('LETTERS_SET', '23456789ABCDEFGHIJKLMNOPQRSTUVWXYZ');
	$res = '';
	for ($i = 0; $i < $length; $i++) {
		$res .= LETTERS_SET[rand(0, strlen(LETTERS_SET) - 1)];
	}
	return $res;
}

function randSize() {
	return rand(18, 30);
}

function randAngle() {
	return rand(-45, 45);
}

function randColor($i) {
	return imageColorAllocate($i, rand(0, 125), rand(0, 125), rand(0, 125));
}

function randFont() {
	switch (rand(0, 1)) {
		case 1: $font = 'bellb.ttf'; break;
		default: $font = 'georgia.ttf';
	}
	return FONT_DIR . $font;
}

$i = imageCreateFromJpeg(BACKGROUND);
imageAntiAlias($i, true);
$captcha = randString(LETTERS_COUNT);

for ($n = 0; $n < LETTERS_COUNT; $n++) {
	imagettftext($i, randSize(), randAngle(), 20 + $n * 30, 30, randColor($i), randFont(), $captcha[$n]);
} 

session_start();
$_SESSION['captcha'] = strtolower($captcha);

header('Content-Type: image/jpeg');
imagejpeg($i, null, 50);
imagedestroy($i);