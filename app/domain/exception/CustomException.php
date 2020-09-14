<?php 

namespace App\Domain\exception;

use Exception;

class CustomException extends Exception
{
	private $httpCode;
	private $codeException;

	public function __construct( string $message, string $codeException, $httpCode = 500)
    {
		parent::__construct( $message );
		$this->httpCode = $httpCode;
		$this->code = $codeException;
	}

	public function getHttpCode(){
		return $this->httpCode;
	}

	public function getCodeException(): string{
		return $this->codeException;
	}
	
}
