<?php

namespace App\Http\Controllers\Frontend;

use App\Services\InventoryService;
use Illuminate\Http\Request;

class UserSearchController extends BaseController
{
    public $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;    
    }
    
    public function index(Request $request)
    {
        $query = $request->get('q');

        return $this->view('frontend.pages.search.index', compact('query'));
    }
}
