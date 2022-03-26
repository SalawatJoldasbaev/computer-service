<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\ProductCode;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Warehouse_order;
use App\Models\Warehouse_basket;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class WarehouseOrderController extends Controller
{
    public function create(Request $request){
        $admin = $request->user();
        $validation = Validator::make($request->all(), [
            'postman_id'=>'required|exists:App\Models\Postman,id',
            'orders'=>'required'
        ]);
        if($validation->fails()){
            return BaseController::error($validation->errors()->first(),422);
        }

        $orders = $request->orders;
        $price_uzs=0;
        $price_usd=0;
        foreach($orders as $order){
            if($order['unit'] == "UZS"){
                $price_uzs += $order['price']*$order['count'];
            }else{
                $price_usd += $order['price']*$order['count'];
            }
        }

        $basket = Warehouse_basket::create([
            'admin_id'=>$admin->id,
            'postman_id'=>$request->postman_id,
            'uzs_price'=>$price_uzs,
            'usd_price'=>$price_usd,
            'description'=>$request->description,
            'ordered_at'=> Carbon::now()
        ]);

        foreach($orders as $order){
            $warehouse_orers = [
                'warehouse_basket_id'=>$basket->id,
                'product_id'=>$order['product_id'],
                'postman_id'=>$request->postman_id,
                'count'=>$order['count'],
                'unit'=>$order['unit'],
                'price'=>$order['price'],
                'description'=>$order['description']
            ];
            Warehouse_order::create($warehouse_orers);
        }

        return BaseController::response($basket->toArray());
    }

    public function delete($order_id){
        $order = Warehouse_order::where('id', $order_id)->first();
        $basket_id = $order->warehouse_basket_id;
        $order->delete();
        $basket = collect(Warehouse_order::where('warehouse_basket_id', $basket_id)->get());
        $price_uzs = $basket->where('unit', 'UZS')->sum('price');
        $price_usd = $basket->where('unit', 'USD')->sum('price');

        Warehouse_basket::find($basket_id)
        ->update([
            'price_uzs'=>$price_uzs,
            'price_usd'=>$price_usd
        ]);

        return BaseController::success();
    }

    public function basket_orders(Request $request){
        $search = $request->search;
        $basket_id = $request->basket_id;

        $basket = Warehouse_basket::find($basket_id);
        $orders = $basket->orders;
        $final_response = [
            'basket_id'=> $basket->id,
            'description'=> $basket->description,
            'orders'=> [],
        ];
        foreach ($orders as $order) {
            $final_response['orders'][] = [
                'order_id'=> $order->id,
                'product_id'=> $order->product->id,
                'product_name'=> $order->product->name,
                'description'=> $order->description,
                'count'=> $order->count,
                'code'=> $order->code,
                'qr_link'=> env('APP_URL').'/api/code/?code='.$order->code
            ];
        }
        if($search){
            $collect = collect($final_response['orders']);
            $searched = $collect->filter(function($item) use ($search){
                return stripos($item['product_name'], $search) !== false;
            });
            $final_response['orders'] = $searched->values();
        }
        return BaseController::response($final_response);
    }

}
