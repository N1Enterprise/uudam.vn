<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Responses\Frontend\ListLinkedInventoryResponseContract;
use App\Contracts\Responses\Frontend\ListPostResponseContract;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends BaseApiController
{
    public $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function getByCategory(Request $request, $category)
    {
        $posts = $this->postService->searchForGuest(array_merge($request->all(), [
            'post_category_id' => get_model_key($category)
        ]));

        return $this->response(ListPostResponseContract::class, $posts);
    }

    public function getBySuggestion(Request $request)
    {
        $posts = $this->postService->searchForGuest(array_merge($request->all(), [
            'sort_by' => 'view_count'
        ]));

        return $this->response(ListPostResponseContract::class, $posts);
    }
}
