<?php

require_once "../app/domain/repositories/AutenticationRepository.php";
require_once "../app/infraestructure/Connection.php";

class AutenticationMySQLRepository implements AutenticationRepository{

	public function verify( Autentication $autentication ){
		$query = "SELECT * FROM Users WHERE username = '{$autentication->getUsername()}' and password = '{$autentication->getPassword()}'";
		$connection = ConnectionDB::connect()->prepare($query);
		$connection->setFetchMode(PDO::FETCH_ASSOC);

		$connection->execute();
		
		$user = $connection->fetch();
		
		if( ! $user ){
			return null;
		}

		$autentication = new Autentication($user['username'], $user['password']);	
		$autentication->setId( $user['id'] );

		return $autentication;	
		
	}

}
