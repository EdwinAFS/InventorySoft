<?php

namespace App\Domain\repositories;

use App\Domain\models\SaleProduct;

interface SaleProductRepository {
	public function create( SaleProduct $sale );
	public function update( SaleProduct $sale );
	public function findById(String $id);
	public function all();
}
