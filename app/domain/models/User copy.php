<?php 

require_once "../framework/Connection.php";

class _asdUser{

	private static $table = "users";
	
	static function verifyLogin( $username, $password ){
		$connection = ConnectionDB::connect()->prepare("SELECT * FROM ". self::$table ." WHERE username = '$username' and password = '".self::encrypt($password)."'");
		$connection->execute();
		return $connection->fetch();
	}

	static function create($name, $username, $password, $photoURL){

		$connection = ConnectionDB::connect()->prepare("INSERT INTO users(name, username, password, active, photo) VALUES (:name, :username, :password, 1, :photo);");
		
		$connection->bindParam(":name", $name, PDO::PARAM_STR);
		$connection->bindParam(":username", $username, PDO::PARAM_STR);
		$connection->bindParam(":password", self::encrypt($password), PDO::PARAM_STR);
		$connection->bindParam(":photo", $photoURL, PDO::PARAM_LOB);

		return ($connection->execute())? "ok" : "error";
	}

	static private function encrypt( $value ){
		return crypt($value, '$2a$07$usesomesillystringforsalt$');
	}

	static function users(){
		$connection = ConnectionDB::connect()->prepare("SELECT * FROM ". self::$table ." WHERE active = 1");
		$connection->execute();
		return $connection->fetchAll();
	}

}
