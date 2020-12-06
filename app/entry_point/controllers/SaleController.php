<?php

namespace App\Entry_point\controllers;

use App\Application\Customer\GetAllCustomersService;
use App\Application\PaymentMethod\GetAllPaymentMethodsService;
use App\Application\Sale\ChangeActiveSaleService;
use App\Application\Sale\CreateSaleService;
use App\Application\Sale\DeleteSaleService;
use App\Application\Sale\FindByIdService;
use App\Application\Sale\GetAllSalesService;
use App\Application\Sale\PrintSaleService;
use App\Application\Sale\UpdateSaleService;
use App\Domain\exception\CustomException;
use App\Infraestructure\CustomerRepositoryMySql;
use App\Infraestructure\FPDF;
use App\Infraestructure\FPDFCreator;
use App\Infraestructure\PaymentMethodRepositoryMySql;
use App\Infraestructure\SaleRepositoryMySql;
use App\Infraestructure\UserRepositoryMySql;
use Exception;
use Framework\Response;

class SaleController
{

	public function index()
	{
		return Response::render("Sales/sales.php");
	}

	private function validate($request)
	{

		return
			preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $request->body->taxes) &&
			preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", doubleval($request->body->netPay)) &&
			preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", doubleval($request->body->total));
	}

	function add()
	{

		$getAllCustomersService = new GetAllCustomersService(new CustomerRepositoryMySql());
		$getAllPaymentMethodsService = new GetAllPaymentMethodsService(new PaymentMethodRepositoryMySql());

		return Response::render("Sales/add.php", [
			'customers' => $getAllCustomersService->run(),
			'paymentMethods' => $getAllPaymentMethodsService->run(),
			'invoiceCode' => 16515
		]);
	}

	public function create($request)
	{

		if (!$this->validate($request)) {
			return Response::json([
				"error" => true,
				'message' => 'Campos con valores invalidos.'
			], 400);
		}

		try {
			if (empty($name)) $name = 'joe';


			$createSaleService = new CreateSaleService(new SaleRepositoryMySql());

			$createSaleService->run(
				$request->body->cod,
				$request->body->taxes,
				$request->body->netPay,
				$request->body->total,
				$request->body->products,
				$request->body->fK_customerId,
				$request->body->fK_sellerId,
				$request->body->fK_paymentMethodId,
				isset($request->body->transactionCode) ? $request->body->transactionCode : NULL,
				isset($request->body->cash) ? $request->body->cash : NULL,
				isset($request->body->cashback) ? $request->body->cashback : NULL
			);

			return Response::json([
				'error' => false,
				'message' => 'Se creo el pedido correctamente.'
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
			$saleId = $request->params->id;

			$findByIdService = new FindByIdService(new SaleRepositoryMySql());

			$sale = $findByIdService->run($saleId);

			if (!$sale) {
				return Response::json([
					'error' => true,
					'message' => 'El pedido no existe.'
				], 404);
			}
			return Response::json([
				'error' => false,
				'data' => $sale->get()
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

	function edit()
	{
		return Response::render("Sales/edit.php");
	}

	public function update($request)
	{
		try {
			if (!$this->validate($request)) {
				return Response::json([
					"error" => true,
					'message' => 'Campos con valores invalidos.'
				], 400);
			}

			$updateSaleService = new UpdateSaleService(new SaleRepositoryMySql());

			$updateSaleService->run(
				$request->params->id,
				$request->body->cod,
				$request->body->taxes,
				$request->body->netPay,
				$request->body->total,
				$request->body->products,
				$request->body->fK_customerId,
				$request->body->fK_sellerId,
				$request->body->fK_paymentMethodId
			);

			return Response::json([
				'error' => false,
				'message' => 'Se actualizo el pedido correctamente.'
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
			$deleteSaleService = new DeleteSaleService(new SaleRepositoryMySql());
			$deleteSaleService->run($request->params->id);

			return Response::json([
				'error' => false,
				'message' => 'Se elimino el pedido correctamente.'
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
			$changeActiveSaleService = new ChangeActiveSaleService(new SaleRepositoryMySql());
			$active = $changeActiveSaleService->run($request->params->id);

			return Response::json([
				'error' => false,
				'message' => 'Se elimino el pedido correctamente.',
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
			$getSalesService = new GetAllSalesService(new SaleRepositoryMySql());

			$sales = $getSalesService->run( 
				$request->params->startDate,
				$request->params->endDate
			);

			$sales = array_map(array($this, 'getSale'), $sales);

			return Response::json([
				'data' => $sales
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

	private function getSale($sale)
	{
		return $sale->get();
	}

	public function print($request)
	{
		try {
			$printSaleService = new PrintSaleService(new FPDFCreator(), new SaleRepositoryMySql(), new CustomerRepositoryMySql(), new UserRepositoryMySql);

			$printSaleService->run( $request->params->id );

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
	
	public function report($request)
	{
		return Response::render("Sales/report/report.php",[
			"sales" => [

			]
		]);
	}
}
