<?php

namespace App\Infraestructure;

use App\Domain\models\Customer;
use App\Domain\repositories\CustomerRepository;
use App\Infraestructure\Connection;
use PDO;

class CustomerRepositoryMySql implements CustomerRepository
{
	private $table = 'customers';

	public function all()
	{
		$query = "SELECT * FROM $this->table WHERE Deleted_at is null "; 

		$connection = Connection::connect()->prepare( $query );
		$connection->execute();

		$customers = [];

		foreach ($connection->fetchAll() as $customer) {
			$customerObj = new Customer( $customer['Name'], $customer['Identification'], $customer['Email'], $customer['Address'], $customer['Birthdate']);

			$customerObj->setId($customer['CustomerId']);
			$customerObj->setPhone($customer['Phone']);
			$customerObj->setCreated_at($customer['Created_at']);
			$customerObj->setActive($customer['Active']);
			$customerObj->setDeleted_at($customer['Deleted_at']);

			array_push($customers, $customerObj);
		}

		return $customers;
	}

	public function create(Customer $customer)
	{
		$name = $customer->getName();
		$identification = $customer->getIdentification();
		$email = $customer->getEmail();
		$address = $customer->getAddress();
		$birthdate = $customer->getBirthdate();
		$phone = $customer->getPhone();

		$query = "INSERT INTO $this->table(Name, Identification, Email, Address, Birthdate, Phone) VALUES (:name, :identification, :email, :address, :birthdate, :phone);";

		$connection = Connection::connect()->prepare($query);
		
		$connection->bindParam(":name", $name, PDO::PARAM_STR);
		$connection->bindParam(":identification", $identification, PDO::PARAM_STR);
		$connection->bindParam(":email", $email, PDO::PARAM_STR);
		$connection->bindParam(":address", $address, PDO::PARAM_STR);
		$connection->bindParam(":birthdate", $birthdate, PDO::PARAM_STR);
		$connection->bindParam(":phone", $phone, PDO::PARAM_STR);
		$connection->execute();
	}

	public function update(Customer $customer)
	{
		$customerId = $customer->getId();
		$name = $customer->getName();
		$identification = $customer->getIdentification();
		$email = $customer->getEmail();
		$address = $customer->getAddress();
		$birthdate = $customer->getBirthdate();
		$phone = $customer->getPhone();
		$created_at = $customer->getCreated_at();
		$active = $customer->getActive();
		$deleted_at = $customer->getDeleted_at();

		$query = "UPDATE $this->table SET ".
					"Name = :name," .
					"Identification = :identification," .
					"Email = :email," .
					"Address = :address," .
					"Birthdate = :birthdate," .
					"Phone = :phone," .
					"Created_at = :created_at," .
					"Active = :active," .
					"Deleted_at = :deleted_at" .
			" WHERE CustomerId = '{$customer->getId()}'";

		$connection = Connection::connect()->prepare($query);
		$connection->bindParam(":name", $name, PDO::PARAM_STR);
		$connection->bindParam(":identification", $identification, PDO::PARAM_STR);
		$connection->bindParam(":email", $email, PDO::PARAM_STR);
		$connection->bindParam(":address", $address, PDO::PARAM_STR);
		$connection->bindParam(":birthdate", $birthdate, PDO::PARAM_STR);
		$connection->bindParam(":phone", $phone, PDO::PARAM_STR);
		$connection->bindParam(":created_at", $created_at, PDO::PARAM_STMT);
		$connection->bindParam(":active", $active, PDO::PARAM_BOOL);
		$connection->bindParam(":deleted_at", $deleted_at, PDO::PARAM_STMT);
		$connection->execute();
	}

	public function findById(String $id)
	{
		$query = "SELECT * FROM $this->table WHERE CustomerId = $id";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$customerData = $connection->fetch();

		if (!$customerData) {
			return null;
		}

		$customerObj = new Customer( $customerData['Name'], $customerData['Identification'], $customerData['Email'], $customerData['Address'], $customerData['Birthdate']);

		$customerObj->setId($customerData['CustomerId']);
		$customerObj->setPhone($customerData['Phone']);
		$customerObj->setCreated_at($customerData['Created_at']);
		$customerObj->setActive($customerData['Active']);
		$customerObj->setDeleted_at($customerData['Deleted_at']);

		return $customerObj;
	}

	public function delete(string $id)
	{
		$query = "UPDATE $this->table  SET Deleted_at = now()  WHERE CustomerId = '$id'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();
	}

	public function findByIdentification(String $identification){
		$query = "SELECT * FROM $this->table WHERE Identification = '$identification'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$customerData = $connection->fetch();

		if (!$customerData) {
			return null;
		}

		$customerObj = new Customer( $customerData['Name'], $customerData['Identification'], $customerData['Email'], $customerData['Address'], $customerData['Birthdate']);

		$customerObj->setId($customerData['CustomerId']);
		$customerObj->setPhone($customerData['Phone']);
		$customerObj->setCreated_at($customerData['Created_at']);
		$customerObj->setActive($customerData['Active']);
		$customerObj->setDeleted_at($customerData['Deleted_at']);

		return $customerObj;
	}

}
