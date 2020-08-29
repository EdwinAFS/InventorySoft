<?php

class UserController{
	
	public function login(){
		
		if( $this->validateCredencials() ){
			
			$username = $_POST["username"];
			$password = $_POST["password"];

			$user = User::verifyLogin( $username, $password );

			if( $user ){
				
				$_SESSION["iniciarSesion"] = "ok";
				$_SESSION["name"] = $user["name"];
				$_SESSION["username"] = $user["username"];
				$_SESSION["photo"] = $user["photo"];

				echo"
					<script>
						window.location = 'main';
					</script>
				";

			}else{
				echo "
					<div class='alert alert-danger' role='alert'>
						Credenciales incorrectas!
					</div>
				";
			}

		} 

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
		echo "<script>console.log(".isset($_POST['username']).")</script>";
		echo "<script>console.log('asdsad')</script>";

		if( isset($_POST["username"]) ){
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
					echo "
						<script>
							Swal.fire({
								icon: 'success',
								title: 'Oops...',
								text: 'Se creo un nuevo usuario.'
							}).then((resp)=>{
								if( resp.value ) window.location = 'users';
							});
						</script>
					";
				}else{
					echo "
						<script>
							Swal.fire({
								icon: 'error',
								title: 'Oops...',
								text: 'Error al crear un usuario.'
							}).then((resp)=>{
								if( resp.value ) window.location = 'users';
							});
						</script>
					";
				}

			}else{
				echo "
					<script>
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'Por favor, Ingrese los datos correctamente.'
						}).then((resp)=>{
							if( resp.value ) window.location = 'users';
						});
					</script>
				";
			}
		}
	}

	private function attachmentPhoto( $file, $folderName ){
		
		list( $width, $height) = getimagesize($file["tmp_name"]);
					
		$heightPhoto = 500;
		$widthPhoto = 500;

		$directory = "views/public/img/profile/{$folderName}";

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
		return User::users();
	}

	public function getUserById(){
		echo json_encode("
			{
				
			}
		");
	}

}