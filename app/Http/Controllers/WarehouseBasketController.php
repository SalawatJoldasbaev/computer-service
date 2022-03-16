<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse_order;
use App\Models\Warehouse_basket;

class WarehouseBasketController extends Controller
{
    public function all_basket(Request $request){
        $baskets = Warehouse_basket::where('is_deliver',false)->get();
        $data = [];
        foreach($baskets as $basket){ 
            $data[] = [
                'basket_id'=>$basket->id,
                'admin'=>[
                    'id'=> $basket->admin->id,
                    'name'=> $basket->admin->name
                ],
                'postman'=>[
                    'id'=> $basket->postman->id,
                    'full_name'=> $basket->postman->full_name
                ],
                'price_uzs'=>$basket->uzs_price,
                'price_usd'=>$basket->usd_price,
                'description'=>$basket->description,
            ];
        }
        return BaseController::response($data);
    }
}
