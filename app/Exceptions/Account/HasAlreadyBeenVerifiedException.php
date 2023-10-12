<?php

namespace App\Exceptions\Account;

use App\Exceptions\TraitException;
use Exception;

class HasAlreadyBeenVerifiedException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "This account has already been verified.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 403;
}