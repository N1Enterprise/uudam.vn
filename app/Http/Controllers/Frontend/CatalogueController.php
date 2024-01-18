<?php

namespace App\Http\Controllers\Frontend;

use App\Exceptions\ModelNotFoundException;
use App\Services\PostCategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CatalogueController extends BaseController
{
    public $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $catalogs = $this->productService->getCatalogueBasedOnProducts();

        dd($catalogs->toArray());
    }
}
