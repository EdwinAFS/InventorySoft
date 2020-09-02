<?php

require_once "../app/domain/repositories/AutenticationRepository.php";
require_once "../app/infraestructure/Connection.php";

class AutenticationMySQLRepository implements AutenticationRepository{

	public function verify( Autentication $autentication ){
		$query = "SELECT * FROM User WHERE username = '{$autentication->getUsername()}' and password = '{$autentication->getPassword()}'";
		$connection = ConnectionDB::connect()->prepare($query);
		$connection->setFetchMode(PDO::FETCH_ASSOC);

		$connection->execute();
		
		foreach ($connection->fetch() as $user) {
			return new Autentication($user['username'], $user['password']);	
		}
	}

}
