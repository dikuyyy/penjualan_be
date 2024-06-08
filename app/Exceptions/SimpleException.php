<?php

namespace App\Exceptions;

class SimpleException extends BaseException
{
    public function __construct($message = '', $status = 400)
    {
        parent::__construct($message, $status);
    }
}
