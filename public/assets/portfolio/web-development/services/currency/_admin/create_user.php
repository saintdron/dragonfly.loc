<?
	session_start();
	//header("HTTP/1.0 401 Unauthorized");

	require_once '../inc/config.inc.php';
	require_once '../inc/lib.inc.php';
	require_once '../class/users.class.php';

	const CAPTCHA_URL = '../style/images/dynamic/noise-picture.php';
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Создание пользователя</title>
	<meta charset="utf-8">
	<style>	
		.form-item-container { 
			margin-bottom: 10px;
		}
		
		label {
			display: inline-block;
			width: 150px;
			text-align: right;
		}
		
		#captcha_img {
			margin-left: 115px;
		}
		button {
			vertical-align: top;
		}
		button img {
			width: 20px;
		}
		
	</style>
</head>

<body>
	<h1>Регистрация нового пользователя</h1>
	<?php
		$result = '';

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$login = clearInputStr($_POST['login']);
			$pass = clearInputStr($_POST['pass']);
			$pass2 = clearInputStr($_POST['pass2']);
			$captcha = strtolower(clearInputStr($_POST['captcha']));	
			$ref = clearInputStr($_GET['ref']);
			if (!$ref)
				$ref = '/currency/index.php';
			$users = new Users();
			if (!empty($login) and !empty($pass) and !empty($pass2) and !empty($captcha)) {
				if (!$users->contain($login)) {
					if ($pass === $pass2) {		
						if (isset($_SESSION['captcha']) and $captcha === $_SESSION['captcha']) {	
							$hash = Users::getHash($pass);
							if ($users->add($login, $hash, 'user')) {							
								$_SESSION['login'] = true;
								unset($users);
								//header('Refresh: 1; url=/currency');
								echo "<meta http-equiv='refresh' content='1;url=$ref'>";
								exit("<h3>Пользователь $login успешно зарегистрирован.</h3>");							
							} else {
								$result = 'При регистрации '. $login. ' возникла ошибка.';		
							}
						} else {
							$result = 'Строка не совпала c рисунком.';
						}	
					} else {
						$result = "Пароли не совпадают.";
					}
				} else {
					$result = "Пользователь $login уже существует. Выберите другое имя.";
					//$login = '';
				}		
			} else {
				$result = "Заполните все поля формы.";
			}
		}
	?>
	<h3><?= $result?></h3>
	<form action="<?= $_SERVER['PHP_SELF']?>" method="post">
		<div class="form-item-container">
			<label for="txtUser">Логин</label>
			<input id="txtUser" name="login" value="<?= $login?>" autofocus>
		</div>
		<div class="form-item-container">
			<label for="password">Пароль</label>
			<input id="txtString" type="password" name="pass" id="pass">
		</div>	
		<div class="form-item-container">
			<label for="password2">Пароль еще раз</label>
			<input id="txtString" type="password" name="pass2" id="pass2">
		</div>
		<div class="form-item-container">
			<img id="captcha_img" src="<?= CAPTCHA_URL ?>">
			<button tabindex="-1" onclick="captcha_img.src='<?= CAPTCHA_URL ?>'; 
					 captcha.value=''; captcha.focus(); return false" >
				<img src="../style/images/reload_icon.png">
			</button>
			<div>
				<label for="captcha">Введите строку</label>
				<input name="captcha" id="captcha">
			</div>
		</div>
		<div class="form-item-container">
			<button type="submit">Создать</button>
		</div>	
	</form>
	<?php 
		if (!isset($_SESSION['captcha'])) 
		echo "Для того, чтобы увидеть СAPTCHA необходимо включить показ картинок в настройках браузера.";
	?>
</body>
</html>