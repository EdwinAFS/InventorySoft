<?php

namespace App\Entry_point\controllers;

use App\Application\Category\GetAllCategoriesService;
use App\Application\Product\ChangeActiveProductService;
use App\Application\Product\CreateProductService;
use App\Application\Product\DeleteProductService;
use App\Application\Product\FindByIdService;
use App\Application\Product\GetAllProductsService;
use App\Application\Product\GetTotalRecordsProductService;
use App\Application\Product\UpdateProductService;
use App\Domain\exception\CustomException;
use App\Infraestructure\CategoryRepositoryMySql;
use App\Infraestructure\FileRepositoryLocal;
use App\Infraestructure\ProductRepositoryMySql;
use Exception;
use Framework\Response;

use function PHPSTORM_META\map;

class ProductController
{

	public function index()
	{
		$getProductsService = new GetAllProductsService(new ProductRepositoryMySql());
		$getCategoriesService = new GetAllCategoriesService(new CategoryRepositoryMySql());

		return Response::render("products/products.php", [
			'products' => $getProductsService->run(),
			'categories' => $getCategoriesService->run()
		]);
	}

	private function validate( $request ){
		return 
			!preg_match('/^[a-zA-Z0-9ñÑáéíóúáéíóúÁÉÍÓÚ ]+$/', $request->body->description ) &&
			!preg_match('/^[0-9]+$/', $request->body->stock ) &&
			!preg_match('/^[0-9.]+$/', $request->body->salePrice ) &&
			!preg_match('/^[0-9.]+$/', $request->body->purchasePrice );
	}

	public function create($request)
	{
		try {
			if ( $this->validate($request) ) {
				return Response::json([
					"error" => true,
					'message' => 'Campos con valores invalidos.'
				], 400);
			}

			$createProductService = new CreateProductService(new ProductRepositoryMySql(), new FileRepositoryLocal());

			$createProductService->run(
				$request->body->cod,
				$request->body->description,
				$request->body->stock,
				$request->body->purchasePrice,
				$request->body->salePrice,
				$request->body->category,
				isset($_FILES["image"]) ? $_FILES["image"] : null
			);

			return Response::json([
				'error' => false,
				'message' => 'Se creo el producto correctamente.'
			], 201);
		} catch (CustomException $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], $e->getHttpCode());
		} catch (Exception $e) {
			return Response::json([
				'error' => true,
				'message' => 'Ocurrio un error en el servidor.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	public function findById($request)
	{
		try {
			$productId = $request->params->id;

			$findByIdService = new FindByIdService(new ProductRepositoryMySql());

			$product = $findByIdService->run($productId);

			if (!$product) {
				return Response::json([
					'error' => true,
					'message' => 'El producto no existe.'
				], 404);
			}
			return Response::json([
				'error' => false,
				'data' => $product->get()
			], 200);
		} catch (CustomException $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], $e->getHttpCode());
		} catch (Exception $e) {
			return Response::json([
				'error' => true,
				'message' => 'Ocurrio un error en el servidor.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	public function update($request)
	{
		try {
			if ( $this->validate($request) ) {
				return Response::json([
					"error" => true,
					'message' => 'Campos con valores invalidos.'
				], 400);
			}

			$updateProductService = new UpdateProductService(new ProductRepositoryMySql(), new FileRepositoryLocal());

			$updateProductService->run(
				$request->params->id,
				$request->body->cod,
				$request->body->description,
				$request->body->stock,
				$request->body->purchasePrice,
				$request->body->salePrice,
				$request->body->category,
				isset($_FILES["image"]) ? $_FILES["image"] : null,
				$request->body->imageUrl
			);

			return Response::json([
				'error' => false,
				'message' => 'Se actualizo el producto correctamente.'
			], 200);
		} catch (CustomException $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], $e->getHttpCode());
		} catch (Exception $e) {
			return Response::json([
				'error' => true,
				'message' => 'Ocurrio un error en el servidor.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	public function delete($request)
	{
		try {
			$deleteProductService = new DeleteProductService(new ProductRepositoryMySql());
			$deleteProductService->run($request->params->id);

			return Response::json([
				'error' => false,
				'message' => 'Se elimino el producto correctamente.'
			], 200);
		} catch (CustomException $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], $e->getHttpCode());
		} catch (Exception $e) {
			return Response::json([
				'error' => true,
				'message' => 'Ocurrio un error en el servidor.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	public function changeActive($request)
	{
		try {
			$changeActiveProductService = new ChangeActiveProductService(new ProductRepositoryMySql());
			$active = $changeActiveProductService->run($request->params->id);

			return Response::json([
				'error' => false,
				'message' => 'Se elimino el producto correctamente.',
				'data' => [
					'active' => $active
				]
			], 200);
		} catch (CustomException $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], $e->getHttpCode());
		} catch (Exception $e) {
			return Response::json([
				'error' => true,
				'message' => 'Ocurrio un error en el servidor.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	public function datatable( $request ){
		
		try {
			$getProductsService = new GetAllProductsService(new ProductRepositoryMySql());			
			$getTotalRecordsProductService = new GetTotalRecordsProductService(new ProductRepositoryMySql());

			$products = $getProductsService->run( $request->params->quantity?:0, ($request->params->numberPag - 1) * $request->params->quantity );

			$products = array_map( array($this, 'getProduct'), $products );

			$totalRecords = $getTotalRecordsProductService->run();

			return Response::json([
				"recordsFiltered" => $totalRecords,
				'recordsTotal' => $totalRecords,
				'data' => $products,
			], 200);

		} catch (CustomException $e) {
			return Response::json([
				'error' => true,
				'message' => $e->getMessage()
			], $e->getHttpCode());
		} catch (Exception $e) {
			return Response::json([
				'error' => true,
				'message' => 'Ocurrio un error en el servidor.',
				'detail' => $e->getMessage()
			], 500);
		}
	}

	private function getProduct( $product ){
		return $product->get();
	} 
	
}
