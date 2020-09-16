<?php

namespace App\Domain\repositories;

use App\Domain\models\Category;

interface CategoryRepository {
	public function create( Category $category );
	public function update( Category $category );
	public function findById(String $id);
	public function all();
}
