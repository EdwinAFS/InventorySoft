<?php

namespace App\Application\user;

use App\Domain\exception\UserAlreadyExist;
use App\Domain\models\User;
use App\Domain\repositories\FileRepository;
use App\Domain\repositories\UserRepository;
use Exception;

class UpdateUserService
{

	public function __construct(UserRepository $userRepository, FileRepository $fileRepository)
	{
		$this->userRepository = $userRepository;
		$this->fileRepository = $fileRepository;
	}

	public function run($id, $name, $username, $rolID, $password = "", $photo = null, $previousPhotoUrl = null)
	{
		$userExists = $this->userRepository->findByUsername($username);

		if ($userExists && $userExists->getId() != $id) {
			throw new UserAlreadyExist($username);
		}   

		if( ! empty($password) ){
			$user = User::forUpdate($id, $name, $username, $rolID );
			$user->setPassword( $password );
		}else{
			$user = User::forUpdate($id, $name, $username, $rolID, $userExists->getPassword());
		}

		$user->setActive( $userExists->getActive() );


		if( $photo ){

			if( !empty($previousPhotoUrl) ){
				$this->fileRepository->delete( $previousPhotoUrl );
			}
			
			$photoUrl = $this->fileRepository->uploadImage($photo, "{$user->getId()}/avatar", 500, 500);
			$user->setPhoto($photoUrl);
		}else{
			$user->setPhoto($previousPhotoUrl);
		}		

		$this->userRepository->update($user);
	}
}
