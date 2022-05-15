<?php

namespace App\Http\Controllers;

use App\Models\Warehouse_basket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryOrderController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from ?? Carbon::today();
        $to = $request->to ?? Carbon::today();
        $postman_id = $request->postman_id;
        $status = $request->status;
        $warehouseBasket = Warehouse_basket::whereIn('status', ['checked', 'confirmed'])->whereDate('delivered_at', '>=', $from)
            ->whereDate('delivered_at', '<=', $to)
            ->when($postman_id, function ($query) use ($postman_id) {
                return $query->where('postman_id', $postman_id);
            })
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->get();

        $final = [];
        foreach ($warehouseBasket as $basket) {
            $final[] = [
                'basket_id' => $basket->id,
                'postman' => [
                    'id' => $basket->postman_id,
                    'name' => $basket->postman->full_name,
                ],
                'price' => [
                    'usd' => $basket->usd_price,
                    'uzs' => $basket->uzs_price,
                ],
                'status' => $basket->status,
                'description' => $basket->description,
                'ordered_at' => $basket->ordered_at,
                'delivered_at' => $basket->delivered_at,
            ];
        }

        return BaseController::response($final);
    }

    public function orders(Request $request, $basket_id)
    {
        try {
            $basket = Warehouse_basket::findOrFail($basket_id);
            $orders = $basket->orders;
        } catch (\Throwable$th) {
            return BaseController::error('basket not found', 404);
        }
        $final = [];
        foreach ($orders as $order) {
            $final[] = [
                'product_id' => $order->product_id,
                'product_name' => $order->product->name,
                'ordered_count' => $order->count,
                'arrival_count' => $order->get_count,
                'unit' => $order->unit,
                'price' => $order->price,
                'description' => $order->description,
                'qr_link' => env('APP_URL') . '/api/code/?code=' . $order->code,
            ];
        }
        return BaseController::response($final);
    }
}
