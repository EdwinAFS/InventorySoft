<?php

namespace App\Application\Category;

use App\Domain\models\Category;
use App\Domain\repositories\CategoryRepository;

class UpdateCategoryService
{

	public function __construct(CategoryRepository $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	public function run($id, $description )
	{
		$category = new Category( $description );
		$category->setId( $id );

		$this->categoryRepository->update($category);
	}
}
