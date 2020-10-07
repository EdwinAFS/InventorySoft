<?php

namespace App\Domain\repositories;

use App\Domain\models\Product;

interface ProductRepository {
	public function create( Product $product );
	public function update( Product $product );
	public function findById(String $id);
	public function findByCod(String $cod);
	public function totalRecords();
	public function all( $limit = 0, $offset = 0);

}
