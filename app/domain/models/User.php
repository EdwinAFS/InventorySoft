<?php

namespace App\Domain\models;

class User
{
	private $id;
	private $name;
	private $username;
	private $password;
	private $photo;
	private $rolID;
	private $lastLogin;
	private $active;

	private function __construct()
	{
	}

	public static function forUpdate($id, $name, $username, $rolID, $password = null)
	{
		$user = new self;
		$user->setId($id);
		$user->setName($name);
		$user->setUsername($username);
		$user->setRolID($rolID);
		$user->password = $password;
		return $user;
	}

	public static function forCreate($name, $username, $rolID, $password)
	{
		$user = new self;
		$user->setName($name);
		$user->setUsername($username);
		$user->setRolID($rolID);
		$user->setPassword($password);
		$user->setActive(true);

		return $user;
	}

	/* SET */

	public function setId($id)
	{
		$this->id = $id;
	}
	public function setName($name)
	{
		$this->name = $name;
	}
	public function setUsername($username)
	{
		$this->username = $username;
	}
	public function setPassword($password)
	{
		$this->password = crypt($password, '$2a$07$usesomesillystringforsalt$');
	}
	public function setRolID($rolID)
	{
		$this->rolID = $rolID;
	}
	public function setPhoto($photo)
	{
		$this->photo = $photo;
	}
	public function setLastLogin($lastLogin)
	{
		$this->lastLogin = $lastLogin;
	}
	public function setActive($active)
	{
		$this->active = $active;
	}

	/* GET */

	public function getName()
	{
		return $this->name;
	}
	public function getId()
	{
		return $this->id;
	}
	public function getUsername()
	{
		return $this->username;
	}
	public function getPassword()
	{
		return $this->password;
	}
	public function getRolID()
	{
		return $this->rolID;
	}
	public function getPhoto(): ? string 
	{
		return $this->photo;
	}
	public function getLastLogin(): ? string
	{
		return $this->lastLogin;
	}
	public function getActive()
	{
		return $this->active;
	}

	public function get(){
		return [
			"name" => $this->getName(),
			"id" => $this->getId(),
			"username" => $this->getUsername(),
			"rolID" => $this->getRolID(),
			"photo" => $this->getPhoto(),
			"lastLogin" => $this->getLastLogin(),
			"active" => $this->getActive()
		];
	}

	public function comparePassword( $verifyPassword ):bool {
		$password = crypt($verifyPassword, '$2a$07$usesomesillystringforsalt$');
		return $password === $this->password;
	}

}
