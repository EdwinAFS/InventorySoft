<?php

namespace App\Application\Customer;

use App\Domain\exception\CustomException;
use App\Domain\models\Customer;
use App\Domain\repositories\CustomerRepository;

class CreateCustomerService
{
	public function __construct(CustomerRepository $customerRepository)
	{
		$this->customerRepository = $customerRepository;
	}

	public function run( $name, $identification, $email, $address, $birthdate, $phone = null )
	{
		$this->validateExistCustomer( $identification );

		$customer = new Customer($name, $identification, $email, $address, $birthdate);

		$customer->setPhone( $phone );

		$this->customerRepository->create($customer);
	}

	function validateExistCustomer( $identification ){
		$customerExist = $this->customerRepository->findByIdentification( $identification );
			
		if( $customerExist ){
			throw new CustomException("El cliente con codigo $identification ya existe", "CustomerAlready", 400);
		}
	}
}

