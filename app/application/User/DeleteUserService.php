<?php

namespace App\Application\user;

use App\Domain\repositories\UserRepository;
use Exception;

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
