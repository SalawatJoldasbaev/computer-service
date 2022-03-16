<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public static function response($data = []){
        return response($data);
    }
    public static function error(string $message = '', $code){
        return response(
            [
                'message'=> $message
            ],
            $code);
    }

    public static function success($message = 'successful', $code = 200){
        return response([
            'message'=> $message,
        ], $code);
    }
}
