<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    public function index(Request $request){
        $postman_id = $request->postman_id;
        $warehouse = Warehouse::orderBy('id', 'desc')->get();
        $temp = ['postman'=> [], 'products'=> []];
        $products = [];
        foreach ($warehouse as $item) {
            if(!isset($temp['products'][$item->product_id])){
                $temp['products'][$item->product_id] = [null];
            }

            if(!in_array($item->postman_id, $temp['products'][$item->product_id])){
                if(!isset($products[$item->product_id])){
                    $products[$item->product_id] = [
                        'name'=> $item->product->name,
                        'count'=> $item->count,
                        'codes'=> $item->codes
                    ];
                }else{
                    $products[$item->product_id]['count'] += $item->count;
                    $products[$item->product_id]['codes'] = array_merge($item->codes, $products[$item->product_id]['codes']);
                }
                $temp['products'][$item->product_id][] = $item->postman_id;
            }
        }
        return BaseController::response(array_values($products));
    }

    public function defect(Request $request){
        $validation = Validator::make($request->all(), [
            'defective'=> 'required|array',
            'defective.*.product_id'=> 'required|integer',
            'defective.*.count'=> 'required|integer',
            'defective.*.codes'=> 'required|array',
        ]);
        $products = array_column($request->all(), 'product_id');
        if($validation->fails()){
            return BaseController::error($validation->errors()->first(), 422);
        }
        $defective = $request->defective;
        foreach($defective as $defect){
            $defect_codes = $defect['codes'];
            $warehouse = Warehouse::where('active', true)->where('product_id', $defect['product_id'])->get();
            foreach ($warehouse as $item) {
                $codes = $item->codes;
                for ($i=0; $i < $defect['count']; $i++) {
                    $code = $defect_codes[$i];
                    if(in_array($code, $codes)){
                        $key = key(Arr::where($codes, function ($value, $key) use ($code) {
                            return $value == $code;
                        }));
                        Arr::forget($codes, $key);
                        $item->codes = array_values($codes);
                        $item->count -= 1;
                        $item->save();
                    }
                }
            }
        }
    }
}
