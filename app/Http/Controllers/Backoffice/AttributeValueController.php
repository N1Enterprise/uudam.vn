<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreAttributeValueRequestContract;
use App\Contracts\Requests\Backoffice\UpdateAttributeValueRequestContract;
use App\Contracts\Responses\Backoffice\DeleteAttributeValueResponseContract;
use App\Contracts\Responses\Backoffice\StoreAttributeValueResponseContract;
use App\Contracts\Responses\Backoffice\UpdateAttributeValueResponseContract;
use App\Services\AttributeService;
use App\Services\AttributeValueService;

class AttributeValueController extends BaseController
{
    public $attributeValueService;
    public $attributeService;

    public function __construct(AttributeValueService $attributeValueService, AttributeService $attributeService)
    {
        $this->attributeValueService = $attributeValueService;
        $this->attributeService = $attributeService;
    }

    public function index()
    {
        return view('backoffice.pages.attribute-values.index');
    }

    public function create()
    {
        $attributes = $this->attributeService->allAvailable();

        return view('backoffice.pages.attribute-values.create', compact('attributes'));
    }

    public function edit($id)
    {
        $attributeValue = $this->attributeValueService->show($id);
        $attributes = $this->attributeService->allAvailable();

        return view('backoffice.pages.attribute-values.edit', compact('attributeValue', 'attributes'));
    }

    public function store(StoreAttributeValueRequestContract $request)
    {
        $attributeValue = $this->attributeValueService->create($request->validated());

        return $this->response(StoreAttributeValueResponseContract::class, $attributeValue);
    }

    public function update(UpdateAttributeValueRequestContract $request, $id)
    {
        $attributeValue = $this->attributeValueService->update($request->validated(), $id);

        return $this->response(UpdateAttributeValueResponseContract::class, $attributeValue);
    }

    public function destroy($id)
    {
        $status = $this->attributeValueService->delete($id);

        return $this->response(DeleteAttributeValueResponseContract::class, ['status' => $status]);
    }
}
