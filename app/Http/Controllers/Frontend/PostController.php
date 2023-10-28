<?php

namespace App\Http\Controllers\Frontend;

use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request, $slug)
    {
        $post = $this->postService->findBySlug($slug);

        return $this->view('frontend.pages.posts.index', compact('post'));
    }
}
