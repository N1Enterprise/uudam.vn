<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\ModelNotFoundException;
use App\Services\PostCategoryService;
use Illuminate\Http\Request;

class BlogController extends BaseController
{
    public $postCategoryService;

    public function __construct(PostCategoryService $postCategoryService)
    {
        $this->postCategoryService = $postCategoryService;
    }

    public function index(Request $request)
    {
        $blog = $this->postCategoryService->findByUser($request->slug);

        if (empty($blog)) {
            throw new ModelNotFoundException();
        }

        return $this->view('frontend.pages.blogs.index', compact('blog'));
    }
}
