<?php

namespace App\Entry_point\controllers;

use App\Application\Category\GetAllCategoriesService;
use App\Infraestructure\CategoryRepositoryMySql;
use Framework\Response;

class CategoryController
{

	public function index()
	{
		$getCategoriesService = new GetAllCategoriesService(new CategoryRepositoryMySql());

		return Response::render("categories/categories.php", [
			'categories' => $getCategoriesService->run()
		]);
	}

	public function create()
	{
		
	}

	public function findById()
	{

	}

	public function update($request)
	{
		
	}

	public function delete($request)
	{
		
	}

	public function changeActive($request)
	{
	
	}
}
