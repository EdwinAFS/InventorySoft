<?php

namespace App\Application\Category;

use App\Domain\repositories\CategoryRepository;

class DeleteCategoryService
{
	public function __construct(CategoryRepository $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	public function run($id)
	{
		$this->categoryRepository->delete($id);
	}
}
