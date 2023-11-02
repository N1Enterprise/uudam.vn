<?php

namespace App\Http\Controllers\Frontend\Api;

use Illuminate\Http\Request;

class UserSearchController extends BaseApiController
{
    public function suggest(Request $request)
    {
        $data = $request->all();

        dd($data);
    }
}
