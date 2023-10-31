<?php

namespace App\Exceptions;

use App\Common\RequestHelper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class BaseException extends Exception
{
    public $message;

    public $code;

    public $statusCode;

    public $extraData;

    protected $errorKeyName = 'error';

    public function __construct($message = null, $code = null, $statusCode = 500, $extraData = [])
    {
        $this->message = $message;
        $this->code = $code;
        $this->statusCode = $statusCode;
        $this->extraData = $extraData;
    }

    public function render($request)
    {
        if ($request->expectsJson()) {
            return $this->prepareJsonResponse($request);
        }

        return $this->handleCoreException($request);
    }

    protected function handleCoreException($request)
    {
        if ($this instanceof BusinessLogicException) {
            throw ValidationException::withMessages([$this->code => $this->message])->status($this->statusCode);
        }

        if (app()->environment('production') || ! config('app.debug')) {
            if (RequestHelper::isFrontEndRequest(request())) {
                return View::exists(config('view.views.errors.frontend_404'))
                    ? view(config('view.views.errors.frontend_404'))
                    : abort(404);
            } else if (RequestHelper::isBackOfficeRequest(request())) {
                return View::exists(config('view.views.errors.backoffice_404'))
                    ? view(config('view.views.errors.backoffice_404'))
                    : abort(404);
            }
        }
    }

    public function prepareJsonResponse($request)
    {
        return new JsonResponse(
            $this->convertToArray(),
            $this->statusCode
        );
    }

    private function convertToArray()
    {
        return [
            'message' => __($this->message),
            $this->errorKeyName => $this->code,
            'error_message_variables' => $this->getExtraData() ?? [],
        ];
    }

    public function getExceptionCode()
    {
        return $this->code;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setErrorKeyName($key)
    {
        $this->errorKeyName = $key;

        return $this;
    }

    public function getExtraData()
    {
        return $this->extraData;
    }

    public function addExtraData($data = [])
    {
        $this->extraData = array_merge($this->extraData, $data);

        return $this;
    }
}
