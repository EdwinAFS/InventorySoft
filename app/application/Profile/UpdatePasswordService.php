<?php

namespace App\Application\profile;

use App\Domain\repositories\UserRepository;

class UpdatePasswordService
{

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function run( $id, $password )
	{

		$user = $this->userRepository->findById( $id );
		
		$user->setPassword( $password );

		$this->userRepository->update($user);
	}
}
