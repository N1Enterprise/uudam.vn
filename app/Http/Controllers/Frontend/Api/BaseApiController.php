<?php

namespace App\Http\Controllers\Frontend\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use App\Classes\AdminAuth;
use App\Classes\Contracts\UserAuthContract;

class BaseApiController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /** @var UserAuthContract */
    public $userAuth;

    public function __construct()
    {
        $this->userAuth = app(UserAuthContract::class);
    }

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
