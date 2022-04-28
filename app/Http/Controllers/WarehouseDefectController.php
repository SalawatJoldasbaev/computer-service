<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\ProductCode;
use Illuminate\Http\Request;
use App\Models\WarehouseItemDefect;
use App\Models\WarehouseBasketDefect;
use App\Http\Requests\WarehouseSetBasketRequest;
use Carbon\Carbon;

class WarehouseDefectController extends Controller
{
    public function setBasket(WarehouseSetBasketRequest $request)
    {
        $admin = $request->user();
        $basket = $this->getBasket($admin);
        if (!$basket) {
            $basket = $this->createBasket($admin, $request);
        }
        if ($basket->description != $request->basket['description']) {
            $basket->update([
                'description' => $request->basket['description'],
            ]);
        }
        $item = WarehouseItemDefect::where('warehouse_basket_defect_id', $basket->id)->where('code', $request->code)->first();
        if (!$item) {
            $item = WarehouseItemDefect::create([
                'warehouse_basket_defect_id' => $basket->id,
                'postman_id' => $request->postman_id,
                'product_id' => $request->product_id,
                'count' => $request->count,
                'code' => $request->code
            ]);
        } else {
            $item->update([
                'count' => $item->count + $request->count,
            ]);
        }
        return BaseController::success();
    }

    private function getBasket($admin)
    {
        $basket = WarehouseBasketDefect::where('admin_id', $admin->id)
            ->where('status', 'draft')->first();
        return $basket;
    }

    private function createBasket($admin, $request)
    {
        $basket = WarehouseBasketDefect::create([
            'admin_id' => $admin->id,
            'status' => 'draft',
            'description' => $request->basket['description'] ?? null
        ]);
        return $basket;
    }

    public function getBasketItems(Request $request)
    {
        $basket = $this->getBasket($request->user());
        if (!$basket) {
            return BaseController::response();
        }
        $items = [];
        foreach ($basket->items as $item) {
            $warehouse = Warehouse::where('active', true)->where('postman_id', $item->postman_id)
                ->where('product_id', $item->product_id)->first();
            $items[] = [
                'item_id' => $item->id,
                'postman_id' => $item->postman_id,
                'postman_name' => $item->postman->full_name,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'code' => $item->code,
                'count' => $item->count,
                'warehouse' => [
                    'id' => $warehouse->id,
                    'count' => $warehouse->codes[$item->code]
                ]
            ];
        }
        return $items;
    }

    public function deleteItem(Request $request)
    {
        WarehouseItemDefect::destroy($request->ids);
        return BaseController::success();
    }

    public function updateItem(Request $request)
    {
        $item = WarehouseItemDefect::find($request->item_id);
        if (!$item) {
            return BaseController::error('not found item', 404);
        }
        if ($request->count == 0) {
            $item->delete();
        } else {
            $item->update([
                'count' => $request->count
            ]);
        }
        return BaseController::success();
    }

    public function confirm(Request $request)
    {
        $basket = $this->getBasket($request->user());
        $items = $basket->items;

        $error = ['error' => false, 'products' => ''];
        foreach ($items as $item) {
            $code = ProductCode::where('code', $item['code'])->first();
            if ($code->warehouse->codes[$item['code']] < $item['count']) {
                $error['error'] = true;
                $error['products'] .= $code->product->name . ', ';
            }
        }

        if ($error['error'] === true) {
            return BaseController::error($error['products'] . 'The products are not enough', 409);
        }

        foreach ($items as $items) {
            $code = ProductCode::where('code', $item['code'])->first();
            $warehouse = Warehouse::where('product_id', $code->product_id)
                ->where('id', $code->warehouse_id)->first();
            $codes = $warehouse->codes;
            $codes[$item['code']] -= $item['count'];
            $warehouse->update([
                'count' => $warehouse->count - $item['count'],
                'codes' => $codes,
            ]);
        }
        $basket->update([
            'status' => 'finished'
        ]);
        return BaseController::success();
    }

    public function index(Request $request)
    {
        $from = $request->from ?? Carbon::today();
        $to = $request->to ?? Carbon::today();

        $warehouseBaskets = WarehouseBasketDefect::whereDate('updated_at', '>=', $from)
            ->whereDate('updated_at', '<=', $to)
            ->paginate(30);
        $final = [];
        $temp = [];
        foreach ($warehouseBaskets as $basket) {
            $temp = [
                'basket_id' => $basket->id,
                'status' => $basket->status,
                'description' => $basket->description,
                'admin' => [
                    'id' => $basket->admin_id,
                    'name' => $basket->admin->name
                ],
            ];
            foreach ($basket->items as $item) {
                $temp['orders'][] = [
                    'postman_id' => $item->postman_id,
                    'postman_name' => $item->postman->full_name,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product?->name,
                    'count' => $item->count,
                    'code' => $item->code,
                ];
            }
            $final[] = $temp;
            $temp = [];
        }
        return BaseController::response($final);
    }
}
