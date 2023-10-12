<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedActionException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "Unauthorized.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 403;
}