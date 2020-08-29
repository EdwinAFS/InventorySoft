<?php 

class ConnectionDB{
	
	public static function connect(){
		
		$link = new PDO( 
			"mysql:host=". Config::get("dbhost") . ";dbname=" . Config::get("dbname"), 
			Config::get("dbusername"), 
			Config::get("dbpassword")
		);

		$link->exec("set names utf8");

		return $link;

	}

}
