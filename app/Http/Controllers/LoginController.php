<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Database\Console\Migrations\BaseCommand;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        $pincode = md5($request->pincode);
        $password = $request->password;
        if(isset($password)){
            $admin = Admin::where('user_name', $request->user_name)->first();
            if(!$admin or !Hash::check($password, $admin->password)){
                return BaseController::error('admin not found', 401);
            }
        }else{
            $admin = Admin::where('pincode', $pincode)->first();
            if(!$admin){
                return BaseController::error('admin not found', 401);
            }
        }
        $token = $admin->createToken($request->header('User-Agent'))->plainTextToken;

        return BaseController::response([
            'admin_id'=>$admin->id,
            'user_name'=>$admin->user_name,
            'admin_name'=>$admin->name,
            'role'=> $admin->role->name,
            'token'=>$token
        ]);
    }
}
