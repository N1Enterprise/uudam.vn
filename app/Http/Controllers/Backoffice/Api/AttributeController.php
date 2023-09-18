<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListAttributeResponseContract;
use App\Services\AttributeService;
use Illuminate\Http\Request;

class AttributeController extends BaseApiController
{
    public $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function index(Request $request)
    {
        $categories = $this->attributeService->searchByAdmin($request->all());

        return $this->response(ListAttributeResponseContract::class, $categories);
    }
}
