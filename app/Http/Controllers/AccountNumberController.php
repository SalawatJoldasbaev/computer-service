<?php

namespace App\Http\Controllers;

use App\Models\AccountNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccountNumberController extends Controller
{
    public function index(Request $request, $postman_id)
    {
        $from = $request->from ?? Carbon::today();
        $to = $request->to ?? Carbon::today();
        $accountNumber = AccountNumber::where('postman_id', $postman_id)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->get();
        $final = [];
        foreach ($accountNumber as $item) {
            $final[] = [
                'payment_id' => $item->id,
                'basket_id' => $item->warehouse_basket_id,
                'price' => $item->additional['price'],
                'basket' => [
                    'description' => $item->basket->description,
                    'is_deliver' => $item->basket->is_deliver,
                    'ordered_at' => $item->basket->ordered_at,
                    'delivered_at' => $item->basket->delivered_at,
                ]

            ];
        }
        return BaseController::response($final);
    }

    public function update(Request $request, $postman_id)
    {
        $payment_id = $request->payment_id;
        $price = $request->price;
        if (!isset($price['uzs']) or !isset($price['usd'])) {
            return BaseController::error('usd and uzs required', 409);
        }
        try {
            $accountNumber = AccountNumber::where('postman_id', $postman_id)->where('id', $payment_id)->firstOrFail();
        } catch (\Throwable $th) {
            return BaseController::error('payment not found', 404);
        }
        $additional = $accountNumber->additional;
        $additional['price'] = $price;
        $accountNumber->update([
            'additional' => $additional
        ]);
        return BaseController::success();
    }
}
