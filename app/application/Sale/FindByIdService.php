<?php

namespace App\Application\Sale;

use App\Domain\repositories\SaleRepository;

class FindByIdService
{

	public function __construct(SaleRepository $saleRepository)
	{
		$this->saleRepository = $saleRepository;
	}

	public function run( $id )
	{
		return $this->saleRepository->findById( $id );
	}
}
