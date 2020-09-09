<?php

require_once "../app/domain/repositories/UserRepository.php";
require_once "../app/infraestructure/Connection.php";

class UserMySQLRepository implements UserRepository{

	private $table = 'users';

	public function create( User $user ){
		return $user;
	}
	
	public function update( User $user ){
		return $user;
	}
	
	public function delete( string $id ){
		return true;
	}

	public function findById(String $id){
		$query = "SELECT * FROM $this->table WHERE id = $id";
		$connection = ConnectionDB::connect()->prepare($query);
		$connection->execute();

		$userData = $connection->fetch();

		if( ! $userData ){
			return null;
		}

		$user = new User($userData['name'], $userData['username'], $userData['password']);	
		$user->setId($userData['id']);
		$user->setPhoto($userData['photo']);
		$user->setActive($userData['active']);
		$user->setLastLogin($userData['last_login']);

		return $user;
		
	}

	public function users(){

		$connection = ConnectionDB::connect()->prepare("SELECT * FROM $this->table WHERE active = 1");
		$connection->execute();
		
		$users = [];

		foreach ($connection->fetchAll() as $user) {

			$userObj = new User( $user['name'], $user['username'], '' );
			$userObj->setId($user['id']);
			$userObj->setPhoto($user['photo']);
			$userObj->setActive($user['active']);
			$userObj->setLastLogin($user['last_login']);
			array_push($users, $userObj);
		}

		return $users;
	}

}
