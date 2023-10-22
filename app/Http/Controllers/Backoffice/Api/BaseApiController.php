<?php

namespace App\Http\Controllers\Backoffice\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use App\Classes\AdminAuth;

class BaseApiController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @return \App\Models\Admin
     */
    public function user()
    {
        return AdminAuth::user();
    }

    public function response($responseClass, $resource = null, $status = 200, array $headers = [], $meta = [])
    {
        $response = app($responseClass, compact('resource', 'status', 'headers', 'meta'));

        return $response instanceof JsonResource ? response($response, $status, $headers, $meta) : $response;
    }

    public function responseNoContent($status = 204, array $headers = [])
    {
        return response()->noContent($status, $headers);
    }
}
