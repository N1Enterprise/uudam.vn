<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Contracts\Responses\Backoffice\ListAttributeValueResponseContract;
use App\Services\AttributeValueService;
use Illuminate\Http\Request;

class AttributeValueController extends BaseApiController
{
    public $attributeValueService;

    public function __construct(AttributeValueService $attributeValueService)
    {
        $this->attributeValueService = $attributeValueService;
    }

    public function index(Request $request)
    {
        $attributeValues = $this->attributeValueService->searchByAdmin($request->all());

        return $this->response(ListAttributeValueResponseContract::class, $attributeValues);
    }
}
