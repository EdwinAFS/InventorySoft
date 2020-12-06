<?php

namespace App\Domain\models;

class Sale
{
	private $saleId;
	private $cod;
	private $taxes;
	private $netPay;
	private $total;
	private $fK_customerId;
	private $fK_sellerId;
	private $fK_paymentMethodId;
	private $created_at;
	private $active;
	private $deleted_at;
	private $saleProducts = [];
	private $seller;
	private $cash;
	private $cashback;
	private $transactionCode = null;
	private $customer;
	private $paymentMethod;

	public function __construct(  $cod, $taxes, $netPay, $total, $fK_customerId, $fK_sellerId, $fK_paymentMethodId )
	{
		$this->setCod( $cod );
		$this->setTaxes( $taxes );
		$this->setNetPay( $netPay );
		$this->setTotal( $total );
		$this->setFK_customerId( $fK_customerId );
		$this->setFK_sellerId( $fK_sellerId );
		$this->setFK_PaymentMethodId( $fK_paymentMethodId );
	}

	/* SET */
	public function setId($saleId)
	{
		$this->saleId = $saleId;
	}
	public function setCod( $cod )
	{
		$this->cod = $cod;
	}
	public function setTaxes( $taxes )
	{
		$this->taxes = $taxes;
	}
	public function setNetPay( $netPay )
	{
		$this->netPay = $netPay;
	}
	public function setTotal( $total )
	{
		$this->total = $total;
	}
	public function setFK_customerId( $fK_customerId )
	{
		$this->fK_customerId = $fK_customerId;
	}
	public function setFK_sellerId( $fK_sellerId )
	{
		$this->fK_sellerId = $fK_sellerId;
	}
	public function setFK_PaymentMethodId( $fK_paymentMethodId )
	{
		$this->fK_paymentMethodId = $fK_paymentMethodId;
	}
	public function setCash( $cash )
	{
		$this->cash = $cash;
	}
	public function setCashback( $cashback )
	{
		$this->cashback = $cashback;
	}
	public function setTransactionCode( $transactionCode )
	{
		$this->transactionCode = $transactionCode;
	}
	public function setCreated_at( $created_at )
	{
		$this->created_at = $created_at;
	}
	public function setActive( $active )
	{
		$this->active = $active;
	}
	public function setDeleted_at( $deleted_at )
	{
		$this->deleted_at = $deleted_at;
	}	

	public function addSaleProducts( SaleProduct $saleProduct )
	{
		array_push($this->saleProducts, $saleProduct);
	}
	public function setSeller( User $seller )
	{
		$this->seller = $seller;
	}	
	public function setCustomer( Customer $customer )
	{
		$this->customer = $customer;	
	}	
	public function setPaymentMethod( PaymentMethod $paymentMethod )
	{
		$this->paymentMethod = $paymentMethod;	
	}	

	/* GET */
	public function getId(){
		return $this->saleId;
	}
	public function getCod(){
		return $this->cod;
	}
	public function getTaxes(){
		return $this->taxes;
	}
	public function getNetPay(){
		return $this->netPay;
	}
	public function getTotal(){
		return $this->total;
	}
	public function getFK_customerId(){
		return $this->fK_customerId;
	}
	public function getFK_sellerId(){
		return $this->fK_sellerId;
	}
	public function getFK_PaymentMethodId(){
		return $this->fK_paymentMethodId;
	}
	public function getCash(  )
	{
		return $this->cash;
	}
	public function getCashback(  )
	{
		return $this->cashback;
	}
	public function getTransactionCode()
	{
		return $this->transactionCode;
	}
	public function getCreated_at(){
		return $this->created_at;
	}
	public function getActive(){
		return $this->active;
	}
	public function getDeleted_at(){
		return $this->deleted_at;
	}
	
	public function getSaleProducts() {
		return $this->saleProducts;
	}
	public function getSeller() :? User {
		return $this->seller;
	}
	public function getCustomer() :? Customer {
		return $this->customer;
	}
	public function getPaymentMethod() :? PaymentMethod {
		return $this->paymentMethod;
	}
	
	public function get(){
		return [
			"Id" => $this->getId(),
			"Cod" => $this->getCod(),
			"Taxes" => $this->getTaxes(),
			"NetPay" => $this->getNetPay(),
			"Total" => $this->getTotal(),
			"FK_customerId" => $this->getFK_customerId(),
			"FK_sellerId" => $this->getFK_sellerId(),
			"FK_paymentMethodId" => $this->getFK_PaymentMethodId(),
			"Cash" => $this->getCash(),
			"Cash" => $this->getCashback(),
			"TransactionCode" => $this->getTransactionCode(),
			"Created_at" => $this->getCreated_at(),
			"Active" => $this->getActive(),
			"Deleted_at" => $this->getDeleted_at(),
			"Seller" => $this->getSeller()? $this->getSeller()->get() : null,
			"Customer" => $this->getCustomer()? $this->getCustomer()->get(): null,
			"PaymentMethod" => $this->getPaymentMethod()? $this->getPaymentMethod()->get() : null
		];
	}
}
