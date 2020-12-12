<?php

namespace App\Application\Sale;

use App\Domain\repositories\SaleRepository;

class ReportSalesService
{

	public function __construct(SaleRepository $saleRepository)
	{
		$this->saleRepository = $saleRepository;
	}

	public function run( $startDate, $endDate)
	{

		if( empty($startDate) ){
			$startDate = date("Y-m-d",strtotime(date("Y-m-d")."- 1 month"));
		}
		
		if( empty($endDate) ){
			$endDate = date("Y-m-d");
		}

		return $this->saleRepository->report( $startDate, $endDate );
	}
}
