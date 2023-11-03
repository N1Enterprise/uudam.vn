<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Services\StoreFront\UserSearchService;
use Illuminate\Http\Request;

class UserSearchController extends BaseApiController
{
    public $userSearchService;

    public function __construct(UserSearchService $userSearchService)
    {
        $this->userSearchService = $userSearchService;
    }

    public function suggest(Request $request)
    {
        $result = $this->userSearchService->suggest($request->all());

        return response()->json($result);
    }
}
