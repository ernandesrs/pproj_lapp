<?php

namespace App\Exceptions\Account;

use App\Exceptions\TraitException;
use Exception;

class EmailOrPasswordInvalidException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "Email or password is invalid.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 401;
}
