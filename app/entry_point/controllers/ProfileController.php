<?php

namespace App\Entry_point\controllers;

use App\Application\profile\UpdatePasswordService;
use Framework\Response;
use App\Application\User\FindByIdService;
use App\Application\user\LoginService;
use App\Application\user\UpdateUserService;
use App\Domain\exception\CustomException;
use App\Domain\exception\UserAlreadyExist;
use App\Infraestructure\AutenticationRepositoryMySql;
use App\Infraestructure\FileRepositoryLocal;
use App\Infraestructure\UserRepositoryMySql;

use Exception;

class ProfileController
{

	public function index()
	{
		$findByIdService = new FindByIdService(new UserRepositoryMySql());
		return Response::render("profile/profile.php", [
			'data' => $findByIdService->run($_SESSION["id"])
		]);
	}

	public function changePassword($request)
	{
		return Response::render("profile/changePassword.php");
	}

	public function updateProfile($request)
	{
		try {
			if (
				!preg_match('/^[a-zA-Z0-9ñÑáéíóúáéíóúÁÉÍÓÚ ]+$/', $request->body->name) ||
				!preg_match('/^[a-zA-Z0-9_]+$/', $request->body->username)
			) {
				return Response::json([
					"error" => true,
					'message' => 'Campos con valores invalidos.'
				], 400);
			}
			$findByIdService = new FindByIdService(new UserRepositoryMySql());
			$user = $findByIdService->run($_SESSION["id"]);

			$updateUserService = new UpdateUserService(new UserRepositoryMySql(), new FileRepositoryLocal());

			$updateUserService->run(
				$request->params->id,
				$request->body->name,
				$request->body->username,
				$user->getRolID(),
				"",
				isset($_FILES["photo"]) ? $_FILES["photo"] : null,
				$request->body->photoUrl
			);

			return Response::json([
				'error' => false,
				'message' => 'Se actualizo el usuario correctamente.'
			], 200);
		} catch (UserAlreadyExist $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], 400);
		} catch (Exception $e) {
			return Response::json([
				'error' => true,
				'message' => 'Ocurrio un error cuando se intentaba actualizar un usuario.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	public function updatePassword($request)
	{
		try {

			$loginService = new LoginService(new AutenticationRepositoryMySql(), new UserRepositoryMySql());

			$response = $loginService->run(
				$_SESSION["username"],
				$request->body->password
			);

			$updatePasswordService = new UpdatePasswordService(new UserRepositoryMySql());

			$updatePasswordService->run(
				$response->getId(),
				$request->body->newPassword
			);

			return Response::json([
				'error' => false,
				'message' => 'Se actualizo la password correctamente.'
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
}
