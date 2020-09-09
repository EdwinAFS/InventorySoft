<?php

require_once "../app/domain/models/User.php";
require_once "../app/domain/repositories/UserRepository.php";

class UpdateUserService
{

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function run($id, $name, $username, $password)
	{
		$user = new User($name, $username, $password);

		$user->setId($id);

		if ($this->userRepository->update($user)) {
			new Exception("Ocurrio un error cuando se intento actualizar el usuario");
		}

		return $user;
	}
}
