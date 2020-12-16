<?php

namespace App\Entry_point\controllers;

use App\Application\Category\ChangeActiveCategoryService;
use App\Application\Category\CreateCategoryService;
use App\Application\Category\DeleteCategoryService;
use App\Application\Category\FindByIdService;
use App\Application\Category\GetAllCategoriesService;
use App\Application\Category\UpdateCategoryService;
use App\Domain\exception\CustomException;
use App\Infraestructure\CategoryRepositoryMySql;
use Exception;
use Framework\Response;

class CategoryController
{

	public function index()
	{
		return Response::render("categories/categories.php");
	}

	public function create($request)
	{
		try {
			if (
				!preg_match('/^[a-zA-Z0-9ñÑáéíóúáéíóúÁÉÍÓÚ ]+$/', $_POST["description"])
			) {
				return Response::json([
					"error" => true,
					'message' => 'Campos con valores invalidos.'
				], 400);
			}

			$createCategoryService = new CreateCategoryService(new CategoryRepositoryMySql());

			$createCategoryService->run(
				$request->body->description
			);

			return Response::json([
				'error' => false,
				'message' => 'Se creo la categoria correctamente.'
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
			$categoryId = $request->params->id;

			$findByIdService = new FindByIdService(new CategoryRepositoryMySql());

			$category = $findByIdService->run($categoryId);

			if (!$category) {
				return Response::json([
					'error' => true,
					'message' => 'La categoria no existe.'
				], 404);
			}
			return Response::json([
				'error' => false,
				'data' => $category->get()
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
			if (
				!preg_match('/^[a-zA-Z0-9ñÑáéíóúáéíóúÁÉÍÓÚ ]+$/', $request->body->description)
			) {
				return Response::json([
					"error" => true,
					'message' => 'Campos con valores invalidos.'
				], 400);
			}

			$updateCategoryService = new UpdateCategoryService(new CategoryRepositoryMySql());

			$updateCategoryService->run(
				$request->params->id,
				$request->body->description
			);

			return Response::json([
				'error' => false,
				'message' => 'Se actualizo la categoria correctamente.'
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
			$deleteCategoryService = new DeleteCategoryService(new CategoryRepositoryMySql());
			$deleteCategoryService->run($request->params->id);

			return Response::json([
				'error' => false,
				'message' => 'Se elimino la categoria correctamente.'
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
			$changeActiveCategoryService = new ChangeActiveCategoryService(new CategoryRepositoryMySql());
			$active = $changeActiveCategoryService->run($request->params->id);

			return Response::json([
				'error' => false,
				'message' => 'Se elimino la categoria correctamente.',
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

	public function datatable($request)
	{
		try {
			$getCategoriesService = new GetAllCategoriesService(new CategoryRepositoryMySql());

			$categories = $getCategoriesService->run();

			$categories = array_map(function( $category ){
				return $category->get();
			} , $categories);

			return Response::json([
				'data' => $categories
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
}
