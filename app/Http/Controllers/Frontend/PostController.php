<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\ModelNotFoundException;
use App\Services\PostCategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public $postService;
    public $postCategoryService;

    public function __construct(PostService $postService, PostCategoryService $postCategoryService)
    {
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
    }

    public function index(Request $request, $slug)
    {
        $post = $this->postService->findBySlugForGuest($slug, $request->all());

        if (empty($post)) throw new ModelNotFoundException();

        if ($post->slug != $slug) {
            return redirect()->route('fe.web.posts.index', ['slug' => $post->slug, 'code' => $post->code]);
        }

        $postCategory = $this->postCategoryService->show($post->post_category_id);

        $relatedPosts = collect($postCategory->posts)
            ->filter(fn($item) => data_get($item, 'slug') != $post->slug)
            ->toArray();

        return $this->view('frontend.pages.posts.index', compact('post', 'postCategory', 'relatedPosts'));
    }
}
