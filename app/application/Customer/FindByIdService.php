<?php

namespace App\Application\Customer;

use App\Domain\repositories\CustomerRepository;

class FindByIdService
{

	public function __construct(CustomerRepository $customerRepository)
	{
		$this->customerRepository = $customerRepository;
	}

	public function run( $id )
	{
		return $this->customerRepository->findById( $id );
	}
}
