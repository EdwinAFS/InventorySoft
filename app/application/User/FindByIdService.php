<?php

namespace App\Application\user;

use App\Domain\repositories\UserRepository;

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
