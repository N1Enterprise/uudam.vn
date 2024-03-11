<?php

namespace App\Http\Middleware;

use GuzzleHttp\Promise\Create;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClientMiddleware
{
    protected $options;
    protected $uuid;
    protected $prefix;
    protected $lengthLimit;

    public function __construct(array $options = [])
    {
        $this->options     = $options;
        $this->uuid        = data_get($options, 'tracking_uuid') ?? (string) Str::uuid();
        $this->prefix      = $this->getPrefix();
        $this->lengthLimit = data_get($this->options, 'length_limit', 1024);
    }

    /**
     * Called when the middleware is handled by the client.
     *
     * @param array $context
     */
    public function __invoke(callable $handler): callable
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            if ($this->logRequest()) {
                Log::info(
                    $this->prefix.' Send request to provider',
                    $this->parseRequestData($request)
                );
            }

            if ($this->logResponse()) {
                return $handler($request, $options)->then(
                    $this->handleSuccess($request, $options),
                    $this->handleFailure($request, $options)
                );
            }

            return $handler($request, $options);
        };
    }

    private function parseRequestData($request)
    {
        $data = [
            'headers' => $this->parseRequestHeaders($request->getHeaders()),
            'body'    => (string) $request->getBody()->read($this->lengthLimit),
            'url'     => (string) $request->getUri(),
            'method'  => $request->getMethod(),
        ];

        $ignoreFields = data_get($this->options, 'ignore_fields', []);
        $data         = Arr::except($data, $ignoreFields);

        return $data;
    }

    protected function parseRequestHeaders($headers)
    {
        $headerNames = collect($headers)->keys()->map(function ($headerName) {
            return strtolower($headerName);
        })->toArray();

        $headerValues = collect($headers)->map(function ($value) {
            return $value[0];
        })->toArray();

        $headers = array_combine($headerNames, $headerValues);

        return $this->hideParameters($headers,
            Arr::wrap(data_get($this->options, 'hidden_request_headers', [
                'authorization',
                'php-auth-pw',
            ]))
        );
    }

    /**
     * Hide the given parameters.
     *
     * @param  array  $data
     * @param  array  $hidden
     * @return mixed
     */
    protected function hideParameters($data, $hidden)
    {
        foreach ($hidden as $parameter) {
            if (Arr::get($data, $parameter)) {
                Arr::set($data, $parameter, '********');
            }
        }

        return $data;
    }

    private function parseResponseData($response)
    {
        return [
            'body' => $response->getBody()->read($this->lengthLimit),
            'method' => $response->getStatusCode(),
        ];
    }

    /**
     * Returns a function which is handled when a request was successful.
     */
    private function handleSuccess(RequestInterface $request, array $options): callable
    {
        return function (ResponseInterface $response) {
            if ($this->logResponse()) {
                if ($response->getStatusCode() >= 400) {
                    Log::error(
                        $this->prefix.' Receive error (status) response from provider',
                        $this->parseResponseData($response)
                    );
                } else {
                    Log::info(
                        $this->prefix.' Receive response from provider',
                        $this->parseResponseData($response)
                    );
                }
            }

            return $response;
        };
    }

    /**
     * Returns a function which is handled when a request was rejected.
     */
    private function handleFailure(RequestInterface $request, array $options): callable
    {
        return function ($reason) {
            if ($this->logException()) {
                Log::error(
                    $this->prefix.' Receive error response from provider',
                    [$reason->getTraceAsString()]
                );
            }

            return Create::rejectionFor($reason);
        };
    }

    private function getPrefix()
    {
        return data_get($this->options, 'prefix', 'unknown').'-'.$this->uuid;
    }

    private function logRequest(): bool
    {
        return isset($this->options['log_request']) ? (bool) $this->options['log_request'] : true;
    }

    private function logResponse(): bool
    {
        return isset($this->options['log_response']) ? (bool) $this->options['log_response'] : true;
    }

    private function logException(): bool
    {
        return isset($this->options['log_exception']) ? (bool) $this->options['log_exception'] : false;
    }
}
