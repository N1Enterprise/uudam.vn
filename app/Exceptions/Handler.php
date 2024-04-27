<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($this->isHttpException($e)) {
            $statusCode = $e->getStatusCode();

            switch ($statusCode) {
                case Response::HTTP_FORBIDDEN:
                    return redirect()->route('fe.web.home', ['Response_Code' => 'Forbidden']);
                case Response::HTTP_NOT_FOUND:
                    return redirect()->route('fe.web.home', ['Response_Code' => 'Page_Not_Found']);
                    break;
                case Response::HTTP_INTERNAL_SERVER_ERROR:
                    return redirect()->route('fe.web.home', ['Response_Code' => 'Internal_Server_Error']);
                    break;

                default:
                    return $this->renderHttpException($e);
                    break;
            }
        } else {
            return parent::render($request, $e);
        }
    }
}
