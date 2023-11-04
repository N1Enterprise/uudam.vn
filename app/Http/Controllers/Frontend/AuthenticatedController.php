<?php

namespace App\Http\Controllers\Frontend;

class AuthenticatedController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /** @return \App\Models\User|null */
    public function user()
    {
        return $this->userAuth->user();
    }
}
