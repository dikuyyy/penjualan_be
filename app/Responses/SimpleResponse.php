<?php

namespace App\Responses;

class SimpleResponse extends BaseResponse
{
    public function __construct($data = [], $message = '', $useTotal = false)
    {
        parent::__construct($data, $message, 200, $useTotal);
    }
}
