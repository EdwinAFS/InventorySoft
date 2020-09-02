<?php
class User
{

	public function __construct($name, $username, $password)
	{
		$this->id = "";
		$this->name = $name;
		$this->username = $username;
		$this->setPassword($password);
		$this->active = true;
	}

	/* SET */

	public function setId( $id ) {
		$this->id = $id;
	}	
	public function setName( $name ) {
		$this->name = $name;
	}
	public function setUsername($username) {
		$this->username = $username;
	}	
	public function setPassword($password) {
		$this->password = crypt($password, '$2a$07$usesomesillystringforsalt$');
	}
	public function setPhoto($photo) {
		$this->photo = $photo;
	}
	public function setLastLogin( $lastLogin ) {
		$this->lastLogin = $lastLogin;
	}
	public function setActive( $active ) {
		$this->active = $active;
	}

	/* GET */

	public function getName() {
		return $this->name;
	}
	public function getId() {
		return $this->id;
	}
	public function getUsername() {
		return $this->username;
	}
	public function getPassword() {
		return $this->password;
	}
	public function getPhoto() {
		return $this->photo;
	}
	public function getLastLogin() {
		return $this->lastLogin;
	}
	public function getActive() {
		return $this->active;
	}

}
