<?php

namespace App\Domain\models;

class Autentication
{
	private $id;
	private $name;

	public function __construct( $username, $password)
	{
		$this->username = $username;
		$this->setPassword($password);
	}

	/* SET */

	public function setId($id) {
		$this->id = $id;
	}	
	public function setUsername($username) {
		$this->username = $username;
	}	
	public function setName($name) {
		$this->name = $name;
	}	
	public function setPassword($password) {
		$this->password = crypt($password, '$2a$07$usesomesillystringforsalt$');
	}

	/* GET */

	public function getId() {
		return $this->id;
	}
	public function getUsername() {
		return $this->username;
	}
	public function getName() {
		return $this->name;
	}	
	public function getPassword() {
		return $this->password;
	}
	
}
