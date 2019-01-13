<?php
	//require_once 'inc/session.inc.php';
	require_once 'inc/config.inc.php';
	require_once 'inc/lib.inc.php';
	require_once 'class/exchange.class.php';

	const DIAGRAM_URL = 'style/images/dynamic/diagram.php';

	if (isset($_GET['logout'])) {
		session_destroy();	
		header("Location: admin/login.php");
		exit;
	}
	
	$msg = '';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$currency = clearInputStr($_POST['currency']);		
		$dateFrom = new DateTime($_POST['from']);
		$dateTo = new DateTime($_POST['to']);
	} else {
		$currency = 'USD';	
		$dateFrom = new DateTime('2 week ago');
		$dateTo = new DateTime();
	}	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Курс валют</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="style/css/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="currency/index.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script src="script/index.js"></script>
		<style>
		</style>
		<script>	
			'use strict';
		</script>		
	</head>
	<body>
		<p>
			<a href="<?=$_SERVER['PHP_SELF']?>?logout"><input type="button" id="logout" value="Выйти из сессии"></a>
		</p>
		<h2>Курс валют</h2>
		<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
			<div class="form-item-container">
				<label for="currency">Валюта:</label>
				<select name="currency" id="currency">
					<?php
						$exchange = new Exchange();	
			   			$exchange->loadCurrenciesList();
			   			foreach ($exchange::$currencies as $curr=>$text) {
							$selected = ($curr === $currency) ? 'selected' : '';
							echo "<option value='$curr' $selected>$text [$curr]</option>";
						}
					?>				
				</select>
			</div>
			<div class="form-item-container current_rate">
				<p>Текущий курс: <span id="current_rate"></span></p>
			</div>			
			<div class="form-item-container period">
				<p>Динамика изменения курса вплоть до 20 последних лет: 
					<br><em>Для получения более точных значений рекомендуется сузить временной диапазон</em>
				</p>
				<label for="from">С</label>
				<input name="from" id="from" type="text" value="<?= $dateFrom->format('d.m.Y')?>">
				<label for="to">по</label>
				<input name="to" id="to" type="text" value="<?= $dateTo->format('d.m.Y')?>">
				<input type="submit" value="Показать">
			</div>
			<div id="msg"><?= $msg ?></div>
			<div class="form-item-container chart">
				<?php 
					require_once "inc/chart.inc.php";
				?>
			</div>
		</form>
	</body>
</html>