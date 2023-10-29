<?php

namespace App\Http\Controllers\Backoffice;

use App\Services\SubscriberService;

class SubscriberController extends BaseController
{
    public $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    public function index()
    {
        return view('backoffice.pages.subscribers.index');
    }
}
