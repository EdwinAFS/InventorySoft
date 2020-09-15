<?php

namespace App\Domain\models;

class Rol
{
	private $id;
	private $code;
	private $description;
	private $active;

	public function __construct( $description )
	{
		$this->setDescription( $description );
	}

	/* SET */

	public function setId($id)
	{
		$this->id = $id;
	}
	public function setCode($code)
	{
		$this->code = $code;
	}
	public function setDescription($description)
	{
		$this->description = $description;
	}
	public function setActive($active)
	{
		$this->active = $active;
	}

	/* GET */

	public function getId()
	{
		return $this->id;
	}
	public function getCode()
	{
		return $this->code;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function getActive()
	{
		return $this->active;
	}

	public function get(){
		return [
			"id" => $this->getId(),
			"code" => $this->getCode(),
			"description" => $this->getDescription(),
			"active" => $this->getActive()
		];
	}

}
