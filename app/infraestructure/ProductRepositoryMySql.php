<?php

namespace App\Infraestructure;

use App\Domain\models\Product;
use App\Domain\repositories\ProductRepository;
use App\Infraestructure\Connection;
use PDO;

class ProductRepositoryMySql implements ProductRepository
{
	private $table = 'products';

	public function all( $limit = 0, $offset = 0 )
	{
		$filterForLimit = $limit > 0? "LIMIT $limit OFFSET $offset" : "";

		$query = "SELECT * FROM $this->table WHERE Deleted_at is null $filterForLimit"; 

		$connection = Connection::connect()->prepare( $query );
		$connection->execute();

		$products = [];

		foreach ($connection->fetchAll() as $product) {
			
			$productObj = new Product($product['Cod'], $product['Description'], $product['Stock'], $product['PurchasePrice'], $product['SalePrice'], $product['FK_categoryId']);
			$productObj->setId($product['ProductId']);
			$productObj->setImg($product['Img']);
			$productObj->setActive($product['Active']);
			$productObj->setNumOfSales($product['NumOfSales']);

			array_push($products, $productObj);
		}

		return $products;
	}

	public function create(Product $product)
	{
		$cod = $product->getCod();
		$description = $product->getDescription();
		$img = $product->getImg();
		$stock = $product->getStock();
		$purchasePrice = $product->getPurchasePrice();
		$salePrice = $product->getSalePrice();
		$numOfSales = $product->getNumOfSales();
		$fK_categoryId = $product->getFK_categoryId();

		$query = "INSERT INTO $this->table(Cod, Description, Img, Stock, PurchasePrice, SalePrice, NumOfSales, FK_categoryId) VALUES (:Cod, :Description, :Img, :Stock, :PurchasePrice, :SalePrice, :NumOfSales, :FK_categoryId);";

		$connection = Connection::connect()->prepare($query);
		$connection->bindParam(":Cod", $cod, PDO::PARAM_STR);
		$connection->bindParam(":Description", $description, PDO::PARAM_STR);
		$connection->bindParam(":Img", $img, PDO::PARAM_STR);
		$connection->bindParam(":Stock", $stock, PDO::PARAM_STR);
		$connection->bindParam(":PurchasePrice", $purchasePrice, PDO::PARAM_STR);
		$connection->bindParam(":SalePrice", $salePrice, PDO::PARAM_STR);
		$connection->bindParam(":NumOfSales", $numOfSales, PDO::PARAM_STR);
		$connection->bindParam(":FK_categoryId", $fK_categoryId, PDO::PARAM_STR);
		$connection->execute();
	}

	public function update(Product $product)
	{
		$cod = $product->getCod();
		$description = $product->getDescription();
		$img = $product->getImg();
		$stock = $product->getStock();
		$purchasePrice = $product->getPurchasePrice();
		$salePrice = $product->getSalePrice();
		$numOfSales = $product->getNumOfSales();
		$fK_categoryId = $product->getFK_categoryId();
		$active = $product->getActive();

		$query = "UPDATE $this->table SET ".
					"Cod = :Cod," .
					"Description = :Description," .
					"Img = :Img," .
					"Stock = :Stock," .
					"PurchasePrice = :PurchasePrice," .
					"SalePrice = :SalePrice," .
					"NumOfSales = :NumOfSales," .
					"FK_categoryId = :FK_categoryId" .
			(($active != "") ? ", Active = :Active" : "") .
			" WHERE ProductId = '{$product->getId()}'";

		$connection = Connection::connect()->prepare($query);
		$connection->bindParam(":Cod", $cod, PDO::PARAM_STR);
		$connection->bindParam(":Description", $description, PDO::PARAM_STR);
		$connection->bindParam(":Img", $img, PDO::PARAM_STR);
		$connection->bindParam(":Stock", $stock, PDO::PARAM_STR);
		$connection->bindParam(":PurchasePrice", $purchasePrice, PDO::PARAM_STR);
		$connection->bindParam(":SalePrice", $salePrice, PDO::PARAM_STR);
		$connection->bindParam(":NumOfSales", $numOfSales, PDO::PARAM_STR);
		$connection->bindParam(":FK_categoryId", $fK_categoryId, PDO::PARAM_STR);
		if ($active != "") {
			$connection->bindParam(":Active", $active, PDO::PARAM_STR);
		}
		$connection->execute();
	}

	public function findById(String $id)
	{
		$query = "SELECT * FROM $this->table WHERE ProductId = $id";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$productData = $connection->fetch();

		if (!$productData) {
			return null;
		}

		$product = new Product($productData['Cod'], $productData['Description'], $productData['Stock'], $productData['PurchasePrice'], $productData['SalePrice'], $productData['FK_categoryId']);
		$product->setId($productData['ProductId']);
		$product->setImg($productData['Img']);
		$product->setActive($productData['Active']);
		$product->setNumOfSales($productData['NumOfSales']);

		return $product;
	}

	public function delete(string $id)
	{
		$query = "UPDATE $this->table  SET Deleted_at = now()  WHERE ProductId = '$id'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();
	}

	public function findByCod(String $cod){
		$query = "SELECT * FROM $this->table WHERE cod = '$cod'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$productData = $connection->fetch();

		if (!$productData) {
			return null;
		}

		$product = new Product($productData['Cod'], $productData['Description'], $productData['Stock'], $productData['PurchasePrice'], $productData['SalePrice'], $productData['FK_categoryId']);
		$product->setId($productData['ProductId']);
		$product->setImg($productData['Img']);
		$product->setActive($productData['Active']);

		return $product;
	}

	public function totalRecords(){
		$query = "SELECT count(*) FROM $this->table";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();
		$countRecords = $connection->fetch();

		if (!$countRecords) {
			return 0;
		}

		return $countRecords[0];
	}
}
