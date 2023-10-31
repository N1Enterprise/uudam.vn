<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class ModelNotFoundException extends BaseException
{
    public function __construct($message = 'Invalid Entity', $code = 'invalid_entity', $status = Response::HTTP_NOT_FOUND)
    {
        parent::__construct($message, $code, $status);
    }
}
