<?php

namespace App\Domain\repositories;

use App\Domain\models\Sale;

interface SaleRepository {
	public function create( Sale $sale );
	public function update( Sale $sale );
	public function findById(String $id);
	public function all( $startDate, $endDate );
	public function report( $startDate, $endDate );
}
