<?php

namespace App\Infraestructure;

use App\Domain\models\Autentication;
use App\Domain\repositories\AutenticationRepository;
use App\Infraestructure\Connection;
use PDO;

class AutenticationRepositoryMySql implements AutenticationRepository{

	public function verify( Autentication $autentication ){
		$query = "SELECT * FROM Users WHERE username = '{$autentication->getUsername()}' and password = '{$autentication->getPassword()}'";
		$connection = Connection::connect()->prepare($query);
		$connection->setFetchMode(PDO::FETCH_ASSOC);

		$connection->execute();
		
		$user = $connection->fetch();
		
		if( ! $user ){
			return null;
		}

		$autentication = new Autentication($user['username'], $user['password']);	
		$autentication->setId( $user['id'] );
		$autentication->setName( $user['name'] );

		return $autentication;	
		
	}

}
