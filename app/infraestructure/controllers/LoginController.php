<?php
require_once "framework/Config.php";
require_once "framework/Response.php";
require Config::get("models")."User.php";

class LoginController{
	
	public function index(){
		return Response::render("login/login.php");
	}

}