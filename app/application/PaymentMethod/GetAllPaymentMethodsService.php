<?php

namespace App\Application\PaymentMethod;

use App\Domain\repositories\PaymentMethodRepository;

class GetAllPaymentMethodsService
{

	public function __construct(PaymentMethodRepository $paymentMethodRepository)
	{
		$this->paymentMethodRepository = $paymentMethodRepository;
	}

	public function run()
	{
		return $this->paymentMethodRepository->all();
	}
}
