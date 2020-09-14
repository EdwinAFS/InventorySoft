<?php

namespace App\Application\user;

use App\Domain\models\Autentication;
use App\Domain\models\User;
use App\Domain\repositories\AutenticationRepository;
use App\Domain\repositories\UserRepository;
use App\Domain\exception\CustomException;
use Exception;

class LoginService
{

	public function __construct(AutenticationRepository $autenticationRepository, UserRepository $userRepository)
	{
		$this->autenticationRepository = $autenticationRepository;
		$this->userRepository = $userRepository;
	}

	public function run($username, $password)
	{
		$user = $this->userRepository->findByUsername( $username );

		if(  ! $user || ! $user->comparePassword( $password ) ){
			throw new CustomException("Credenciales incorrectas", "bad_credentials", 400);
		}
		
		if( $user->getActive() == 0 ){
			throw new CustomException("Usuario Inactivo", "inactive_user", 400);
		}

		$user->setLastLogin(  date("Y-m-d H:i:s") );

		$this->userRepository->update($user);

		return $user;

		/* $verifiedUser = $this->autenticationRepository->verify( new Autentication($username, $password) );

		if( ! $verifiedUser ){
			throw new Exception("Credenciales incorrectas");
		}
		
		$user = User::forUpdate( $verifiedUser->getId(), $verifiedUser->getName(), $verifiedUser->getUsername() );

		$user->setLastLogin(  date("Y-m-d H:i:s") );

		$this->userRepository->update($user); */

	}
}
