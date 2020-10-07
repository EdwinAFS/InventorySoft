<?php

namespace App\Application\Product;

use App\Domain\repositories\ProductRepository;

class GetTotalRecordsProductService
{

	public function __construct(ProductRepository $productRepository)
	{
		$this->productRepository = $productRepository;
	}

	public function run()
	{
		return $this->productRepository->totalRecords();
	}
}
