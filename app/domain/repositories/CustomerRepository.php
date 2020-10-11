<?php

namespace App\Domain\repositories;

use App\Domain\models\Customer;

interface CustomerRepository {
	public function create( Customer $customer );
	public function update( Customer $customer );
	public function findById(String $id);
	public function findByIdentification(String $identification);
	public function all();
}
