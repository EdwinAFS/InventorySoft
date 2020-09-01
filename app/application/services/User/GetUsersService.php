<?php

require_once "../app/domain/models/User.php";
require_once "../app/domain/repositories/UserRepository.php";

class GetUsersService
{

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function run()
	{
		return $this->userRepository->users();
	}
}
