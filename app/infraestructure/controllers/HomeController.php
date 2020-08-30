<?php
require_once '../framework/Response.php';

class HomeController{
	
	public function __construct(){
	}

	public function index(){

		Response::render("Home/home.php");
	}

}