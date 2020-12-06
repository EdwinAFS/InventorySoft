<?php

namespace App\Domain\repositories;

use App\Domain\models\PaymentMethod;

interface PaymentMethodRepository {
	public function all();
}
