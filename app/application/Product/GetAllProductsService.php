<?php

namespace App\Application\Product;

use App\Domain\repositories\ProductRepository;

class GetAllProductsService
{

	public function __construct(ProductRepository $productRepository)
	{
		$this->productRepository = $productRepository;
	}

	public function run($limit = 0, $offset = 0)
	{
		return $this->productRepository->all($limit, $offset);
	}
}
