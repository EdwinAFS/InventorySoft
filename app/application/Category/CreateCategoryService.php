<?php

namespace App\Application\Category;

use App\Domain\models\Category;
use App\Domain\repositories\CategoryRepository;

class CreateCategoryService
{
	public function __construct(CategoryRepository $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	public function run($description)
	{
		$category = new Category($description);
		$this->categoryRepository->create($category);
	}
}