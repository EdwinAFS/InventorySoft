<?php
require_once "../framework/Config.php";
require_once "../framework/Response.php";
require_once Config::get("models")."User.php";

class LoginController{
	
	public function index(){
		return Response::show("login/login.php");
	}

	public function autenticate(){
	
		if( $this->validateCredencials() ){
			
			$username = $_POST["username"];
			$password = $_POST["password"];
			
			$user = User::verifyLogin( $username, $password );

			if( ! $user ){
				return Response::json( [
					"error" => true,
					'message' => 'Credenciales incorrectas.'
				] , 401);
			}

			$_SESSION["isAuth"] = true;
			$_SESSION["name"] = $user["name"];
			$_SESSION["username"] = $user["username"];
			$_SESSION["photo"] = $user["photo"];

			return Response::json( [
				"error" => false,
				'home' => 'home/index'
			], 200);

		}
		
		return Response::json( [
			"error" => true,
			'message' => 'ingrese las credenciales correctamente.'
		], 400);

	}

	private function validateCredencials(){
		
		if( 
			isset($_POST["username"]) &&
			preg_match('/^[a-zA-Z0-9_]+$/', $_POST["username"]) &&
			isset($_POST["password"]) &&
			preg_match('/^[a-zA-Z0-9_]+$/', $_POST["password"])
		){
			return true;	
		} 
		return false;	
	}
	
	public function logout(){
		session_destroy();

		return Response::json( [
			"error" => false,
			'url' => 'login'
		], 200);

	}

}