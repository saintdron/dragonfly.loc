<?php
session_start();
if (!isset($_SESSION['login'])) {
	header("Location: /currency/admin/login.php?ref=" . @$_SERVER['REQUEST_URI']);
	exit;
}
//$_SESSION['login'] = true;