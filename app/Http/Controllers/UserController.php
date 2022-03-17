<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request){
        $validation = Validator::make($request->all(), [
            'full_name'=>'required',
            'phone'=>'required|unique:Users,phone',
            'inn'=>'required_if:status,Y,P|unique:Users,inn|nullable',
            'status'=>'required',
            'description'=>'nullable'
        ]);

        if($validation->fails()){
            return BaseController::error($validation->errors()->first(), 422);
        }
        User::create($request->only('full_name', 'phone', 'inn', 'status', 'description'));
        return BaseController::success();
    }

    public function delete($id, Request $request){
        User::destroy($id);
        return BaseController::success();
    }

    public function update($id, Request $request){
        $validation = Validator::make($request->all(), [
            'full_name'=>'nullable',
            'phone'=>'nullable',
            'inn'=>'required_if:status,Y,P|nullable',
            'status'=>'nullable',
            'description'=>'nullable'
        ]);

        if($validation->fails()){
            return BaseController::error($validation->errors()->first(), 422);
        }
        User::find($id)->update($request->all());
        return BaseController::success();
    }

    public function single($id, Request $request){
        $user = User::find($id);
        if(empty($user)){
            return BaseController::error('not found user', 404);
        }else{
            return BaseController::response($user);
        }
    }

    public function all(Request $request){
        return BaseController::response(User::all()->toArray());
    }
}
