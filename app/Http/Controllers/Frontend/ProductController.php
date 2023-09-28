<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function showBySlug(Request $request, $slug)
    {
        return $this->view('frontend.pages.product.show');
    }
}
