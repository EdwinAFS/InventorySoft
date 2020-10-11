<?php

namespace App\Domain\models;

class Customer
{
	private $customerId;	
	private $name;	
	private $identification;	
	private $email;	
	private $phone;	
	private $address;	
	private $birthdate;	
	private $created_at;	
	private $active;	
	private $deleted_at;


	public function __construct( $name, $identification, $email, $address, $birthdate )
	{
		$this->setName( $name );
		$this->setIdentification( $identification );
		$this->setEmail( $email );
		$this->setAddress( $address );
		$this->setBirthdate( $birthdate );
	}

	/* SET */
	public function setId($customerId)
	{
		$this->customerId = $customerId;
	}

	public function setName( $name ){
		$this->name = $name;
	}

	public function setIdentification( $identification ){
		$this->identification = $identification;
	}

	public function setEmail( $email ){
		$this->email = $email;
	}

	public function setPhone( $phone ){
		$this->phone = $phone;
	}

	public function setAddress( $address ){
		$this->address = $address;
	}

	public function setBirthdate( $birthdate ){
		$this->birthdate = $birthdate;
	}

	public function setCreated_at( $created_at ){
		$this->created_at = $created_at;
	}

	public function setActive( $active ){
		$this->active = $active;
	}

	public function setDeleted_at( $deleted_at ){
		$this->deleted_at = $deleted_at;
	}

	/* GET */
	public function getId(){
		return $this->customerId;
	}
	public function getName(){
		return $this->name;
	}
	public function getIdentification(){
		return $this->identification;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getPhone(){
		return $this->phone;
	}
	public function getAddress(){
		return $this->address;
	}
	public function getBirthdate(){
		return $this->birthdate;
	}
	public function getCreated_at(){
		return $this->created_at;
	}
	public function getActive(){
		return $this->active;
	}
	public function getDeleted_at(){
		return $this->deleted_at;
	}

	public function get(){
		return [
			"customerId" => $this->getId(),
			"name" => $this->getName(),
			"identification" => $this->getIdentification(),
			"email" => $this->getEmail(),
			"phone" => $this->getPhone(),
			"address" => $this->getAddress(),
			"birthdate" => $this->getBirthdate(),
			"created_at" => $this->getCreated_at(),
			"active" => $this->getActive(),
			"deleted_at" => $this->getDeleted_at()
		];
	}
}
