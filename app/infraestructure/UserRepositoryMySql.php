<?php

namespace App\Infraestructure;

use App\Domain\models\User;
use App\Domain\repositories\UserRepository;
use App\Infraestructure\Connection;
use PDO;

class UserRepositoryMySql implements UserRepository
{

	private $table = 'users';

	public function create(User $user)
	{
		$id = $user->getId();
		$name = $user->getName();
		$username = $user->getUsername();
		$rolID = $user->getRolID();
		$password = $user->getPassword();
		$photoUrl = $user->getPhoto();

		$query = "INSERT INTO $this->table(id ,name, username, password, rolID, photo, active) VALUES (:id, :name, :username, :password, :rolID, :photo, 1);";
		$connection = Connection::connect()->prepare($query);
		
		$connection->bindParam(":id", $id, PDO::PARAM_STR);
		$connection->bindParam(":name", $name, PDO::PARAM_STR);
		$connection->bindParam(":rolID", $rolID, PDO::PARAM_STR);
		$connection->bindParam(":photo", $photoUrl, PDO::PARAM_STR);
		$connection->bindParam(":username", $username, PDO::PARAM_STR);
		$connection->bindParam(":password", $password, PDO::PARAM_STR);
		
		$connection->execute();
	}

	public function update(User $user)
	{
		$name = $user->getName();
		$username = $user->getUsername();
		$password = $user->getPassword();
		$active = $user->getActive();
		$lastLogin = $user->getLastLogin();
		$rolID = $user->getRolID();
		$photoUrl = $user->getPhoto();

		$query = "UPDATE $this->table SET 
					active = :active,
					name = :name,
					username = :username,
					password = :password,
					photo = :photoUrl,
					rolID = :rolID,
					last_login = :last_login
					WHERE id = '{$user->getId()}'";

		$connection = Connection::connect()->prepare($query);

		$connection->bindParam(":name", $name, PDO::PARAM_STR);
		$connection->bindParam(":username", $username, PDO::PARAM_STR);
		$connection->bindParam(":rolID", $rolID, PDO::PARAM_STR);
		$connection->bindParam(":password", $password, PDO::PARAM_STR);
		$connection->bindParam(":photoUrl", $photoUrl, PDO::PARAM_STR);
		$connection->bindParam(":last_login", $lastLogin, PDO::PARAM_STR);
		$connection->bindParam(":active", $active, PDO::PARAM_STR);

		$connection->execute();
	}

	public function delete(string $id)
	{
		$query = "UPDATE $this->table  SET Active = 0 WHERE id = '$id'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();
	}

	public function findById(String $id)
	{
		$query = "SELECT * FROM $this->table WHERE id = '$id'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$userData = $connection->fetch();

		if (!$userData) {
			return null;
		}

		$user = User::forUpdate($userData['id'], $userData['name'], $userData['username'], $userData['rolID'], $userData['password']);		;
		$user->setId($userData['id']);
		$user->setPhoto($userData['photo']);
		$user->setActive($userData['active']);
		$user->setLastLogin($userData['last_login']);
		return $user;
	}

	public function findByUsername(String $username)
	{
		$query = "SELECT * FROM $this->table WHERE username = '$username'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$userData = $connection->fetch();

		if (!$userData) {
			return null;
		}

		$user = User::forUpdate($userData['id'], $userData['name'], $userData['username'], $userData['rolID'], $userData['password']);
		$user->setPhoto($userData['photo']);
		$user->setActive($userData['active']);
		$user->setLastLogin($userData['last_login']);

		return $user;
	}

	public function users()
	{
		$connection = Connection::connect()->prepare("SELECT * FROM $this->table");
		$connection->execute();

		$users = [];

		foreach ($connection->fetchAll() as $user) {
			$userObj = User::forUpdate($user['id'], $user['name'], $user['username'], $user['rolID'] );
			$userObj->setPhoto($user['photo']);
			$userObj->setActive($user['active']);
			$userObj->setLastLogin($user['last_login']);
			array_push($users, $userObj);
		}

		return $users;
	}
}
