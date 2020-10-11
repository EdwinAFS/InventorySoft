<?php

namespace App\Application\Customer;

use App\Domain\repositories\CustomerRepository;

class GetAllCustomersService
{

	public function __construct(CustomerRepository $customerRepository)
	{
		$this->customerRepository = $customerRepository;
	}

	public function run()
	{
		return $this->customerRepository->all();
	}
}
