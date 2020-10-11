<?php

namespace App\Application\Customer;

use App\Domain\exception\CustomException;
use App\Domain\repositories\CustomerRepository;

class UpdateCustomerService
{

	public function __construct(CustomerRepository $customerRepository)
	{
		$this->customerRepository = $customerRepository;
	}

	public function run($id, $name, $identification, $email, $address, $birthdate, $phone = null )
	{
		$this->validateExistCustomer( $identification, $id );

		$customer = $this->customerRepository->findById( $id );
		
		$customer->setName( $name );
		$customer->setIdentification( $identification );
		$customer->setEmail( $email );
		$customer->setAddress( $address );
		$customer->setPhone( $phone );
		$customer->setBirthdate( $birthdate );

		$this->customerRepository->update($customer);
	}

	function validateExistCustomer( $identification, $id ){
		$customerExist = $this->customerRepository->findByIdentification( $identification );
			
		if( $customerExist && $customerExist->getId() != $id ){
			throw new CustomException("El cliente con identificacion $identification ya existe", "CustomerAlready", 400);
		}
	}
}
