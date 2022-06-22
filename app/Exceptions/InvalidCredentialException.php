<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialException extends Exception
{
    public function __construct(string $message = "", int $code = 400, ?Throwable $previous = null)
    {
        $message = "Incorrect credentials given.";
        parent::__construct($message, $code, $previous);
    }
}
