<?php

namespace App\Http\Controllers;

use App\Models\ProductCode;
use App\Models\Warehouse;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $postman_id = $request->postman_id;
        $warehouse = Warehouse::where('active', true)->orderBy('id', 'desc')->get();
        $temp = ['postman' => [], 'products' => []];
        $products = [];
        foreach ($warehouse as $item) {
            if (!isset($temp['products'][$item->product_id])) {
                $temp['products'][$item->product_id] = [null];
            }

            if (!in_array($item->postman_id, $temp['products'][$item->product_id])) {
                if (!isset($products[$item->product_id])) {
                    $products[$item->product_id] = [
                        'product_id' => $item->product->id,
                        'product_name' => $item->product->name,
                        'count' => $item->count,
                        'codes' => $item->codes
                    ];
                } else {
                    $products[$item->product_id]['count'] += $item->count;
                    $products[$item->product_id]['codes'] = array_merge($item->codes, $products[$item->product_id]['codes']);
                }
                $temp['products'][$item->product_id][] = $item->postman_id;
            }
        }
        return BaseController::response(array_values($products));
    }

    public function defect(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'defective' => 'required|array',
            'defective.*.product_id' => 'required|integer',
            'defective.*.count' => 'required|integer',
            'defective.*.code' => 'required|string|exists:product_codes,code',
        ]);
        if ($validation->fails()) {
            return BaseController::error($validation->errors()->first(), 422);
        }
        $defective = $request->defective;
        $error = ['error' => false];
        foreach ($defective as $defect) {
            $code = ProductCode::where('code', $defect['code'])->first();
            if ($code->warehouse->codes[$defect['code']] < $defect['count']) {
                $error['error'] = true;
                $error['products'] .= $code->product->name . ', ';
            }
        }

        if ($error['error'] === true) {
            return BaseController::error($error['products'] . 'The products are not enough', 409);
        }

        foreach ($defective as $defect) {
            $code = ProductCode::where('code', $defect['code'])->first();
            $warehouse = Warehouse::where('product_id', $code->product_id)
                ->where('id', $code->warehouse_id)->first();
            $codes = $warehouse->codes;
            $codes[$defect['code']] -= $defect['count'];
            $warehouse->update([
                'count' => $warehouse->count - $defect['count'],
                'codes' => $codes,
            ]);
        }
        return BaseController::success();
    }

    public function cost_price(Request $request)
    {
        $codes = ProductCode::whereHas('warehouse', function ($query) {
            return $query->where('active', true);
        })->get();
        $final = [
            'UZS' => 0,
            'USD' => 0,
        ];
        foreach ($codes as $code) {
            if ($code->unit == 'USD') {
                $final['USD'] += $code->cost_price * $code->count;
            } elseif ($code->unit == 'UZS') {
                $final['UZS'] += $code->cost_price * $code->count;
            }
        }
        return BaseController::response($final);
    }
}
