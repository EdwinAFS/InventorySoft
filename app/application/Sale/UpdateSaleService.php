<?php

namespace App\Application\Sale;

use App\Domain\repositories\SaleRepository;

class UpdateSaleService
{

	public function __construct(SaleRepository $saleRepository)
	{
		$this->saleRepository = $saleRepository;
	}

	public function run( $id, $cod, $taxes, $netPay, $total, $products, $fK_customerId, $fK_sellerId, $fK_paymentMethodId )
	{

		$sale = $this->saleRepository->findById( $id );
		
		$sale->setCod($cod);
		$sale->setTaxes($taxes);
		$sale->setNetPay($netPay);
		$sale->setTotal($total);
		$sale->setFK_customerId($fK_customerId);
		$sale->setFK_sellerId($fK_sellerId);
		$sale->setFK_PaymentMethodId($fK_paymentMethodId);

		$this->saleRepository->update($sale);
	}

}
