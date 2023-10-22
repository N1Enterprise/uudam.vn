<?php

namespace App\Http\Controllers\Backoffice;

use App\Contracts\Requests\Backoffice\StoreAttributeRequestContract;
use App\Contracts\Requests\Backoffice\UpdateAttributeRequestContract;
use App\Contracts\Responses\Backoffice\StoreAttributeResponseContract;
use App\Contracts\Responses\Backoffice\UpdateAttributeResponseContract;
use App\Enum\ProductAttributeTypeEnum;
use App\Services\AttributeService;
use App\Services\CategoryGroupService;

class AttributeController extends BaseController
{
    public $attributeService;
    public $categoryGroupService;

    public function __construct(AttributeService $attributeService, CategoryGroupService $categoryGroupService)
    {
        $this->attributeService = $attributeService;
        $this->categoryGroupService = $categoryGroupService;
    }

    public function index()
    {
        return view('backoffice.pages.attributes.index');
    }

    public function create()
    {
        $categoryGroups = $this->categoryGroupService->allAvailable(['with' => 'categories']);
        $productAttributeTypeEnum = ProductAttributeTypeEnum::labels();

        return view('backoffice.pages.attributes.create', compact('categoryGroups', 'productAttributeTypeEnum'));
    }

    public function edit($id)
    {
        $attribute = $this->attributeService->show($id, ['with' => 'categories']);
        $categoryGroups = $this->categoryGroupService->allAvailable(['with' => 'categories']);
        $productAttributeTypeEnum = ProductAttributeTypeEnum::labels();

        return view('backoffice.pages.attributes.edit', compact('attribute', 'categoryGroups', 'productAttributeTypeEnum'));
    }

    public function store(StoreAttributeRequestContract $request)
    {
        $attribute = $this->attributeService->create($request->validated());

        return $this->response(StoreAttributeResponseContract::class, $attribute);
    }

    public function update(UpdateAttributeRequestContract $request, $id)
    {
        $attribute = $this->attributeService->update($request->validated(), $id);

        return $this->response(UpdateAttributeResponseContract::class, $attribute);
    }
}
