<?php

namespace App\Infraestructure;

use App\Domain\models\PaymentMethod;
use App\Domain\repositories\PaymentMethodRepository;
use App\Infraestructure\Connection;

class PaymentMethodRepositoryMySql implements PaymentMethodRepository
{
	private $table = 'paymentMethods';

	public function all()
	{
		$connection = Connection::connect()->prepare("SELECT * FROM $this->table");
		$connection->execute();

		$paymentMethods = [];

		foreach ($connection->fetchAll() as $paymentMethod) {
			
			$paymentMethodObj = new PaymentMethod($paymentMethod['Description']);
			$paymentMethodObj->setId($paymentMethod['PaymentMethodId']);
			$paymentMethodObj->setActive($paymentMethod['Active']);
			
			array_push($paymentMethods, $paymentMethodObj);
		}

		return $paymentMethods;
	}
}
