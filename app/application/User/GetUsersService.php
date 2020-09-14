<?php

namespace App\Application\user;

use App\Domain\repositories\UserRepository;

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
