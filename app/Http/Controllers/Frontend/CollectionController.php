<?php

namespace App\Http\Controllers\Frontend;

class CollectionController extends BaseController
{
    public function index()
    {
        return $this->view('frontend.pages.collections.index');
    }
}
