<?php

namespace App\Infraestructure;

use App\Domain\models\Rol;
use App\Domain\repositories\RolRepository;
use App\Infraestructure\Connection;

class RolRepositoryMySql implements RolRepository
{
	private $table = 'rols';

	public function all()
	{
		$connection = Connection::connect()->prepare("SELECT * FROM $this->table");
		$connection->execute();

		$rols = [];

		foreach ($connection->fetchAll() as $rol) {
			
			$rolObj = new Rol($rol['description']);
			$rolObj->setId($rol['id']);
			$rolObj->setCode($rol['code']);
			$rolObj->setDescription($rol['description']);
			$rolObj->setActive($rol['active']);
			
			array_push($rols, $rolObj);
		}

		return $rols;
	}
}
