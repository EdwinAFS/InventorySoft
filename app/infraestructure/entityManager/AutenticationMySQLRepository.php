<?php

require_once "../app/domain/repositories/AutenticationRepository.php";

class AutenticationMySQLRepository implements AutenticationRepository{

	public function verify( Autentication $autentication ){
		$autentication->setId(1);
		return $autentication;
	}

}
