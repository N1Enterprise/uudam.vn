<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\ModelNotFoundException;
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
        $page = $this->pageService->findBySlugForGuest($slug, $request->all());

        if (empty($page)) throw new ModelNotFoundException();

        if ($page->slug != $slug) {
            return redirect()->route('fe.web.pages.index', ['slug' => $page->slug, 'id' => $page->id]);
        }

        return $this->view('frontend.pages.pages.index', compact('page'));
    }
}
