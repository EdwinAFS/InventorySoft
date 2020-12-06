<?php

namespace App\Application\Sale;

use App\Domain\repositories\SaleRepository;

class GetAllSalesService
{

	public function __construct(SaleRepository $saleRepository)
	{
		$this->saleRepository = $saleRepository;
	}

	public function run( $startDate, $endDate)
	{
		return $this->saleRepository->all( $startDate, $endDate );
	}
}
