<?php

namespace App\Infraestructure;

use App\Domain\models\Rol;
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
		$query = "UPDATE $this->table  SET Delete_at = now() WHERE id = '$id'";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();
	}

	public function findById(String $id)
	{
		$query = "SELECT U.*, R.code, R.description FROM $this->table U INNER JOIN rols R ON U.rolID = R.id WHERE U.id = '$id' AND R.active = 1";
		$connection = Connection::connect()->prepare($query);
		$connection->execute();

		$userData = $connection->fetch();

		if (!$userData) {
			return null;
		}

		$user = User::forUpdate($userData['id'], $userData['name'], $userData['username'], $userData['rolID'], $userData['password']);
		$user->setId($userData['id']);
		$user->setPhoto($userData['photo']);
		$user->setActive($userData['active']);
		$user->setLastLogin($userData['last_login']);

		$rol = new Rol($userData['description']);
		$rol->setCode($userData['code']);

		$user->setRol($rol);
		
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
		$connection = Connection::connect()->prepare("SELECT U.*, R.description FROM $this->table U INNER JOIN rols R ON U.rolID = R.id WHERE U.Deleted_at is null");
		$connection->execute();

		$users = [];

		foreach ($connection->fetchAll() as $user) {
			$userObj = User::forUpdate($user['id'], $user['name'], $user['username'], $user['rolID'] );
			$userObj->setPhoto($user['photo']);
			$userObj->setActive($user['active']);
			$userObj->setLastLogin($user['last_login']);

			$rolObj = new Rol($user['description']);

			$userObj->setRol($rolObj);
			
			array_push($users, $userObj);
		}

		return $users;
	}
}
