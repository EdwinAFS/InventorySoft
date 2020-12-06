<?php

namespace App\Application\Sale;

use App\Domain\repositories\SaleRepository;

class ChangeActiveSaleService
{
	public function __construct(SaleRepository $saleRepository)
	{
		$this->saleRepository = $saleRepository;
	}

	public function run($id)
	{
		$sale = $this->saleRepository->findById( $id );

		$sale->setActive( $sale->getActive() == "1"? "0" : "1" ); 
		
		$this->saleRepository->update( $sale );

		return $sale->getActive();
	}
}
