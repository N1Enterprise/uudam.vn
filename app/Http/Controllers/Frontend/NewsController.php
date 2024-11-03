<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\ModelNotFoundException;
use App\Models\PostCategory;
use App\Services\PostCategoryService;
use App\Services\PostService;
use Illuminate\Http\Request;

class NewsController extends BaseController
{
    public $postCategoryService;
    public $postService;

    public function __construct(PostCategoryService $postCategoryService, PostService $postService)
    {
        $this->postCategoryService = $postCategoryService;
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $postCategories = $this->postCategoryService->allAvailableForGuest();
        $postCategory = new PostCategory();

        return $this->view('frontend.pages.news.index', compact('postCategories', 'postCategory'));
    }

    public function showPostCategory(Request $request, $slug)
    {
        $postCategories = $this->postCategoryService->allAvailableForGuest();
        $postCategory = $this->postCategoryService->showBySlugForGuest($slug, $request->all());

        if (empty($postCategory)) throw new ModelNotFoundException();

        if ($postCategory->slug != $slug) {
            return redirect()->route('fe.web.news.show-post-categories', ['slug' => $postCategory->slug, 'id' => $postCategory->id]);
        }

        return $this->view('frontend.pages.news.post-category', compact(
            'postCategories',
            'postCategory',
        ));
    }
}
