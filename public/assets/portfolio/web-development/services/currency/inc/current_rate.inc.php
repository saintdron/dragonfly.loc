<?php 
require_once 'lib.inc.php';
require_once '../class/exchange.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$currency = clearInputStr($_POST['currency']);
	$exchange = new Exchange();
	$date = new DateTime('now');
	$c = $exchange->getCurrency($currency, $date);
	$r = $c->rate;
	if ($r > 1.0) {
		$r = number_format(floatval($c->rate), 2, ".", " ");
	} else if ($r > 0.01) {
		$r = number_format(floatval($c->rate), 5, ".", " ");
	}
	
	echo "$r грн";
}