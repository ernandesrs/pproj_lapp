<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "The resource was not found.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 404;
}