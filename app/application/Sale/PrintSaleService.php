<?php

namespace App\Application\Sale;

use App\Domain\PDF;
use App\Domain\repositories\CustomerRepository;
use App\Domain\repositories\SaleRepository;
use App\Domain\repositories\UserRepository;

class PrintSaleService
{

	public function __construct(PDF $pdf, SaleRepository $saleRepository, CustomerRepository $customerRepository, UserRepository $userRepository)
	{
		$this->pdf = $pdf;
		$this->saleRepository = $saleRepository;
		$this->customerRepository = $customerRepository;
		$this->userRepository = $userRepository;
	}

	public function run( $id )
	{		
		$sale = $this->saleRepository->findById( $id );
		$customer = $this->customerRepository->findById( $sale->getFK_customerId() );
		$seller = $this->userRepository->findById( $sale->getFK_sellerId() );

		$this->pdf->header();

		// Logo
		$this->pdf->setX(40 );
		$this->pdf->print("Inventory", 25, 25, 25);

		// Factura #
		$this->pdf->setX(140);
		$this->pdf->print("Factura No", 25, 25, 25, 'B');
		
		$this->pdf->Ln();
		$this->pdf->setY(20);
		$this->pdf->setX(140);
		$this->pdf->print($sale->getCod(), 25, 25, 20, 'BI');
		
		$this->pdf->dataCard('', [
			$customer->getIdentification(), $customer->getAddress(), $customer->getPhone(), $customer->getEmail(), $sale->getPaymentMethod()->getDescription()
		], ['Nit', 'Direccion', 'Telefono', 'Correo', 'Forma de pago'], $this->pdf->margin, 50, 30);

		$this->pdf->dataCard('', [
			$seller->getName(), $sale->getCreated_at()
		], ["Vendedor", 'Fecha'], $this->pdf->margin + 80, 50, 25);

		$dataTable = [];

		foreach ($sale->getSaleProducts() as $saleProducts) {
			array_push($dataTable, [
				$saleProducts->getProduct()->getCod(),
				$saleProducts->getProduct()->getDescription(),
				'$ '.number_format($saleProducts->getTotalPayment()/$saleProducts->getProductQuantity(), 2 ),
				$saleProducts->getProductQuantity(),
				'$ '.number_format( $saleProducts->getTotalPayment(), 2)
			]);
		}

		$this->pdf->setY( 90 );

		$this->pdf->createTable(
			[
				'Codigo', 'Producto', 'Costo unitario', 'Cantidad', 'Total'
			],
			$dataTable
		);
		
		$this->pdf->Ln();

		$this->pdf->Line( 128, 200, [31, 97, 141] );

		$this->pdf->setX( 41*3 );
		$this->pdf->print( "Subtotal", 38, 9, 12, 'B', 'C' );
		$this->pdf->print( '$ '.number_format($sale->getTotal(), 2), 40, 9, 12, '', 'C' );
		$this->pdf->Ln();
		
		$this->pdf->setX( 41*3 );
		$this->pdf->print( "IVA", 38, 9, 12, 'B', 'C' );
		$this->pdf->print( '$ '.number_format($sale->getTotal() * ($sale->getTaxes()/100), 2), 40, 9, 12, '', 'C' );
		$this->pdf->Ln();
		
		$this->pdf->setX( 41*3 );
		$this->pdf->print( "Total", 38, 9, 12, 'B', 'C' );
		$this->pdf->print( '$ '.number_format($sale->getNetPay(), 2), 40, 9, 12, '', 'C' );

		
		$this->pdf->Output( "factura_".date('YmdHis').".pdf", "I" );
	}
}
