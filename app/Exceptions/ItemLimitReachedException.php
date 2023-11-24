<?php

namespace App\Exceptions;

use Exception;

class ItemLimitReachedException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "There is an item limit for this resource and it has been reached.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 422;
}
