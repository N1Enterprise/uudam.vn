<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\ModelNotFoundException;
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
        $post = $this->postService->findBySlugForGuest($slug, $request->all());

        if (empty($post)) throw new ModelNotFoundException();

        if ($post->slug != $slug) {
            return redirect()->route('fe.web.posts.index', ['slug' => $post->slug, 'id' => $post->id]);
        }

        return $this->view('frontend.pages.posts.index', compact('post'));
    }
}
