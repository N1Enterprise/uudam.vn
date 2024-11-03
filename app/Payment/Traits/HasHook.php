<?php

namespace App\Payment\Traits;

use Illuminate\Http\Request;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method mixed executeWebhookMethod($method, $request)
 *
 * @property array webhookEndpointMappers
 *
 * @see \Modules\Payment\Integration\BasePaymentIntegrationV2
 */
trait HasHook
{
    /**
     * Routing payment integration webhook
     *
     * @param ?string $endpoint
     * @param Request $data
     */
    public function hook($endpoint, $request)
    {
        try {
            $triggerBeforeExecuteHook = true;

            $method = data_get($this->webhookEndpointMappers, $endpoint);

            if (! $method) {
                throw new NotFoundHttpException("$endpoint was not defined in hook.");
            }

            $authorized = $this->authorizeHook($request, $endpoint);

            if (! $authorized) {
                throw new BusinessLogicException('Unauthorized', ExceptionCode::UNAUTHORIZED, Response::HTTP_UNAUTHORIZED);
            }

            $triggerBeforeExecuteHook = false;

            return $this->executeWebhookMethod($method, $request);
        } catch (\Exception $ex) {
            return $this->failedHook($ex, $method, $request, $triggerBeforeExecuteHook ?? false);
        }
    }

    public function failedHook($exception, $method, $request, $triggerBeforeExecuteHook = false)
    {
        if ($triggerBeforeExecuteHook){
            $this->beforeExecuteHook($method, $request);
        }

        $throwable = null;

        $hookResponse = [];

        try {
            $response = $this->parseErrorResponse($exception);

            $hookResponse = $response;
        } catch (\Throwable $th) {
            $throwable = $th;

            $hookResponse = response()->json([
                'exception_message' => $th->getMessage(),
                'exception_code' => $th->getCode(),
            ], 500);
        }

        $this->afterExecuteHook($method, $hookResponse, $request);

        if($throwable) {
            throw $th;
        }

        return $response;
    }

    public function parseErrorResponse($exception)
    {
        throw $exception;
    }

    /**
     * Payment integrator must be overwrite this function to authorize the callback from provider
     *
     * @param mixed $request
     * @param mixed $endpoint
     * @return bool
     */
    public function authorizeHook($request, $endpoint = null): bool
    {
        return false;
    }
}
