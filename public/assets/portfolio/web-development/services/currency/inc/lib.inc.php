<?php
//require_once 'config.inc.php';

function clearInputStr($str) {
	return trim(strip_tags($str));
}

function clearInputInt($val) {
	return parseInt(trim($val));
}