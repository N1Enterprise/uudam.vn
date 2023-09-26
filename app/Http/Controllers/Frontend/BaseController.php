<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function view($view, $data = [], $mergeData = [])
    {
        $viewPath = $view;

        return view($viewPath, $data, $mergeData);
    }

    public function response($responseClass, $resource = null)
    {
        return app($responseClass, ['resource' => $resource]);
    }
}
