<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

abstract class BaseResponse
{
    public const JSON_REDIRECT_CODE = 278;

    protected $resource;

    protected $status;

    protected $headers;

    protected $meta;

    public function __construct($resource, $status = 200, $headers = [], $meta = [])
    {
        $this->resource = $resource;
        $this->status = $status;
        $this->headers = $headers;
        $this->meta = $meta;
    }

    public function toResponse($request)
    {
        return new JsonResponse($this->resource, $this->status, $this->headers);
    }

    public function redirect(string $url, $data = null)
    {
        return new JsonResponse($data, self::JSON_REDIRECT_CODE, array_merge($this->headers, [
            'X-Redirect-Url' => $url,
        ]));
    }

    public function redirectBack($data = null)
    {
        return new JsonResponse($data, self::JSON_REDIRECT_CODE, array_merge($this->headers, [
            'X-Redirect-Url' => back()->getTargetUrl(),
        ]));
    }
}
