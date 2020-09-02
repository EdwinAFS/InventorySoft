<?php

require_once "../app/domain/models/Autentication.php";
require_once "../app/domain/repositories/AutenticationRepository.php";

class LoginService
{

	public function __construct(AutenticationRepository $autenticationRepository)
	{
		$this->autenticationRepository = $autenticationRepository;
	}

	public function run($username, $password)
	{
		$autentication = new Autentication($username, $password);

		return $this->autenticationRepository->verify( $autentication );
	}
}
