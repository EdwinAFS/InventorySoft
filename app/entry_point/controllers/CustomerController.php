<?php

namespace App\Entry_point\controllers;

use App\Application\Customer\ChangeActiveCustomerService;
use App\Application\Customer\CreateCustomerService;
use App\Application\Customer\DeleteCustomerService;
use App\Application\Customer\FindByIdService;
use App\Application\Customer\GetAllCustomersService;
use App\Application\Customer\GetTotalRecordsCustomerService;
use App\Application\Customer\UpdateCustomerService;
use App\Domain\exception\CustomException;
use App\Infraestructure\FileRepositoryLocal;
use App\Infraestructure\CustomerRepositoryMySql;
use Exception;
use Framework\Response;

use function PHPSTORM_META\map;

class CustomerController
{

	public function index()
	{
		return Response::render("Customers/customers.php");
	}

	private function validate( $request ){
		
		return 
			preg_match('/^[a-zA-ZñÑáéíóúáéíóúÁÉÍÓÚ ]+$/', $request->body->name ) &&
			preg_match('/^[a-zA-Z0-9]+$/', $request->body->identification ) &&
			preg_match('/^[0-9]+$/', $request->body->phone ) &&
			preg_match('/^[a-zA-Z0-9-#, ]+$/', $request->body->address ) &&
			!empty( $request->body->birthdate ) &&
			filter_var($request->body->email, FILTER_VALIDATE_EMAIL);			
	}

	public function create($request)
	{

		if ( ! $this->validate($request) ) {
			return Response::json([
				"error" => true,
				'message' => 'Campos con valores invalidos.'
			], 400);
		}

		try {	

			$createCustomerService = new CreateCustomerService(new CustomerRepositoryMySql(), new FileRepositoryLocal());

			$createCustomerService->run(
				$request->body->name,
				$request->body->identification,
				$request->body->email,
				$request->body->address,
				$request->body->birthdate,
				$request->body->phone
			);

			return Response::json([
				'error' => false,
				'message' => 'Se creo el cliente correctamente.'
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
			$customerId = $request->params->id;

			$findByIdService = new FindByIdService(new CustomerRepositoryMySql());

			$customer = $findByIdService->run($customerId);

			if (!$customer) {
				return Response::json([
					'error' => true,
					'message' => 'El cliente no existe.'
				], 404);
			}
			return Response::json([
				'error' => false,
				'data' => $customer->get()
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
			if ( ! $this->validate($request) ) {
				return Response::json([
					"error" => true,
					'message' => 'Campos con valores invalidos.'
				], 400);
			}

			$updateCustomerService = new UpdateCustomerService( new CustomerRepositoryMySql() );

			$updateCustomerService->run(
				$request->params->id,
				$request->body->name,
				$request->body->identification,
				$request->body->email,
				$request->body->address,
				$request->body->birthdate,
				$request->body->phone
			);

			return Response::json([
				'error' => false,
				'message' => 'Se actualizo el cliente correctamente.'
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
			$deleteCustomerService = new DeleteCustomerService(new CustomerRepositoryMySql());
			$deleteCustomerService->run($request->params->id);

			return Response::json([
				'error' => false,
				'message' => 'Se elimino el cliente correctamente.'
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
			$changeActiveCustomerService = new ChangeActiveCustomerService(new CustomerRepositoryMySql());
			$active = $changeActiveCustomerService->run($request->params->id);

			return Response::json([
				'error' => false,
				'message' => 'Se elimino el cliente correctamente.',
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
			$getCustomersService = new GetAllCustomersService(new CustomerRepositoryMySql());			

			$customers = $getCustomersService->run();

			$customers = array_map( array($this, 'getCustomer'), $customers );

			return Response::json([
				'data' => $customers
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

	private function getCustomer( $customer ){
		return $customer->get();
	} 
	
}
