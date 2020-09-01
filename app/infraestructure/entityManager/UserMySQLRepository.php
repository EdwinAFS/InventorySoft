<?php

require_once "../app/domain/repositories/UserRepository.php";

class UserMySQLRepository implements UserRepository{

	public function create( User $user ){
		return $user;
	}
	
	public function update( User $user ){
		return $user;
	}

	public function findById(String $id){
		return new User( "test" , "test" , "test" );
	}

	public function users(){

		$user1 = new User( "test1" , "test1" , "test1" );
		$user1->setLastLogin( date("Y-m-d H:i:s") );
		$user2 = new User( "test2" , "test2" , "test2" );
		$user2->setLastLogin( date("Y-m-d H:i:s") );
		
		$users = [
			$user1,
			$user2
		];

		return $users;
	}

}
