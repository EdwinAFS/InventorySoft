<?php
require_once "framework/Config.php";
require_once "framework/Response.php";
require Config::get("models")."User.php";

class UserController{
	
	public function login(){
		
		if( $this->validateCredencials() ){
			
			$username = $_POST["username"];
			$password = $_POST["password"];

			$user = User::verifyLogin( $username, $password );

			if( ! $user ){
				return Response::json( [
					'message' => 'Credenciales incorrectas.'
				] , 401);
			}

			$_SESSION["isAuth"] = true;
			$_SESSION["name"] = $user["name"];
			$_SESSION["username"] = $user["username"];
			$_SESSION["photo"] = $user["photo"];

			return Response::render("main/main.php");

		}
		
		return Response::json( [
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

	public function createUser(){

		if(
			preg_match('/^[a-zA-Z0-9ñÑáéíóúáéíóúÁÉÍÓÚ ]+$/', $_POST["name"]) &&
			preg_match('/^[a-zA-Z0-9_]+$/', $_POST["username"]) &&
			preg_match('/^[a-zA-Z0-9_]+$/', $_POST["password"])
		){
			$photoURL = "";

			if( isset($_FILES["photo"]["tmp_name"]) ){
				$photoURL = $this->attachmentPhoto( $_FILES["photo"], $_POST["username"] );
			}

			$user = User::create($_POST["name"], $_POST["username"], $_POST["password"], $photoURL);

			if( $user == "ok" ){
				return Response::json( [
					'message' => 'Se creo el usuario correctamente.'
				] , 201);
			}else{
				return Response::json( [
					'message' => 'Ocurrio un error cuando se intentaba crear un usuario.'
				] , 500);
			}

		}else{
			return Response::json( [
				'message' => 'ingrese los datos correctamente.'
			] , 400);
		}
	}

	private function attachmentPhoto( $file, $folderName ){
		
		list( $width, $height) = getimagesize($file["tmp_name"]);
					
		$heightPhoto = 500;
		$widthPhoto = 500;

		$directory = Config::get("storage")."uploads/avatar/{$folderName}";

		mkdir($directory, 0755);

		$random = mt_rand(100, 999);

		if($file['type'] == 'image/png'){
			$origin = imagecreatefrompng( $file["tmp_name"] );
			$path = "$directory/$random.png";
		}else{
			$origin = imagecreatefromjpeg( $file["tmp_name"] );
			$path = "$directory/$random.jpg";
		}

		$destination = imagecreatetruecolor( $heightPhoto, $widthPhoto);

		imagecopyresized( $destination, $origin, 0, 0, 0, 0, $heightPhoto, $widthPhoto, $width, $height);


		($file['type'] == "image/png")? imagepng( $destination, $path ): imagejpeg( $destination, $path );

		return $path;
	}

	public function index(){
		return Response::render("users/users.php", [ 'users' => User::users() ]);
	}

	public function getUserById(){
		echo json_encode("
			{
				
			}
		");
	}

}