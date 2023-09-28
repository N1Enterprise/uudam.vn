<?php

namespace App\Http\Controllers\Frontend;

class CartController extends BaseController
{
    public function __construct()
    {

    }

    public function index()
    {
        return $this->view('frontend.pages.cart.index');
    }
}
