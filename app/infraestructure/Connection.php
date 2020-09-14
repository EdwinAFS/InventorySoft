<?php

namespace App\Infraestructure;

use framework\Config;
use PDO;

class Connection{
	
	public static function connect(){
		
		$link = new PDO( 
			"mysql:host=". Config::get("dbhost") . ";dbname=" . Config::get("dbname"), 
			Config::get("dbusername"), 
			Config::get("dbpassword")
		);

		$link->exec("set names utf8");

		$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $link;

	}

}
