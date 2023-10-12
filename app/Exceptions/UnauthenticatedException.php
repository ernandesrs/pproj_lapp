<?php

namespace App\Exceptions;

use Exception;

class UnauthenticatedException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "Unauthenticated.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 401;
}