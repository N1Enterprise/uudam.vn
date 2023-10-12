<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Services\StoreFront\StoreFrontProductService;

class ProductController extends BaseController
{
    public $storeFrontProductService;

    public function __construct(StoreFrontProductService $storeFrontProductService)
    {
        $this->storeFrontProductService = $storeFrontProductService;
    }

    public function index(Request $request, $slug)
    {
        $inventory = $this->storeFrontProductService->findInventoryBySlug($slug);

        dd(
            $inventory
        );

        return $this->view('frontend.pages.products.index');
    }
}
