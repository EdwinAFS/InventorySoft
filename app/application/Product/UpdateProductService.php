<?php

namespace App\Application\Product;

use App\Domain\exception\CustomException;
use App\Domain\exception\ProductAlreadyExist;
use App\Domain\models\Product;
use App\Domain\repositories\FileRepository;
use App\Domain\repositories\ProductRepository;

class UpdateProductService
{

	public function __construct(ProductRepository $productRepository, FileRepository $fileRepository)
	{
		$this->productRepository = $productRepository;
		$this->fileRepository = $fileRepository;
	}

	public function run($id, $cod, $description, $stock, $purchasePrice, $salePrice, $fK_CategoryId, $image = null, $previousImageUrl = null )
	{
		$this->validateExistProduct( $cod, $id );

		$product = $this->productRepository->findById( $id );
		$product->setCod ( $cod );
		$product->setDescription ( $description );
		$product->setStock ( $stock );
		$product->setPurchasePrice ( $purchasePrice );
		$product->setSalePrice ( $salePrice );
		$product->setFK_categoryId ( $fK_CategoryId );

		if( $image ){

			if( !empty( $previousImageUrl ) ){
				$this->fileRepository->delete( $previousImageUrl );
			}
			
			$imageUrl = $this->fileRepository->uploadImage($image, "products", 1000, 1000);
			$product->setImg($imageUrl);
		}

		$this->productRepository->update($product);
	}

	function validateExistProduct( $cod, $id ){
		$productExist = $this->productRepository->findByCod( $cod );
			
		if( $productExist && $productExist->getId() != $id ){
			throw new CustomException("El producto con codigo $cod ya existe", "ProductAlready", 400);
		}
	}
}
