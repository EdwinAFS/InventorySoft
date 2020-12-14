<?php

namespace App\Infraestructure;

use App\Domain\models\Category;
use App\Domain\repositories\CategoryRepository;
use App\Infraestructure\Connection;
use PDO;

class CategoryRepositoryMySql implements CategoryRepository
{
	private $table = 'categories';

	public function all()
	{
		$connection = Connection::connect()->prepare("SELECT * FROM $this->table WHERE Deleted_at is null");
		$connection->execute();

		$categories = [];

		foreach ($connection->fetchAll() as $rol) {

			$categoryObj = new Category($rol['Description']);
			$categoryObj->setId($rol['CategoriesId']);
			$categoryObj->setActive($rol['Active']);

			array_push($categories, $categoryObj);
		}

		return $categories;
	}

	public function create(Category $category)
	{
		$description = $category->getDescription();

		$query = "INSERT INTO $this->table(Description) VALUES (:Description);";

		$connection = Connection::connect()->prepare($query);
		$connection->bindParam(":Description", $description, PDO::PARAM_STR);
		$connection->execute();
	}

	public function update(Category $category)
	{
		$description = $category->getDescription();
		$active = $category->getActive();

		$query = "UPDATE $this->table SET Description = :Description". 
					(( $active != "" )?", Active = :Active":"").
					" WHERE CategoriesId = {$category->getId()}";

		$connection = Connection::connect()->prepare($query);
		$connection->bindParam(":Description", $description, PDO::PARAM_STR);
		if( $active != "" ){
			$connection->bindParam(":Active", $active, PDO::PARAM_STR);
		}
		$connection->execute();
	}

	public function findById(String $id)
	{
		$query = "SELECT * FROM $this->table WHERE CategoriesId = $id";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$categoryData = $connection->fetch();

		if (!$categoryData) {
			return null;
		}

		$category = new Category( $categoryData['Description'] );
		$category->setId($categoryData['CategoriesId']);
		$category->setActive($categoryData['Active']);
		
		return $category;
	}

	public function delete(string $id)
	{
		$query = "UPDATE $this->table  Deleted_at = now() WHERE CategoriesId = '$id'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();
	}
}
