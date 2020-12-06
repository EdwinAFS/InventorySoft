<?php

namespace App\Application\Sale;

use App\Domain\models\SaleProduct;
use App\Domain\models\Sale;
use App\Domain\repositories\SaleRepository;
use App\Domain\ValueObjects\Uuid;

class CreateSaleService
{
	public function __construct(SaleRepository $saleRepository)
	{
		$this->saleRepository = $saleRepository;
	}

	public function run($cod, $taxes, $netPay, $total, $products, $fK_customerId, $fK_sellerId, $fK_paymentMethodId, $transactionCode, $cash, $cashback )
	{
		$sale = new Sale($cod, $taxes, $netPay, $total, $fK_customerId, $fK_sellerId, $fK_paymentMethodId );
		$sale->setId( Uuid::random()->value() );
		$sale->setTransactionCode( $transactionCode );
		$sale->setCash( $cash );
		$sale->setCashback( $cashback );
		
		$productsList = json_decode($products, true); 

		foreach ($productsList as $product) {
			$productSale = new SaleProduct( $sale->getCod(), $product['productId'], $product['productQuantity'], $product['totalPayment'] );
			$sale->addSaleProducts( $productSale );
		}
		
		$this->saleRepository->create($sale);
	}

}

