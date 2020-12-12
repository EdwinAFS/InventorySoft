<?php

namespace App\Infraestructure;

use App\Domain\models\Customer;
use App\Domain\models\PaymentMethod;
use App\Domain\models\Product;
use App\Domain\models\Sale;
use App\Domain\models\SaleProduct;
use App\Domain\models\User;
use App\Domain\repositories\SaleRepository;
use App\Infraestructure\Connection;
use JsonSerializable;
use PDO;

class SaleRepositoryMySql implements SaleRepository
{
	private $table = 'sales';

	public function all($startDate, $endDate)
	{
		$query = "SELECT 
					S.*, 
					
					PM.Description as PMDescription, 
					
					C.Name as CName,
					C.Identification,
					C.Email,
					C.Address,
					C.Birthdate,

					U.id as userId,
					U.name as UName,
					U.username,
					U.rolID,

					SPM.FK_PaymentMethodId
				FROM $this->table as S
				INNER JOIN salepaymentmethod SPM ON S.SaleId = SPM.FK_SaleId
				INNER JOIN paymentmethods PM ON SPM.FK_PaymentMethodId = PM.PaymentMethodId
				INNER JOIN users U ON S.FK_sellerId = U.id
				INNER JOIN customers C ON S.FK_customerId = C.CustomerId
				WHERE 
					S.Deleted_at is null
					AND DATE(S.Created_at) BETWEEN '$startDate' AND '$endDate'";


		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$sales = [];

		foreach ($connection->fetchAll() as $sale) {
			$saleObj = new Sale($sale['Cod'], $sale['Taxes'], $sale['NetPay'], $sale['Total'], [], $sale['FK_customerId'], $sale['FK_sellerId'], $sale['FK_PaymentMethodId']);
			$customer = new Customer($sale['CName'], $sale['Identification'], $sale['Email'], $sale['Address'], $sale['Birthdate']);
			$seller = User::forUpdate($sale['userId'], $sale['UName'], $sale['username'], $sale['rolID'],);
			$paymentMethod = new PaymentMethod($sale['PMDescription']);

			$saleObj->setId($sale['SaleId']);
			$saleObj->setCreated_at($sale['Created_at']);
			$saleObj->setActive($sale['Active']);
			$saleObj->setDeleted_at($sale['Deleted_at']);

			$saleObj->setSeller($seller);
			$saleObj->setCustomer($customer);
			$saleObj->setPaymentMethod($paymentMethod);

			array_push($sales, $saleObj);
		}

		return $sales;
	}

	public function create(Sale $sale)
	{
		$saleId = $sale->getId();
		$cod = $sale->getCod();
		$taxes = $sale->getTaxes();
		$netPay = $sale->getNetPay();
		$total = $sale->getTotal();
		$fK_customerId = $sale->getFK_customerId();
		$fK_sellerId = $sale->getFK_sellerId();
		$fK_PaymentMethodId = $sale->getFK_PaymentMethodId();
		$cash = $sale->getCash();
		$cashback = $sale->getCashback();
		$transactionCode = $sale->getTransactionCode();

		$connection = Connection::connect();

		try {
			$connection->beginTransaction();

			$query = "INSERT INTO $this->table(SaleId,Cod,Taxes,NetPay,Total,FK_customerId,FK_sellerId) VALUES (:SaleId,:Cod,:Taxes,:NetPay,:Total,:FK_customerId,:FK_sellerId);";
			$queryPrepare = $connection->prepare($query);

			$queryPrepare->bindParam(":SaleId", $saleId, PDO::PARAM_STR);
			$queryPrepare->bindParam(":Cod", $cod, PDO::PARAM_STR);
			$queryPrepare->bindParam(":Taxes", $taxes, PDO::PARAM_INT);
			$queryPrepare->bindParam(":NetPay", $netPay, PDO::PARAM_STR);
			$queryPrepare->bindParam(":Total", $total, PDO::PARAM_STR);
			$queryPrepare->bindParam(":FK_customerId", $fK_customerId, PDO::PARAM_INT);
			$queryPrepare->bindParam(":FK_sellerId", $fK_sellerId, PDO::PARAM_STR);
			$queryPrepare->execute();

			$query = "INSERT INTO salepaymentmethod(FK_SaleId, FK_PaymentMethodId, TransactionCode, Cash, Cashback) VALUES ((SELECT SaleId FROM $this->table WHERE Cod = '$cod'),:FK_PaymentMethodId, :TransactionCode, :Cash, :Cashback);";
			$queryPrepare = $connection->prepare($query);
			$queryPrepare->bindParam(":FK_PaymentMethodId", $fK_PaymentMethodId, PDO::PARAM_INT);
			$queryPrepare->bindParam(":TransactionCode", $transactionCode, PDO::PARAM_STR);
			$queryPrepare->bindParam(":Cash", $cash, PDO::PARAM_INT);
			$queryPrepare->bindParam(":Cashback", $cashback, PDO::PARAM_INT);
			$queryPrepare->execute();



			foreach ($sale->getSaleProducts() as $saleProduct) {

				$fK_ProductId = $saleProduct->getFK_ProductId();
				$productQuantity = $saleProduct->getProductQuantity();
				$totalPayment = $saleProduct->getTotalPayment();

				$query = "INSERT INTO saleproduct(FK_SaleId, FK_ProductId, ProductQuantity ,TotalPayment) VALUES ( (SELECT SaleId FROM $this->table WHERE Cod = '$cod'),:FK_ProductId,:ProductQuantity,:TotalPayment);";
				$queryPrepare = $connection->prepare($query);
				$queryPrepare->bindParam(":FK_ProductId", $fK_ProductId, PDO::PARAM_INT);
				$queryPrepare->bindParam(":ProductQuantity", $productQuantity, PDO::PARAM_INT);
				$queryPrepare->bindParam(":TotalPayment", $totalPayment, PDO::PARAM_STR);
				$queryPrepare->execute();

				$query = "UPDATE products SET Stock = (Stock - 2), NumOfSales = (NumOfSales + 2) WHERE ProductId = '$fK_ProductId';";
				$queryPrepare = $connection->prepare($query);
				$queryPrepare->execute();
			}

			$connection->commit();
		} catch (\Exception $e) {
			if ($connection->inTransaction()) {
				$connection->rollback();
			}

			throw $e;
		}
	}

	public function update(Sale $sale)
	{
		$saleId = $sale->getId();
		$cod = $sale->getCod();
		$taxes = $sale->getTaxes();
		$netPay = $sale->getNetPay();
		$total = $sale->getTotal();
		$fK_customerId = $sale->getFK_customerId();
		$fK_sellerId = $sale->getFK_sellerId();
		$fK_PaymentMethodId = $sale->getFK_PaymentMethodId();
		$created_at = $sale->getCreated_at();
		$active = $sale->getActive();
		$deleted_at = $sale->getDeleted_at();

		$query = "UPDATE $this->table SET " .
			"cod = :Cod," .
			"taxes = :Taxes," .
			"netPay = :NetPay," .
			"total = :Total," .
			"fK_customerId = :FK_customerId," .
			"fK_sellerId = :FK_sellerId," .
			"fK_PaymentMethodId = :FK_PaymentMethodId" .
			"created_at = :Created_at" .
			"active = :Active" .
			"deleted_at = :Deleted_at" .
			" WHERE SaleId = '$saleId'";

		$connection = Connection::connect()->prepare($query);
		$connection->bindParam(":Cod", $cod, PDO::PARAM_STR);
		$connection->bindParam(":Taxes", $taxes, PDO::PARAM_INT);
		$connection->bindParam(":NetPay", $netPay, PDO::PARAM_STR);
		$connection->bindParam(":Total", $total, PDO::PARAM_STR);
		$connection->bindParam(":FK_customerId", $fK_customerId, PDO::PARAM_INT);
		$connection->bindParam(":FK_sellerId", $fK_sellerId, PDO::PARAM_STMT);
		$connection->bindParam(":FK_PaymentMethodId", $fK_PaymentMethodId, PDO::PARAM_INT);
		$connection->bindParam(":Created_at", $created_at, PDO::PARAM_STMT);
		$connection->bindParam(":Active", $active, PDO::PARAM_STMT);
		$connection->bindParam(":Deleted_at", $deleted_at, PDO::PARAM_STMT);
		$connection->execute();
	}

	public function findById(String $id)
	{
		$query = "SELECT 
					S.*,
					PM.Description as PMDescription, 
					SPM.FK_PaymentMethodId
				FROM $this->table S
				INNER JOIN salepaymentmethod SPM ON S.SaleId = SPM.FK_SaleId
				INNER JOIN paymentmethods PM ON SPM.FK_PaymentMethodId = PM.PaymentMethodId
				WHERE 
					SaleId = '$id'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$saleData = $connection->fetch();

		if (!$saleData) {
			return null;
		}

		$saleObj = new Sale($saleData['Cod'], $saleData['Taxes'], $saleData['NetPay'], $saleData['Total'], $saleData['FK_customerId'], $saleData['FK_sellerId'], $saleData['FK_PaymentMethodId']);

		$saleObj->setId($saleData['SaleId']);
		$saleObj->setCreated_at($saleData['Created_at']);
		$saleObj->setActive($saleData['Active']);
		$saleObj->setDeleted_at($saleData['Deleted_at']);

		$paymentMethodObj = new PaymentMethod($saleData['PMDescription']);
		$saleObj->setPaymentMethod($paymentMethodObj);

		$query = "SELECT 
					SP.FK_SaleId, 
					SP.FK_ProductId, 
					SP.ProductQuantity,
					SP.TotalPayment,
					P.Cod,
					P.Description,
					P.Stock,
					P.PurchasePrice,
					P.SalePrice,
					P.FK_categoryId
				FROM saleproduct SP
				INNER JOIN products P ON P.ProductId = SP.FK_productId
				WHERE 
					FK_SaleId = '$id'";

		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		foreach ($connection->fetchAll() as $saleProduct) {

			$saleProductObj = new SaleProduct(
				$saleProduct['FK_SaleId'],
				$saleProduct['FK_ProductId'],
				$saleProduct['ProductQuantity'],
				$saleProduct['TotalPayment']
			);

			$product = new Product(
				$saleProduct['Cod'],
				$saleProduct['Description'],
				$saleProduct['Stock'],
				$saleProduct['PurchasePrice'],
				$saleProduct['SalePrice'],
				$saleProduct['FK_categoryId']
			);

			$saleProductObj->setProduct($product);

			$saleObj->addSaleProducts($saleProductObj);
		}

		return $saleObj;
	}

	public function delete(string $id)
	{
		$connection = Connection::connect();

		try {
			$connection->beginTransaction();

			$query = "UPDATE $this->table  SET Deleted_at = now()  WHERE SaleId = '$id'";
			$queryPrepare = $connection->prepare($query);
			$queryPrepare->execute();

			$query = "UPDATE salepaymentmethod  SET Deleted_at = now()  WHERE FK_SaleId = '$id'";
			$queryPrepare = $connection->prepare($query);
			$queryPrepare->execute();

			$query = "UPDATE saleproduct  SET Deleted_at = now()  WHERE FK_SaleId = '$id'";
			$queryPrepare = $connection->prepare($query);
			$queryPrepare->execute();

			$query = "SELECT 
						FK_ProductId,
						ProductQuantity
					FROM	
						saleproduct
					WHERE
						FK_SaleId = '$id'";
			$queryPrepare = $connection->prepare($query);
			$queryPrepare->execute();

			foreach ($queryPrepare->fetchAll() as $product) {
				$query = "UPDATE products SET Stock = Stock + " . $product["ProductQuantity"] . " WHERE ProductId = '" . $product["FK_ProductId"] . "'";
				$queryPrepare = $connection->prepare($query);
				$queryPrepare->execute();
			}

			$connection->commit();
		} catch (\Exception $e) {
			if ($connection->inTransaction()) {
				$connection->rollback();
			}

			throw $e;
		}
	}

	public function report($startDate, $endDate)
	{

		$connection = Connection::connect();
		$sql = "";
		$response = [];

		/* VENTAS POR MES */
		$sql = "SELECT 
					MONTH(Created_at) AS Month, 
					YEAR(Created_at) AS Year, 
					SUM(NetPay) AS Total 
				FROM 
					sales 
				WHERE
					DATE(Created_at) BETWEEN '$startDate' AND '$endDate'
				GROUP BY 
					MONTH(Created_at), YEAR(Created_at) 
				ORDER BY 
					YEAR(Created_at), MONTH(Created_at)";
		$query = $connection->prepare($sql);
		$query->execute();
		
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
  			$response['SalesMonth'][] = $row;
	  	}
		
		/* TOP 10 DE LOS PRODUCTO MAS VENDIDOS */
		$sql = "SELECT 
					P.Description, 
					SUM(SA.ProductQuantity) AS ProductQuantity
				FROM 
					saleproduct SA
				INNER JOIN 
					products P ON SA.FK_productId = P.ProductId
				WHERE
					DATE(SA.Created_at) BETWEEN '$startDate' AND '$endDate'
				GROUP BY 
					SA.FK_productId
				ORDER BY 
					ProductQuantity DESC
				LIMIT 
					10";
		$query = $connection->prepare($sql);
		$query->execute();
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			$response['TopProducts'][] = $row;
		}		
		/* TOP 3 VENDEDORES CON MAS VENTAS */
		$sql = "SELECT 
					Name, 
					photo,
					SUM(NetPay) AS Total 
				FROM 
					sales S
				INNER JOIN 
					users U ON S.FK_sellerId = U.id
				WHERE
					DATE(S.Created_at) BETWEEN '$startDate' AND '$endDate'
				GROUP BY 
					S.FK_sellerId
				ORDER BY 
					Total
				LIMIT
					3";
		$query = $connection->prepare($sql);
		$query->execute();
		while($row=$query->fetch(PDO::FETCH_ASSOC)){
			$response['TopSellers'][] = $row;
		}

		return $response;
	}
}
