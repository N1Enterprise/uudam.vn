<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Contracts\Requests\Frontend\StoreUserSubscribeRequestContract;
use App\Enum\SubscriberTypeEnum;
use App\Services\SubscriberService;

class UserSubscribeController extends BaseApiController
{
    public $subscriberService;

    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }

    public function subscribeNewsLetter(StoreUserSubscribeRequestContract $request)
    {
        $result = $this->subscriberService->subscribe(array_merge($request->validated(), [
            'type' => SubscriberTypeEnum::NEWSLETTER
        ]));

        return response()->json($result->only(['email', 'created_at']));
    }
}
