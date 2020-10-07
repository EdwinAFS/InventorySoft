<?php

namespace App\Application\Product;

use App\Domain\repositories\ProductRepository;

class FindByIdService
{

	public function __construct(ProductRepository $productRepository)
	{
		$this->productRepository = $productRepository;
	}

	public function run( $id )
	{
		return $this->productRepository->findById( $id );
	}
}
