<?php

namespace App\Domain\models;

class SaleProduct
{

	private $saleProductId;	
	private $fk_SaleId;
	private $fk_ProductId;
	private $productQuantity;
	private $totalPayment;
	private $created_at;
	private $active;
	private $deleted_at;
	private $product;

	public function __construct( $fk_SaleId, $fk_ProductId, $productQuantity, $totalPayment )
	{
		$this->setFK_SaleId( $fk_SaleId );
		$this->setFK_ProductId( $fk_ProductId );		
		$this->setProductQuantity( $productQuantity );		
		$this->setTotalPayment( $totalPayment );		
	}

	/* SET */
	public function setId($saleProductId)
	{
		$this->saleProductId = $saleProductId;
	}
	public function setFK_SaleId($fk_SaleId)
	{
		$this->fk_SaleId = $fk_SaleId;
	}
	public function setFK_ProductId($fk_ProductId)
	{
		$this->fk_ProductId = $fk_ProductId;
	}
	public function setProductQuantity($productQuantity)
	{
		$this->productQuantity = $productQuantity;
	}
	public function setTotalPayment($totalPayment)
	{
		$this->totalPayment = $totalPayment;
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
	public function setProduct( $product )
	{
		$this->product = $product;
	}	


	/* GET */
	public function getId(){
		return $this->saleProductId;
	}
	public function getFK_SaleId(){
		return $this->fk_SaleId;
	}
	public function getFK_ProductId(){
		return $this->fk_ProductId;
	}
	public function getProductQuantity(){
		return $this->productQuantity;
	}
	public function getTotalPayment(){
		return $this->totalPayment;
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
	public function getProduct(){
		return $this->product;
	}
	
	public function get(){
		return [
			"Id" => $this->getId(),			
			"fk_SaleId" => $this->getFK_SaleId(),
			"fk_ProductId" => $this->getFK_ProductId(),
			"productQuantity" => $this->getProductQuantity(),
			"totalPayment" => $this->getTotalPayment(),
			"Created_at" => $this->getCreated_at(),
			"Active" => $this->getActive(),
			"Deleted_at" => $this->getDeleted_at(),
		];
	}
}
