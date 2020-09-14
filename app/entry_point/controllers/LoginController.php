<?php

namespace App\Entry_point\controllers;

use Framework\Response;
use App\Application\User\FindByIdService;
use App\Application\user\LoginService;
use App\Domain\exception\CustomException;
use App\Infraestructure\UserRepositoryMySql;
use App\Infraestructure\AutenticationRepositoryMySql;
use Exception;

class LoginController
{

	public function index()
	{
		return Response::show("login/login.php");
	}

	public function autenticate()
	{
		if (!$this->validateCredencials()) {
			return Response::json([
				"error" => true,
				'message' => 'ingrese las credenciales correctamente.'
			], 400);
		}

		try {
			$loginService = new LoginService(new AutenticationRepositoryMySql(), new UserRepositoryMySql());

			$response = $loginService->run(
				$_POST["username"],
				$_POST["password"],
			);

			$findByIdService = new findByIdService(new UserRepositoryMySql());

			$user = $findByIdService->run($response->getId());

			$_SESSION["isAuth"] = true;
			$_SESSION["name"] = $user->getName();
			$_SESSION["username"] = $user->getUsername();

			return Response::json([
				"error" => false,
				'home' => 'home/index'
			], 200);
		} catch (CustomException $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], $e->getHttpCode());
		} catch (Exception $e) {
			return Response::json([
				'error' => true,
				'message' => 'Ocurrio un error en el servidor.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	private function validateCredencials()
	{

		if (
			isset($_POST["username"]) &&
			preg_match('/^[a-zA-Z0-9_]+$/', $_POST["username"]) &&
			isset($_POST["password"]) &&
			preg_match('/^[a-zA-Z0-9_]+$/', $_POST["password"])
		) {
			return true;
		}
		return false;
	}

	public function logout()
	{
		session_destroy();

		return Response::json([
			"error" => false,
			'url' => 'login'
		], 200);
	}
}
