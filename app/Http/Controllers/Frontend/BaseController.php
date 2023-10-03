<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\Contracts\UserAuthContract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @var UserAuthContract
     */
    public $userAuth;

    public function __construct()
    {
        $this->userAuth = app(UserAuthContract::class);
    }

    public function view($view, $data = [], $mergeData = [])
    {
        $viewPath = $view;

        return view($viewPath, $data, $mergeData);
    }

    public function response($responseClass, $resource = null)
    {
        return app($responseClass, ['resource' => $resource]);
    }

    public function responseNoContent($status = 204, array $headers = [])
    {
        return response()->noContent($status, $headers);
    }
}
