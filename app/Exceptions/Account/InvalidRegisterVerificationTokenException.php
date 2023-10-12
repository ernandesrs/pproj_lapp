<?php

namespace App\Exceptions\Account;

use App\Exceptions\TraitException;
use Exception;

class InvalidRegisterVerificationTokenException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "The registration verification token entered is invalid.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 422;
}