<?php

namespace App\Http\Controllers\Backoffice;

use App\Classes\AdminAuth;
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
     * @return \App\Models\Admin
     */
    public function user()
    {
        return AdminAuth::user();
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
}
