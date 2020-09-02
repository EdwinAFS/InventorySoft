<?php

require_once "../app/domain/models/User.php";
require_once "../app/domain/repositories/UserRepository.php";

class FindByIdService
{

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function run( $id )
	{
		return $this->userRepository->findById( $id );
	}
}
