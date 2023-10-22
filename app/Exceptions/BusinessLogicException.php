<?php

namespace App\Exceptions;

class BusinessLogicException extends BaseException
{
    // default is not report this exception
    protected $report = null;

    public function __construct($message = 'Unavailable request.', $code = 'unavailable_request', $status = 400)
    {
        parent::__construct($message, $code, $status);
    }

    public function report()
    {
        return $this->report;
    }

    public function shouldReport($bool = true)
    {
        $this->report = ! $bool;

        return $this;
    }
}
