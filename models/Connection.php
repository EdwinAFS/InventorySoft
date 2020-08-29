<?php 

class ConnectionDB{
	
	public static $server = "localhost";
	public static $database = "pos";
	public static $username = "root";
	public static $password = "";

	public static function connect(){
		
		$link = new PDO( 
			"mysql:host=". self::$server . ";dbname=" . self::$database, 
			self::$username, 
			self::$password
		);

		$link->exec("set names utf8");

		return $link;

	}

}
