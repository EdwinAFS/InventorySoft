<?php

namespace App\Application\Category;

use App\Domain\repositories\CategoryRepository;

class ChangeActiveCategoryService
{
	public function __construct(CategoryRepository $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	public function run($id)
	{
		$category = $this->categoryRepository->findById( $id );

		$category->setActive( $category->getActive() == "1"? "0" : "1" ); 
		
		$this->categoryRepository->update( $category );

		return $category->getActive();
	}
}
