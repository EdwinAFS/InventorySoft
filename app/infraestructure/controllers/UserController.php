<?php
require_once "../framework/Config.php";
require_once "../framework/Response.php";
require_once "../app/application/services/User/CreateUserService.php";
require_once "../app/application/services/User/GetUsersService.php";
require_once "../app/infraestructure/entityManager/UserMySQLRepository.php";

require_once Config::get("models")."User.php";

class UserController{

	public function index(){
		$getUsersService = new GetUsersService( new UserMySQLRepository() );
		return Response::render("users/users.php", [ 'users' => $getUsersService->run() ]);
	}

	public function create(){

		try{
			if(
				! preg_match('/^[a-zA-Z0-9ñÑáéíóúáéíóúÁÉÍÓÚ ]+$/', $_POST["name"]) ||
				! preg_match('/^[a-zA-Z0-9_]+$/', $_POST["username"]) ||
				! preg_match('/^[a-zA-Z0-9_]+$/', $_POST["password"])
			){
				return Response::json( [
					"error" => true,
					'message' => 'Campos con valores invalidos.'
				], 400);
			}
			
			$photoURL = "";
	
			if( isset($_FILES["photo"]["tmp_name"]) ){
				$photoURL = $this->attachmentPhoto( $_FILES["photo"], $_POST["username"] );
			}
	
	
			$createUserService = new CreateUserService( new UserMySQLRepository() );
	
			$createUserService->run(
				$_POST["name"],
				$_POST["username"],
				$_POST["password"],
				$photoURL
			);
	
			return Response::json( [
				'message' => 'Se creo el usuario correctamente.'
			] , 201);
		}catch( Exception $e ){
			
			return Response::json( [
				'message' => 'Ocurrio un error cuando se intentaba crear un usuario.',
				'detail' => $e->getMessage()
			] , 500);
			
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

	public function getUserById(){
		Response::json("en proceso");
	}

}