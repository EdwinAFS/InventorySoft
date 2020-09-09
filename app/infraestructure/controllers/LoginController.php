<?php
require_once "../framework/Response.php";
require_once "../app/application/services/User/LoginService.php";
require_once "../app/application/services/User/FindByIdService.php";
require_once "../app/infraestructure/entityManager/UserMySQLRepository.php";
require_once "../app/infraestructure/entityManager/AutenticationMySQLRepository.php";

class LoginController{
	
	public function index(){
		return Response::show("login/login.php");
	}

	public function autenticate(){
	
		if( ! $this->validateCredencials() ){
			return Response::json( [
				"error" => true,
				'message' => 'ingrese las credenciales correctamente.'
			], 400);
		}
		
		$loginService = new LoginService( new AutenticationMySQLRepository() );

		$response = $loginService->run(
			$_POST["username"],
			$_POST["password"],
		);

		if( ! $response ){
			return Response::json( [
				"error" => true,
				'message' => 'Credenciales incorrectas.'
			] , 401);
		}
			
		$findByIdService = new findByIdService( new UserMySQLRepository() );

		$user = $findByIdService->run( $response->getId() );

		$_SESSION["isAuth"] = true;
		$_SESSION["name"] = $user->getName();
		$_SESSION["username"] = $user->getUsername();

		return Response::json( [
			"error" => false,
			'home' => 'home/index'
		], 200);

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