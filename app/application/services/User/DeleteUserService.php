<?php

require_once "../app/domain/repositories/UserRepository.php";

class DeleteUserService
{

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function run($id)
	{
		if ($this->userRepository->delete($id)) {
			new Exception("Ocurrio un error cuando se intento eliminar el usuario");
		}
	}
}
