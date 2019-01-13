<?php
class Users {
	const BASE_URL = 'mysite.local';
	const BASE_NAME = 'currency';
	const BASE_LOGIN = 'root';
	const BASE_PASS = '';
	
	private $mysqli;
	
	static function getHash($pass) {
		return password_hash($pass, PASSWORD_DEFAULT);
	}
	
	function __construct() {
		$this->mysqli = new mysqli(self::BASE_URL, self::BASE_LOGIN, self::BASE_PASS, self::BASE_NAME);
		if ($this->mysqli->connect_error) 
			die('Ошибка подключения (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
	}
	
	function __destruct() {
		$this->mysqli->close();
	}
	
	function add($login, $pass, $grants) {
		//$pass = self::getHash($pass);
		if (!$grants) 
			$grants = 'guest';
		if ($this->contain($login))
			return false;
		$sql = "INSERT INTO users (login, pass, grants)
					VALUES (?, ?, ?)";
		$stmt = $this->mysqli->prepare($sql);
		$stmt->bind_param("sss", $login, $pass, $grants);
		$stmt->execute();
		if ($this->mysqli->error) 
			die('Ошибка базы данных (' . $this->mysqli->errno . ') ' . $this->mysqli->error);
		$stmt->close();
		return true;
	}
	
	function contain($login) {
		$sql = "SELECT login
					FROM users
					WHERE login = '$login'";
		$res = $this->mysqli->query($sql);
		if (!$res)
			die('Ошибка базы данных (' . $this->mysqli->errno . ') ' . $this->mysqli->error);
		return !!$res->fetch_row()[0];
	}
	
	function getPass($login) {
		$sql = "SELECT pass
					FROM users
					WHERE login = '$login'";
		$res = $this->mysqli->query($sql);
		if (!$res)
			die('Ошибка базы данных (' . $this->mysqli->errno . ') ' . $this->mysqli->error);
		return $res->fetch_row()[0];
	}

}

//$users = new Users();
//$users->_add('saintdron', 'dronishe', 'admin');
//unset($users);