<?php

namespace App\Application\user;

use App\Domain\models\User;
use App\Domain\repositories\UserRepository;
use App\Domain\repositories\FileRepository;
use App\Domain\exception\UserAlreadyExist;
use App\Domain\ValueObjects\Uuid;

class CreateUserService
{

	public function __construct(UserRepository $userRepository, FileRepository $fileRepository)
	{
		$this->userRepository = $userRepository;
		$this->fileRepository = $fileRepository;
	}

	public function run($name, $username, $password, $rolID, $photo = null)
	{
		$userExists = $this->userRepository->findByUsername($username);

		if ($userExists) {
			throw new UserAlreadyExist($username);
		}

		$user = User::forCreate($name, $username, $rolID, $password);
		$user->setId(Uuid::random()->value());

		
		/* Subimos la imagen */
		if ( $photo) {
			$photoUrl = $this->fileRepository->uploadImage($photo, "{$user->getId()}/avatar", 500, 500);
			$user->setPhoto($photoUrl);
		}

		$this->userRepository->create($user);
	}
}
