<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function all(){
        $products = Warehouse::all();
        return BaseController::response($products->toArray());
    }

    public function warhouse(){
        $warehouse = Warehouse::find(1);
    }
}
