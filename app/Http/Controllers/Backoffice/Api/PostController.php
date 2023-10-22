<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListPostResponseContract;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends BaseApiController
{
    public $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $posts = $this->postService->searchByAdmin($request->all());

        return $this->response(ListPostResponseContract::class, $posts);
    }
}
