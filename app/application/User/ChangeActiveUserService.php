<?php

namespace App\Application\user;

use App\Domain\repositories\UserRepository;
use Exception;

class ChangeActiveUserService
{
	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	public function run($id)
	{
		$user = $this->userRepository->findById( $id );

		$user->setActive( $user->getActive() == "1"? "0" : "1" ); 
		
		$this->userRepository->update( $user );

		return $user->getActive();
	}
}
