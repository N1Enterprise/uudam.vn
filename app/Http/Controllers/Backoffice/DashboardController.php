<?php

namespace App\Http\Controllers\Backoffice;

class DashboardController extends BaseController
{
    public function index()
    {
        return $this->view('backoffice.pages.dashboard.index');
    }
}
