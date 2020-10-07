<?php

namespace App\Application\Product;

use App\Domain\exception\CustomException;
use App\Domain\models\Product;
use App\Domain\repositories\FileRepository;
use App\Domain\repositories\ProductRepository;

class CreateProductService
{
	public function __construct(ProductRepository $productRepository, FileRepository $fileRepository)
	{
		$this->productRepository = $productRepository;
		$this->fileRepository = $fileRepository;
	}

	public function run($cod, $description, $stock, $purchasePrice, $salePrice, $fK_CategoryId, $image)
	{
		$this->validateExistProduct( $cod );

		$product = new Product($cod, $description, $stock, $purchasePrice, $salePrice, $fK_CategoryId);

		/* Subimos la imagen */
		if ( $image) {
			$imageUrl = $this->fileRepository->uploadImage($image, "{$product->getId()}/products", 1000, 1000);
			$product->setImg($imageUrl);
		}

		$this->productRepository->create($product);
	}

	function validateExistProduct( $cod ){
		$productExist = $this->productRepository->findByCod( $cod );
			
		if( $productExist ){
			throw new CustomException("El producto con codigo $cod ya existe", "ProductAlready", 400);
		}
	}
}

