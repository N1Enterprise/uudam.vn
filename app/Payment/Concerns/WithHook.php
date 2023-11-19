<?php

namespace App\Payment\Concerns;

use Illuminate\Http\Request;

interface WithHook
{
    /**
     * Routing payment integration webhook
     *
     * @param ?string $endpoint
     * @param Request $data
     */
    public function hook($endpoint, $request);


    /**
     * Authorize the payment callback (hook) from provider
     *
     * @param mixed $request
     * @param mixed $endpoint
     * @return bool
     */
    public function authorizeHook($request, $endpoint = null): bool;
}
