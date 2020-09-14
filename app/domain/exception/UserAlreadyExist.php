<?php

namespace App\Domain\exception;

use RuntimeException;

final class UserAlreadyExist  extends RuntimeException
{
    public function __construct(String $username)
    {
        parent::__construct(sprintf('El usuario <%s> ya existe', $username));
    }
}