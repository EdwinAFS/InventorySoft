<?php

namespace App\Infraestructure;

use App\Domain\models\Category;
use App\Domain\repositories\CategoryRepository;
use App\Infraestructure\Connection;

class CategoryRepositoryMySql implements CategoryRepository
{
	private $table = 'categories';

	public function all()
	{

		return [
			new Category("test1"),
			new Category("test2"),
			new Category("test3"),
			new Category("test4"),
			new Category("test5")
		];

		$connection = Connection::connect()->prepare("SELECT * FROM $this->table");
		$connection->execute();

		$categories = [];

		foreach ($connection->fetchAll() as $rol) {
			
			$categoryObj = new Category($rol['description']);
			$categoryObj->setId($rol['id']);
			$categoryObj->setDescription($rol['description']);
			$categoryObj->setActive($rol['active']);
			
			array_push($categories, $categoryObj);
		}

		return $categories;
	}
}
