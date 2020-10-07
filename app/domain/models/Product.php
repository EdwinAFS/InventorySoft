<?php

namespace App\Domain\models;

class Product
{
	private $productId;
	private $cod;
	private $description;
	private $img;
	private $stock;
	private $purchasePrice;
	private $salePrice;
	private $numOfSales = 0;
	private $created_at;
	private $active;
	private $fK_categoryId;

	public function __construct( $cod, $description, $stock, $purchasePrice, $salePrice, $fK_categoryId )
	{
		$this->setCod ( $cod );
		$this->setDescription ( $description );
		$this->setStock ( $stock );
		$this->setPurchasePrice ( $purchasePrice );
		$this->setSalePrice ( $salePrice );
		$this->setFK_categoryId ( $fK_categoryId );
	}

	/* SET */

	public function setId($productId)
	{
		$this->productId = $productId;
	}
	public function setCod($cod)
	{
		$this->cod = $cod;
	}
	public function setDescription($description)
	{
		$this->description = $description;
	}
	public function setImg($img)
	{
		$this->img = $img;
	}
	public function setStock($stock)
	{
		$this->stock = $stock;
	}
	public function setPurchasePrice($purchasePrice)
	{
		$this->purchasePrice = $purchasePrice;
	}
	public function setSalePrice($salePrice)
	{
		$this->salePrice = $salePrice;
	}
	public function setNumOfSales($numOfSales)
	{
		$this->numOfSales = $numOfSales;
	}
	public function setCreated_at($created_at)
	{
		$this->created_at = $created_at;
	}
	public function setActive($active)
	{
		$this->active = $active;
	}
	public function setFK_categoryId($fK_categoryId)
	{
		$this->fK_categoryId = $fK_categoryId;
	}


	/* GET */

	public function getId()
	{
		return $this->productId;
	}
	public function getCod()
	{
		return $this->cod;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function getImg()
	{
		return $this->img;
	}
	public function getStock()
	{
		return $this->stock;
	}
	public function getPurchasePrice()
	{
		return $this->purchasePrice;
	}
	public function getSalePrice()
	{
		return $this->salePrice;
	}
	public function getNumOfSales()
	{
		return $this->numOfSales;
	}
	public function getCreated_at()
	{
		return $this->created_at;
	}
	public function getActive()
	{
		return $this->active;
	}
	public function getFK_categoryId()
	{
		return $this->fK_categoryId;
	}

	public function get(){
		return [
			"productId" => $this->getId(),
			"cod" => $this->getCod(),
			"description" => $this->getDescription(),
			"img" => $this->getImg(),
			"stock" => $this->getStock(),
			"purchasePrice" => $this->getPurchasePrice(),
			"salePrice" => $this->getSalePrice(),
			"numOfSales" => $this->getNumOfSales(),
			"created_at" => $this->getCreated_at(),
			"active" => $this->getActive(),
			"fK_categoryId" => $this->getFK_categoryId(),
		];
	}
}
