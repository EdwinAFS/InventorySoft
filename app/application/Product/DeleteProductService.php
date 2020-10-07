<?php

namespace App\Application\Product;

use App\Domain\repositories\ProductRepository;

class DeleteProductService
{
	public function __construct(ProductRepository $productRepository)
	{
		$this->productRepository = $productRepository;
	}

	public function run($id)
	{
		$this->productRepository->delete($id);
	}
}
