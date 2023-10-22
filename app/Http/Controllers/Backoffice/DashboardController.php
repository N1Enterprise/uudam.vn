<?php

namespace App\Http\Controllers\Backoffice;

class DashboardController extends BaseController
{
    public function home()
    {
        return $this->view('backoffice.pages.dashboard.index');
    }
}
