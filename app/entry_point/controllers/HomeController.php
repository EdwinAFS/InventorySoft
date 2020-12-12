<?php

namespace App\Entry_point\Controllers;

use App\Application\Category\GetAllCategoriesService;
use App\Application\Customer\GetAllCustomersService;
use App\Application\Product\GetAllProductsService;
use App\Application\Sale\GetAllSalesService;
use App\Infraestructure\CategoryRepositoryMySql;
use App\Infraestructure\CustomerRepositoryMySql;
use App\Infraestructure\ProductRepositoryMySql;
use App\Infraestructure\SaleRepositoryMySql;
use Framework\Response;

class HomeController
{

	public function __construct()
	{
	}

	public function index()
	{
		$getAllCustomersService = new GetAllCustomersService(new CustomerRepositoryMySql());
		$customers = count($getAllCustomersService->run());

		$getProductsService = new GetAllProductsService(new ProductRepositoryMySql());
		$products = count($getProductsService->run());

		$getCategoriesService = new GetAllCategoriesService(new CategoryRepositoryMySql());
		$categories = count($getCategoriesService->run());

		$startDate = date('Y-m-d', strtotime('first day of last month'));
		$endDate = date('Y-m-d', strtotime('last day of last month'));
		$getSalesService = new GetAllSalesService(new SaleRepositoryMySql());

		$salesLastMonth = array_reduce(
			$getSalesService->run($startDate, $endDate),
			function($total, $sale) { return $total + $sale->getNetPay();  },
			0
		);

		Response::render("Home/home.php", [
			'customers' => $customers,
			'products' => $products,
			'categories' => $categories,
			'salesLastMonth' => '$ '.number_format($salesLastMonth, 2)
		]);
	}
}
