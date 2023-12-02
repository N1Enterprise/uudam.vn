<?php

namespace App\Http\Controllers\Frontend;

use App\Services\PageService;
use Illuminate\Http\Request;

class PageController extends BaseController
{
    public $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index(Request $request, $slug)
    {
        $page = $this->pageService->findBySlugByUser($slug, ['columns' => ['name', 'title', 'slug', 'content', 'meta_title', 'meta_description', 'updated_at']]);

        return $this->view('frontend.pages.pages.index', compact('page'));
    }
}
