<?php

namespace App\Http\Controllers\Frontend;

class BlogNewsController extends BaseController
{
    public function index()
    {
        return $this->view('frontend.pages.blog-news.index');
    }
}
