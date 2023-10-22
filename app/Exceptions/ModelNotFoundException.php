<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class ModelNotFoundException extends Exception
{
    public function __construct($message = 'Invalid Entity', $code = 'invalid_entity', $status = Response::HTTP_NOT_FOUND)
    {
        parent::__construct($message, $code, $status);
    }
}
