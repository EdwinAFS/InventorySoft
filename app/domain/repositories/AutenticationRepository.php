<?php

namespace App\Domain\repositories;

use App\Domain\models\Autentication;

interface AutenticationRepository {
	public function verify( Autentication $autentication );
}
