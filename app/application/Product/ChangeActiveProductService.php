<?php

namespace App\Application\Product;

use App\Domain\repositories\ProductRepository;

class ChangeActiveProductService
{
	public function __construct(ProductRepository $productRepository)
	{
		$this->productRepository = $productRepository;
	}

	public function run($id)
	{
		$product = $this->productRepository->findById( $id );

		$product->setActive( $product->getActive() == "1"? "0" : "1" ); 
		
		$this->productRepository->update( $product );

		return $product->getActive();
	}
}
