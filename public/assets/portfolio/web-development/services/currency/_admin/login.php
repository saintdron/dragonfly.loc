<?php
	session_start();
	header("HTTP/1.0 401 Unauthorized");

	require_once '../inc/config.inc.php';
	require_once '../inc/lib.inc.php';
	require_once '../class/users.class.php';

	$msg = '';
	$ref = clearInputStr($_GET['ref']);
	if (!$ref)
		$ref = '/currency/index.php';

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$login = clearInputStr($_POST['login']);
		$pass = clearInputStr($_POST['pass']);
		if ($login && $pass) {
			$users = new Users();
			if (password_verify($pass, $users->getPass($login))) {
				$_SESSION['login'] = true;
				unset($users);
				header("Location: $ref");
				exit;					
			} else {
				$msg = "Неправильный логин или пароль.";
			}
		} else {
			$msg = "Заполните все поля формы.";
		}
	}
?>
<DOCTYPE html>
<html>
	<head>
		<title>Форма авторизации</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<h2>Ваши учетные данные:</h2>
		<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
			<div>
				<label for="login">Логин:</label>
				<input name="login" id="login" value="<?=$_POST['login']?>">
			</div>
			<div>
				<label for="pass">Пароль:</label>
				<input type="password" name="pass" id="pass">
			</div>
			<input type="submit" value="Войти">
			<a href="create_user.php?ref=<?= $ref ?>"><input type="button" value="Зарегистрироваться"></a>
		</form>
		<p style="color: red"><?= $msg ?></p>
	</body>
</html>