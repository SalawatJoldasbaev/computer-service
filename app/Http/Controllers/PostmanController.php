<?php

namespace App\Http\Controllers;

use App\Models\Postman;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Validator;

class PostmanController extends Controller
{
    public function create(Request $request){
        $validation = Validator::make($request->all(), [
            'full_name'=>'required',
            'phone'=>'required|unique:postmen,phone',
            'inn'=>'required|unique:postmen,inn',
            'description'=>'nullable'
        ]);

        if($validation->fails()){
            return BaseController::error($validation->errors()->first(), 422);
        }

        Postman::create($request->all());
        return BaseController::success();
    }

    public function single($postman_id, Request $request){
        $postman = Postman::find($postman_id);
        if(empty($postman)){
            return BaseController::error('Postman not found', 404);
        }else{
            return BaseController::response($postman->toArray());
        }
    }

    public function update($postman_id, Request $request){
        $validation = Validator::make($request->all(), [
            'full_name'=>'required',
            'phone'=>'required',
            'inn'=>'required',
            'description'=>'nullable'
        ]);
        if($validation->fails()){
            return BaseController::error($validation->errors()->first(), 422);
        }

        $postman = Postman::find($postman_id);
        if(empty($postman)){
            return BaseController::error('Postman not found', 404);
        }else{
            Postman::find($postman_id)->update($request->all());
            return BaseController::success();
        }
    }

    public function delete($postman_id){
        Postman::destroy($postman_id);
        return BaseController::success();
    }

    public function all_postman(){
        return BaseController::response(Postman::all('id', 'full_name', 'phone', 'inn', 'description')->toArray());
    }
}
