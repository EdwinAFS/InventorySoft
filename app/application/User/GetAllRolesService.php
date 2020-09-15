<?php

namespace App\Application\user;

use App\Domain\repositories\RolRepository;

class GetAllRolesService
{

	public function __construct(RolRepository $rolRepository)
	{
		$this->rolRepository = $rolRepository;
	}

	public function run()
	{
		return $this->rolRepository->all();
	}
}
