<?php

namespace App\Entry_point\Controllers;

use Framework\Response;

class HomeController{
	
	public function __construct(){
	}

	public function index(){

		Response::render("Home/home.php");
	}

}