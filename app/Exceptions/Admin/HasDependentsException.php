<?php

namespace App\Exceptions\Admin;

use App\Exceptions\TraitException;
use Exception;

class HasDependentsException extends Exception
{
    use TraitException;

    /**
     * Message
     *
     * @var string
     */
    protected $message = "There are other resources linked to this.";

    /**
     * Code
     *
     * @var integer
     */
    protected $code = 403;
}
