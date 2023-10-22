<?php

namespace App\Http\Controllers\Frontend;

class BlogController extends BaseController
{
    public function index()
    {
        return $this->view('frontend.pages.blogs.index');
    }
}
