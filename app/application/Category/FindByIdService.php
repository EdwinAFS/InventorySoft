<?php

namespace App\Application\Category;

use App\Domain\repositories\CategoryRepository;

class FindByIdService
{

	public function __construct(CategoryRepository $categoryRepository)
	{
		$this->categoryRepository = $categoryRepository;
	}

	public function run( $id )
	{
		return $this->categoryRepository->findById( $id );
	}
}
