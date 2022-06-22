<?php

namespace App\Exceptions;

use Exception;

class NoAccountFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 404, ?Throwable $previous = null)
    {
        $message = "No account found with given credentials.";
        parent::__construct($message, $code, $previous);
    }
}
