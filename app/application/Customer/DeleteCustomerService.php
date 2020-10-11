<?php

namespace App\Application\Customer;

use App\Domain\repositories\CustomerRepository;

class DeleteCustomerService
{
	public function __construct(CustomerRepository $customerRepository)
	{
		$this->customerRepository = $customerRepository;
	}

	public function run($id)
	{
		$this->customerRepository->delete($id);
	}
}
