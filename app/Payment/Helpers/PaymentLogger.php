<?php

namespace App\Payment\Helpers;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @method static void error(string $message, array $context = [])
 * @method static void info(string $message, array $context = [])
 * @method static void log($level, string $message, array $context = [])
 * @method void   error(string $message, array $context = [])
 * @method void   info(string $message, array $context = [])
 * @method void   log($level, string $message, array $context = [])
 *
 * @see \Illuminate\Log\Logger
 */
class PaymentLogger
{
    public $providerCode;

    public function __construct($providerCode)
    {
        $this->providerCode = $providerCode;
    }

    public function logInfo($message, $context = [])
    {
        Log::info($message, $this->parsePaymentContext($context));
    }

    public function logWarning($message, $context = [])
    {
        Log::warning($message, $this->parsePaymentContext($context));
    }

    public function logError($message, $context = [])
    {
        if ($context instanceof Exception) {
            $ignoreLog = data_get($context->getExtraData(), 'ignoreErrorLog', false);
            if ($ignoreLog) {
                return;
            }
        }
        Log::error($message, $this->parsePaymentContext($context));
    }

    public function logDebug($message, $context = [])
    {
        Log::debug($message, $this->parsePaymentContext($context));
    }

    public static function provider($providerCode)
    {
        return new static($providerCode);
    }

    public function log($level, $message, $context = [])
    {
        $callMethodName = 'log'.Str::title($level);

        $this->{$callMethodName}($message, $context);
    }

    private function parsePaymentContext($context)
    {
        if ($context instanceof \Illuminate\Http\Client\Response) {
            $context = [
                'status_code' => $context->status(),
                'body' => $context->json() ?? $context->xml() ?? $context->body() ?? '',
            ];
        } elseif ($context instanceof \Illuminate\Http\Client\Request) {
            $context = [
                'url' => $context->url(),
                'method' => $context->method(),
                'headers' => $context->headers(),
                'body' => $context->data(),
            ];
        } elseif ($context instanceof Exception) {
            $context = [
                'message' => $context->getMessage(),
                'line' => $context->getLine(),
                'line' => $context->getFile(),
                'trace' => $context->getTraceAsString(),
            ];
        }

        return array_merge(Arr::wrap($context), [
            'logging_type' => 'payment',
            'provider' => $this->providerCode,
        ]);
    }

    public function setProviderCode($providerCode)
    {
        $this->providerCode = $providerCode;

        return $this;
    }

    public function __call($method, $args)
    {
        return $this->log($method, $args[0], $args[1] ?? []);
    }

    public static function __callStatic($method, $args)
    {
        switch (count($args)) {
            case 2:
                return (new static($args[0]))->log($method, $args[1]);

            case 3:
                return (new static($args[0]))->log($method, $args[1], $args[2]);

            default:
                if (! isset($args[0])) {
                    throw new \Exception('Unknown payment provider code.');
                }

                return call_user_func_array([new static($args[0]), 'log'], array_merge([$method], $args));
        }
    }
}
