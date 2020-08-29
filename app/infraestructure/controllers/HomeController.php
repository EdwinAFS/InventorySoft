<?php
require_once 'models/view.php';

class HomeController{
	
	public function __construct(){

	}

	public function index(){

		

		View::render("html/modules/main/main.php");
	}

}