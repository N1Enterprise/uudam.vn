<?php

namespace App\Http\Controllers\Frontend;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->view('frontend.pages.home.index');
    }
}
