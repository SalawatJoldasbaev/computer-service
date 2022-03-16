<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function create(Request $request){
        $validation = Validator::make($request->all(), [
            'name'=>'required|string',
            'min_percent'=>'required|integer',
            'whole_percent'=>'required|integer',
            'max_percent'=>'required|integer',
            'parent_id'=> 'required|integer'
        ]);

        if($validation->fails()){
            return BaseController::error($validation->errors()->first(), 422);
        }

        $category = Category::create([
            'name'=> $request->name,
            'min_percent'=> $request->min_percent,
            'whole_percent'=> $request->whole_percent,
            'max_percent'=> $request->max_percent,
            'parent_id'=> $request->parent_id
        ]);

        return BaseController::response($category);
    }

    public function index(Request $request){
        $categories = Category::select('id', 'parent_id', 'name', 'min_percent', 'max_percent', 'whole_percent')->where('parent_id', 0)->with('children')->get();
        return BaseController::response($categories);
    }

}
