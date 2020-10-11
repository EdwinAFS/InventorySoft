<?php

namespace App\Application\Customer;

use App\Domain\repositories\CustomerRepository;

class ChangeActiveCustomerService
{
	public function __construct(CustomerRepository $customerRepository)
	{
		$this->customerRepository = $customerRepository;
	}

	public function run($id)
	{
		$customer = $this->customerRepository->findById( $id );

		$customer->setActive( $customer->getActive() == "1"? "0" : "1" ); 
		
		$this->customerRepository->update( $customer );

		return $customer->getActive();
	}
}
