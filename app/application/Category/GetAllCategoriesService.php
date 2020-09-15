<?php

namespace App\Application\Category;

use App\Domain\repositories\CategoryRepository;

class GetAllCategoriesService
{

	public function __construct(CategoryRepository $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	public function run()
	{
		return $this->categoryRepository->all();
	}
}
