<?php
require_once '../../../class/diagram.class.php';
require_once '../../../inc/config.inc.php';
require_once '../../../inc/lib.inc.php';

const FONT_DIR = __DIR__ . '/../../fonts/',
	FONT_SIZE = 16,
	IMAGE_SIZE = [1000, 460],
	BACKGROUND_COLOR = [237, 233, 217],
	COLUMN_COLOR = [52, 179, 160],
	AXIS_COLOR = [147, 141, 128],
	LIGHT_COLOR = [221, 216, 195],
	MAX_RATE_Y = 100,
	MIN_RATE_Y = 320,
	AXIS_DATE_Y = 392,
	AXIS_UAH_X = 108,
	CONT_RECT = ['top' => 32, 'right' => 954, 'bottom' => 390, 'left' => 108];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$currency = clearInputStr($_GET['currency']);
	$from = clearInputStr($_GET['from']);
	$to = clearInputStr($_GET['to']);
	
//	$currency = 'AZN';
//	$from = '20180501';
//	$to = '20180520';	
	
	$diagram = new Diagram($currency, $from, $to);
	$diagram->press();
}

