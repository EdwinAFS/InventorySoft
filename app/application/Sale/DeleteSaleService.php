<?php

namespace App\Application\Sale;

use App\Domain\repositories\SaleRepository;

class DeleteSaleService
{
	public function __construct(SaleRepository $saleRepository)
	{
		$this->saleRepository = $saleRepository;
	}

	public function run($id)
	{
		$this->saleRepository->delete($id);
	}
}
