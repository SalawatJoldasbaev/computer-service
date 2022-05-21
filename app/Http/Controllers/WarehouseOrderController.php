<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\WarehouseAddOrder;
use App\Http\Requests\WarehouseOrderUpdate;
use App\Models\ProductCode;
use App\Models\Warehouse_basket;
use App\Models\Warehouse_order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseOrderController extends Controller
{
    public function create(Request $request)
    {
        $admin = $request->user();
        $validation = Validator::make($request->all(), [
            'postman_id' => 'required|exists:App\Models\Postman,id',
            'uzs' => 'required',
            'usd' => 'required',
            'description' => 'nullable',
            'orders' => 'required|array',
            'orders.*.product_id' => 'required|exists:products,id',
            'orders.*.count' => 'required',
            'orders.*.unit' => 'required',
            'orders.*.price' => 'required',
            'orders.*.description' => 'nullable',
        ]);
        if ($validation->fails()) {
            return BaseController::error($validation->errors()->first(), 422);
        }

        $orders = $request->orders;
        $price_uzs = $request->uzs;
        $price_usd = $request->usd;

        $basket = Warehouse_basket::create([
            'admin_id' => $admin->id,
            'postman_id' => $request->postman_id,
            'uzs_price' => $price_uzs,
            'usd_price' => $price_usd,
            'description' => $request->description,
            'ordered_at' => Carbon::now(),
        ]);

        foreach ($orders as $order) {
            $warehouse_orers = [
                'warehouse_basket_id' => $basket->id,
                'product_id' => $order['product_id'],
                'postman_id' => $request->postman_id,
                'count' => $order['count'],
                'unit' => $order['unit'],
                'price' => $order['price'],
                'description' => $order['description'],
            ];
            Warehouse_order::create($warehouse_orers);
        }

        return BaseController::response($basket->toArray());
    }

    public function delete($order_id)
    {

        try {
            $order = Warehouse_order::where('id', $order_id)->firstOrFail();
        } catch (\Throwable$th) {
            return BaseController::error('not found order', 404);
        }
        $basket_id = $order->warehouse_basket_id;
        $basket = Warehouse_basket::find($basket_id);
        if ($basket->status == 'unchecked') {
            ProductCode::where('warehouse_basket_id', $basket_id)->where('product_id', $order->product_id)->delete();
            $usd_price = $basket->usd_price;
            $uzs_price = $basket->uzs_price;
            if ($order->unit == "USD") {
                $usd_price -= $order->price * $order->count;
            } else {
                $uzs_price -= $order->price * $order->count;
            }
            $order->forceDelete();
            $basket->update([
                'usd_price' => $usd_price,
                'uzs_price' => $uzs_price,
            ]);
            return BaseController::success();
        } else {
            return BaseController::error('the order is not deleted', 409);
        }
    }

    public function basket_orders(Request $request)
    {
        $search = $request->search;
        $basket_id = $request->basket_id;

        $basket = Warehouse_basket::find($basket_id);
        $orders = $basket->orders;
        $final_response = [
            'basket_id' => $basket->id,
            'description' => $basket->description,
            'orders' => [],
        ];
        foreach ($orders as $order) {
            $final_response['orders'][] = [
                'order_id' => $order->id,
                'product_id' => $order->product->id,
                'product_name' => $order->product->name,
                'description' => $order->description,
                'unit' => $order->unit,
                'price' => $order->price,
                'count' => $order->count,
                'code' => $order->code,
                'qr_link' => env('APP_URL') . '/api/code/?code=' . $order->code,
            ];
        }
        if ($search) {
            $collect = collect($final_response['orders']);
            $searched = $collect->filter(function ($item) use ($search) {
                return stripos($item['product_name'], $search) !== false;
            });
            $final_response['orders'] = $searched->values();
        }
        return BaseController::response($final_response);
    }

    public function updateOrder(WarehouseOrderUpdate $request)
    {
        $basket = Warehouse_basket::find($request->basket_id);
        if ($basket->status == 'confirmed') {
            return BaseController::error('This basket cannot be edited', 409);
        }
        $usd_price = $basket->usd_price;
        $uzs_price = $basket->uzs_price;

        foreach ($request->orders as $item) {
            $order = Warehouse_order::find($item['order_id']);
            if ($order->unit == 'USD') {
                $usd_price -= $order->price * $order->count;
            } elseif ($order->unit == 'UZS') {
                $uzs_price -= $order->price * $order->count;
            }
            if ($item['unit'] == 'USD') {
                $usd_price += $item['price'] * $item['count'];
            } elseif ($item['unit'] == 'UZS') {
                $uzs_price += $item['price'] * $item['count'];
            }
            $order->count = $item['count'];
            $order->unit = $item['unit'];
            $order->price = $item['price'];
            $order->description = $item['description'];
            $order->save();
        }
        $basket->usd_price = $usd_price;
        $basket->uzs_price = $uzs_price;
        $basket->save();
        return BaseController::success();
    }

    public function addOrder(WarehouseAddOrder $request)
    {
        $basket = Warehouse_basket::find($request->basket_id);
        if ($basket->status != 'unchecked') {
            return BaseController::error('This basket cannot be edited', 409);
        }
        $usd_price = $basket->usd_price;
        $uzs_price = $basket->uzs_price;

        foreach ($request->orders as $item) {
            $order = Warehouse_order::where('product_id', $item['product_id'])->first();
            if ($order) {
                if ($order->unit == 'USD') {
                    $usd_price -= $order->price * $order->count;
                } elseif ($order->unit == 'UZS') {
                    $uzs_price -= $order->price * $order->count;
                }
                $order->count = $item['count'];
                $order->unit = $item['unit'];
                $order->price = $item['price'];
                $order->description = $item['description'];
                $order->save();
            } else {
                Warehouse_order::create([
                    'warehouse_basket_id' => $basket->id,
                    'product_id' => $item['product_id'],
                    'postman_id' => $basket->postman_id,
                    'count' => $item['count'],
                    'unit' => $item['unit'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                ]);

            }
            if ($item['unit'] == 'USD') {
                $usd_price += $item['price'] * $item['count'];
            } elseif ($item['unit'] == 'UZS') {
                $uzs_price += $item['price'] * $item['count'];
            }
        }
        $basket->usd_price = $usd_price;
        $basket->uzs_price = $uzs_price;
        $basket->save();

        return BaseController::success();
    }
}
