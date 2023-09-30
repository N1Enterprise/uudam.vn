<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index(Request $request, $slug)
    {
        return $this->view('frontend.pages.products.index');
    }
}
