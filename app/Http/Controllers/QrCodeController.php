<?php

namespace App\Http\Controllers;

use App\Models\ProductCode;
use App\Models\WarehouseBasketDefect;
use Illuminate\Http\Request;
use App\Models\WarehouseItemDefect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate(Request $request)
    {
        $code = $request->code;
        if ($code) {
            return QrCode::format('svg')->size(250)->generate(env('APP_URL') . '/api/code/' . $code);
        }
    }

    public function code($code)
    {
        $data = ProductCode::where('code', $code)->first();
        $item = WarehouseItemDefect::where('code', $code)->first();
        $count = $data->count;
        if (!$data) {
            return BaseController::error('code not found', 404);
        }
        if ($item) {
            $basket = WarehouseBasketDefect::find($item->warehouse_basket_defect_id);
            if ($basket->status == 'draft') {
                $count -= $item->count;
            }
        }

        $final = [
            'warehouse_id' => $data->warehouse_id,
            'postman' => [
                'id' => $data->postman->id,
                'name' => $data->postman->full_name
            ],
            'product' => [
                'id' => $data->product->id,
                'name' => $data->product->name
            ],
            'warehouse' => isset($data->warehouse) ? [
                'count' => $data->warehouse->count,
                'code_count' => $data->warehouse->codes[$code] ?? 0,
            ] : null,
            'unit' => $data->unit,
            'cost_price' => $data->cost_price,
            'count' => $count,
            'ordered_at' => $data->basket->ordered_at,
            'delivered_at' => $data->basket->delivered_at,
        ];
        return BaseController::response($final);
    }
}
