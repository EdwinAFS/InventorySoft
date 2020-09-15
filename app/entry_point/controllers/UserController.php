<?php

namespace App\Entry_point\controllers;

use App\Application\user\ChangeActiveUserService;
use Framework\Response;
use App\Application\User\CreateUserService;
use App\Application\User\UpdateUserService;
use App\Application\User\DeleteUserService;
use App\Application\User\GetUsersService;
use App\Application\User\GetAllRolesService;
use App\Application\User\FindByIdService;
use App\Domain\exception\CustomException;
use App\Domain\exception\UserAlreadyExist;
use App\Infraestructure\FileRepositoryLocal;
use App\Infraestructure\RolRepositoryMySql;
use App\Infraestructure\UserRepositoryMySql;
use Exception;

class UserController
{

	public function index()
	{
		$getUsersService = new GetUsersService(new UserRepositoryMySql());
		$getAllRolesService = new GetAllRolesService(new RolRepositoryMySql());

		return Response::render("users/users.php", [
			'users' => $getUsersService->run(),
			'rols' => $getAllRolesService->run()
		]);
	}

	public function create()
	{
		try {
			if (
				!preg_match('/^[a-zA-Z0-9ñÑáéíóúáéíóúÁÉÍÓÚ ]+$/', $_POST["name"]) ||
				!preg_match('/^[a-zA-Z0-9_]+$/', $_POST["username"]) ||
				!preg_match('/^[a-zA-Z0-9_]+$/', $_POST["password"])
			) {
				return Response::json([
					"error" => true,
					'message' => 'Campos con valores invalidos.'
				], 400);
			}

			$createUserService = new CreateUserService(new UserRepositoryMySql(), new FileRepositoryLocal());

			$createUserService->run(
				$_POST["name"],
				$_POST["username"],
				$_POST["password"],
				$_POST["rolID"],
				isset($_FILES["photo"]) ? $_FILES["photo"] : null
			);

			return Response::json([
				'error' => false,
				'message' => 'Se creo el usuario correctamente.'
			], 201);
		} catch (UserAlreadyExist $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], 400);
		} catch (Exception $e) {

			return Response::json([
				'error' => true,
				'message' => 'Ocurrio un error cuando se intentaba crear un usuario.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	public function findById()
	{

		try {
			$userId = $_GET['id'];

			$findByIdService = new FindByIdService(new UserRepositoryMySql());

			$user = $findByIdService->run($userId);

			if (!$user) {
				return Response::json([
					'error' => true,
					'message' => 'El usuario no existe.'
				], 404);
			}
			return Response::json([
				'error' => false,
				'data' => $user->get()
			], 200);
		} catch (Exception $e) {
			return Response::json([
				'message' => 'Ocurrio un error obteniendo el usuario.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	public function update($request)
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

			$updateUserService = new UpdateUserService(new UserRepositoryMySql(), new FileRepositoryLocal());

			$updateUserService->run(
				$request->params->id,
				$request->body->name,
				$request->body->username,
				$request->body->rolID,
				$request->body->password,
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

	public function delete($request)
	{
		$deleteUserService = new DeleteUserService(new UserRepositoryMySql());

		$deleteUserService->run($request->params->id);

		return Response::json([
			'error' => false,
			'message' => 'Se elimino el usuario correctamente.'
		], 200);
	}

	public function changeActive($request)
	{
		try {

			$changeActiveUserService = new ChangeActiveUserService(new UserRepositoryMySql());

			$active = $changeActiveUserService->run($request->params->id);

			return Response::json([
				'error' => false,
				'message' => 'Se elimino el usuario correctamente.',
				'data' => [
					'active' => $active
				]
			], 200);
		} catch (CustomException $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], $e->getHttpCode());
		}
	}
}
