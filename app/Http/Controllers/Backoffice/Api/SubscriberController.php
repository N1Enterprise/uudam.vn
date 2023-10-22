<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListSubscriberResponseContract;
use App\Services\SubscriberService;
use Illuminate\Http\Request;

class SubscriberController extends BaseApiController
{
    public $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    public function index(Request $request)
    {
        $productReviews = $this->subscriberService->searchByAdmin($request->all());

        return $this->response(ListSubscriberResponseContract::class, $productReviews);
    }
}
