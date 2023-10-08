<?php

namespace App\Exceptions;

use Exception;

class InvalidDataException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "One or more data entered is invalid.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 422;
}