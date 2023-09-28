<?php

namespace App\Http\Controllers\Frontend;

class CheckoutController extends BaseController
{
    public function index()
    {
        return $this->view('frontend.pages.checkout.index');
    }
}
