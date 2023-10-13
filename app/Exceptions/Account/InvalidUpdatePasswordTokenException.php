<?php

namespace App\Exceptions\Account;

use App\Exceptions\TraitException;
use Exception;

class InvalidUpdatePasswordTokenException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "The password update token is invalid.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 422;
}