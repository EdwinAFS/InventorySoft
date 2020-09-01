<?php

require_once "../app/domain/models/User.php";
require_once "../app/domain/repositories/UserRepository.php";

class CreateUserService
{

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function run($name, $username, $password, $photo)
	{
		$user = new User( $name, $username, $password );
		$user->setPhoto($photo);

		$this->userRepository->create( $user );

		if( $this->userRepository->create( $user ) ){
			new Exception("Ocurrio un error cuando se intento crear un usuario");
		}

		return $user;
	}
}
