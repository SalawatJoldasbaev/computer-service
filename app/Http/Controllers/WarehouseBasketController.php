<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\Warehouse_order;
use App\Models\Warehouse_basket;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function setWarehouse(Request $request){
        $validation = Validator::make($request->all(),[
            'basket_id'=> 'required',
            'orders'=> 'required|array',
            'orders.*.order_id'=> 'required|integer',
            'orders.*.product_id'=> 'required|integer',
            'orders.*.count'=> 'required|integer',
            'orders.*.codes'=> 'required|array',
        ]);
        if($validation->fails()){
            return BaseController::error($validation->errors()->first(), 422);
        }
        $basket_id = $request->basket_id;
        $basket = Warehouse_basket::find($basket_id);
        if($basket->is_deliver == true){
            return BaseController::error('basket not found', 404);
        }
        $orders = collect($request->orders);
        $basket_orders = Warehouse_order::where('warehouse_basket_id', $basket_id)->get();
        foreach ($basket_orders as $order) {
            $get_order = $orders->where('order_id', $order->id)->where('product_id', $order->product_id)->first();
            if(isset($order->description)){
                $order->description = $get_order['description'];
            }
            $order->get_count = $get_order['count'];
            $order->codes = $get_order['codes'];
            $order->save();
            Warehouse::SetWarehouse($order->postman_id, $order->product_id, $get_order['count'], $get_order['codes']);
        }
        $basket->update([
            'is_deliver'=> true
        ]);
        return BaseController::success();
    }
}
