<?php

namespace App\Infraestructure;

use App\Domain\models\SaleProduct;
use App\Domain\repositories\SaleProductRepository;
use App\Infraestructure\Connection;
use PDO;

class SaleProductRepositoryMySql implements SaleProductRepository
{
	private $table = 'saleproduct';

	public function all()
	{
		$query="SELECT * 
				FROM $this->table
				WHERE Deleted_at is null";

		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$salesProducts = [];

		foreach ($connection->fetchAll() as $saleProduct) {
			
			$saleProductObj = new SaleProduct( $saleProduct['FK_SaleId'], $saleProduct['FK_ProductId'], $saleProduct['ProductQuantity'], $saleProduct['TotalPayment']);
			
			$saleProductObj->setId($saleProduct['SaleProductId']);
			$saleProductObj->setCreated_at($saleProduct['Created_at']);
			$saleProductObj->setActive($saleProduct['Active']);
			$saleProductObj->setDeleted_at($saleProduct['Deleted_at']);
			
			array_push($salesProducts, $saleProductObj);
		}

		return $salesProducts;
	}

	public function create(SaleProduct $saleProduct)
	{
		$fk_saleId = $saleProduct->getFK_SaleId();
		$fk_productId = $saleProduct->getFK_ProductId();
		$productQuantity = $saleProduct->getProductQuantity();
		$totalPayment = $saleProduct->getTotalPayment();
		
		$query = "INSERT INTO $this->table(FK_SaleId, FK_ProductId, ProductQuantity ,TotalPayment) VALUES (:FK_SaleId,:FK_ProductId,:ProductQuantity,:TotalPayment);";

		$connection = Connection::connect()->prepare($query);

		$connection->bindParam(":FK_SaleId", $fk_saleId, PDO::PARAM_STR);
		$connection->bindParam(":FK_ProductId", $fk_productId, PDO::PARAM_INT);
		$connection->bindParam(":ProductQuantity", $productQuantity, PDO::PARAM_INT);
		$connection->bindParam(":TotalPayment", $totalPayment, PDO::PARAM_INT);
		
		$connection->execute();
	}

	public function update(SaleProduct $saleProduct)
	{
		$saleProductId = $saleProduct->getId();

		$fk_saleId = $saleProduct->getFK_SaleId();
		$fk_productId = $saleProduct->getFK_ProductId();
		$productQuantity = $saleProduct->getProductQuantity();
		$totalPayment = $saleProduct->getTotalPayment();

		$created_at = $saleProduct->getCreated_at();
		$active = $saleProduct->getActive();
		$deleted_at = $saleProduct->getDeleted_at();

		$query = "UPDATE $this->table SET " .
			"FK_SaleId = :FK_SaleId," .
			"FK_ProductId = :FK_ProductId," .
			"ProductQuantity = :ProductQuantity," .
			"TotalPayment = :TotalPayment," .
			"Created_at = :Created_at" .
			"Active = :Active" .
			"Deleted_at = :Deleted_at" .
			"WHERE SaleProductId = '$saleProductId'";

		$connection = Connection::connect()->prepare($query);
		$connection->bindParam(":FK_SaleId", $fk_saleId, PDO::PARAM_INT);
		$connection->bindParam(":FK_ProductId", $fk_productId, PDO::PARAM_INT);
		$connection->bindParam(":ProductQuantity", $productQuantity, PDO::PARAM_INT);
		$connection->bindParam(":TotalPayment", $totalPayment, PDO::PARAM_INT);
		$connection->bindParam(":Created_at", $created_at, PDO::PARAM_STMT);
		$connection->bindParam(":Active", $active, PDO::PARAM_STR);
		$connection->bindParam(":Deleted_at", $deleted_at, PDO::PARAM_STMT);
		$connection->execute();
	}

	public function findById(String $id)
	{
		$query = "SELECT * FROM $this->table WHERE SaleProductId = $id";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$saleProductData = $connection->fetch();

		if (!$saleProductData) {
			return null;
		}

		$saleProductObj = new SaleProduct( $saleProductData['FK_SaleId'], $saleProductData['FK_ProductId'], $saleProductData['ProductQuantity'], $saleProductData['TotalPayment']);

		$saleProductObj->setId($saleProductData['SaleId']);
		$saleProductObj->setCreated_at($saleProductData['Created_at']);
		$saleProductObj->setActive($saleProductData['Active']);
		$saleProductObj->setDeleted_at($saleProductData['Deleted_at']);

		return $saleProductObj;
	}

	public function delete(string $id)
	{
		$query = "UPDATE $this->table  SET Deleted_at = now()  WHERE SaleProductId = '$id'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();
	}

}
