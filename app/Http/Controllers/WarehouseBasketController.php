<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistory;
use App\Models\ProductCode;
use App\Models\Warehouse;
use App\Models\Warehouse_basket;
use App\Models\Warehouse_order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseBasketController extends Controller
{
    public function all_basket(Request $request)
    {
        $postman_id = $request->postman_id;

        $baskets = Warehouse_basket::where('status', 'unchecked')
            ->when($postman_id, function ($query) use ($postman_id) {
                $query->where('postman_id', $postman_id);
            })->get();
        $data = [];
        foreach ($baskets as $basket) {
            $data[] = [
                'basket_id' => $basket->id,
                'admin' => [
                    'id' => $basket->admin->id,
                    'name' => $basket->admin->name,
                ],
                'postman' => [
                    'id' => $basket->postman->id,
                    'full_name' => $basket->postman->full_name,
                ],
                'price' => [
                    'usd' => $basket->usd_price,
                    'uzs' => $basket->uzs_price,
                ],
                'status' => $basket->status,
                'date' => date_format($basket->created_at, 'Y-m-d H:i:s'),
                'description' => $basket->description,
                'ordered_at' => $basket->ordered_at,
                'delivered_at' => $basket->delivered_at,
            ];
        }
        return BaseController::response($data);
    }

    public function setWarehouse(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'basket_id' => 'required|exists:warehouse_baskets,id',
            'orders' => 'required|array',
            'orders.*.order_id' => 'required|integer',
            'orders.*.product_id' => 'required|integer',
            'orders.*.count' => 'required|integer',
            'orders.*.code' => 'nullable|string',
        ]);

        if ($validation->fails()) {
            return BaseController::error($validation->errors()->first(), 422);
        }

        $basket_id = $request->basket_id;
        $basket = Warehouse_basket::find($basket_id);
        if ($basket->status != 'unchecked') {
            return BaseController::error('basket not found', 404);
        }
        $orders = collect($request->orders);
        $basket_orders = Warehouse_order::where('warehouse_basket_id', $basket_id)->get();
        foreach ($basket_orders as $order) {
            $get_order = $orders->where('order_id', $order->id)->where('product_id', $order->product_id)->first();
            if (isset($order->description)) {
                $order->description = $get_order['description'];
            }
            $order->get_count = $get_order['count'];
            $order->save();
            Warehouse::SetWarehouse($order->postman_id, $order->product_id, $get_order['count'], $order->code);
        }
        $basket->update([
            'status' => 'checked',
            'delivered_at' => Carbon::now(),
        ]);
        return BaseController::success();
    }

    public function delete(Warehouse_basket $basket)
    {
        if ($basket->status == 'unchecked') {
            $basket->orders()->forceDelete();
            ProductCode::where('warehouse_basket_id', $basket->id)->delete();
            $basket->forceDelete();
            return BaseController::success();
        } else {
            return BaseController::error('The basket cannot be deleted', 409);
        }
    }

    public function confirmation(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'basket_id' => 'required|exists:warehouse_baskets,id',
            'usd_rate'=> 'required',
            'price'=> 'required',
            'description' => 'nullable',
        ]);

        if ($validation->fails()) {
            return BaseController::error($validation->errors()->first(), 422);
        }

        $basket = Warehouse_basket::find($request->basket_id);
        $postman = $basket->postman;
        $usd_price = 0;
        $uzs_price = 0;
        $orders = $basket->orders;
        foreach ($orders as $order) {
            $order->count = $order->get_count;
            if ($order->unit == 'USD') {
                $usd_price += $order->price * $order->get_count;
            } elseif ($order->unit == 'UZS') {
                $uzs_price += $order->price * $order->get_count;
            }
            $order->save();
        }
        $price = (($usd_price-$request->price)*$request->usd_rate)+$uzs_price;
        PaymentHistory::create([
            'postman_id'=> $postman->id,
            'usd_rate'=> $request->usd_rate,
            'paid_sum'=> $request->price,
            'balance'=> ($usd_price*$request->usd_rate)+$uzs_price,
            'paid_time'=> Carbon::now(),
        ]);
        $basket->description_checked = $request->description;
        $basket->status = 'confirmed';
        $basket->usd_price = $usd_price;
        $basket->uzs_price = $uzs_price;
        $postman->balance += $price;
        $postman->save();
        $basket->save();
        return BaseController::success();

    }
}
