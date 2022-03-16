<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Warehouse_order;
use App\Models\Warehouse_basket;
use App\Http\Controllers\BaseController;
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
            'description'=>$request->description
        ]);

        foreach($orders as $order){
            Warehouse_order::create([
                'warehouse_basket_id'=>$basket->id,
                'product_id'=>$order['product_id'],
                'postman_id'=>$request->postman_id,
                'count'=>$order['count'],
                'unit'=>$order['unit'],
                'price'=>$order['price'],
                'description'=>$order['description']
            ]);
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

    public function deliver(Request $request){
        $admin = $request->user();
        $orders = $request->orders;
        foreach($orders as $order){
            $old_count = Warehouse::where('product_id', $order['product_id'])
            ->orderBy('id', 'desc')
            ->first();

            if($old_count == null){
                Warehouse::Create([
                    'product_id' => $order['product_id'],
                    'count' => $order['product_count'],
                    'date'=> date('Y-m-d')
                ]);
            }else{
                if($old_count->date == date('Y-m-d')){
                    $old_count->update([
                        'product_id'=> $order['product_id'],
                        'count'=> $old_count->count+$order['product_count'],
                        'date'=> date('Y-m-d')
                    ]);
                }else{
                    Warehouse::Create([
                        'product_id' => $order['product_id'],
                        'count' => $old_count->count+$order['product_count'],
                        'date'=> date('Y-m-d')
                    ]);
                }
            }
            Warehouse_order::where('id', $order['order_id'])
            ->update([
                'get_count'=>$order['product_count']
            ]);
        }

        Transaction::create([
            'warehouse_basket_id' => $request->basket_id,
            'admin_id' => $admin->role_id,
            'description' => $request->description
        ]);
        Warehouse_basket::find($request->basket_id)
        ->update([
            'is_deliver'=>true
        ]);

        return BaseController::success();
    }

    public function basket_orders(Request $request, $basket_id){
        $search = $request->search;

        $orders = Warehouse_order::select('warehouse_orders.id as order_id', 'products.id as product_id', 'products.name as product_name', 'warehouse_orders.count as product_count', 'warehouse_orders.unit as order_unit', 'warehouse_orders.price as order_price', 'warehouse_orders.description as order_description')
            ->where('warehouse_basket_id', $basket_id)
            ->join('products', 'products.id', 'warehouse_orders.product_id');

        if($search){
            $orders = $orders->where('products.name', 'like', "%{$search}%");
        }
        $orders = $orders->get();

        return BaseController::response($orders);
    }

}
