<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        $required = $request->parent_id == 0;
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'min_percent' => [Rule::requiredIf($required)],
            'whole_percent' => [Rule::requiredIf($required)],
            'max_percent' => [Rule::requiredIf($required)],
            'parent_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return BaseController::error($validation->errors()->first(), 422);
        }
        $category = Category::where('name', $request->name)->first();
        if ($category) {
            return BaseController::error('The category name already exists', 422);
        }
        if ($request->parent_id == 0) {
            $category = Category::create([
                'name' => $request->name,
                'min_percent' => $request->min_percent,
                'whole_percent' => $request->whole_percent,
                'max_percent' => $request->max_percent,
                'parent_id' => $request->parent_id,
            ]);
        } else {
            $category = Category::find($request->parent_id);
            if (!$category) {
                return BaseController::error('parent_id not found', 404);
            }
            $category = Category::create([
                'name' => $request->name,
                'min_percent' => $request->min_percent ?? $category->min_percent,
                'whole_percent' => $request->whole_percent ?? $category->whole_percent,
                'max_percent' => $request->max_percent ?? $category->max_percent,
                'parent_id' => $request->parent_id,
            ]);
        }

        return BaseController::response($category);
    }

    public function index(Request $request)
    {
        $categories = Category::select('id', 'parent_id', 'name', 'min_percent', 'max_percent', 'whole_percent')->where('parent_id', 0)->with('children')->get();
        return BaseController::response($categories);
    }

    public function update(Request $request)
    {
        $category_id = $request->category_id;
        $category = Category::find($category_id);
        if ($category) {
            $category->update($request->all());
            return BaseController::success();
        } else {
            return BaseController::error('category not found', 404);
        }
    }

    public function show($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return BaseController::error('category not found', 404);
        }
        $data = [
            'parent_id' => $category->parent_id,
            'name' => $category->name,
            'min_percent' => $category->min_percent,
            'max_percent' => $category->max_percent,
            'whole_percent' => $category->whole_percent,
            'children' => $category->children,
        ];
        return BaseController::response($data);
    }
    public function delete($id)
    {
        $category = Category::find($id);
        $final_response = [];
        $this->parent_ids($category->parents, $final_response, $category->id);
        Category::whereIn('id', $final_response)->delete();
        $products = Product::whereIn('category_id', $final_response)->get()->collect();
        Product::destroy($products->pluck('id'));
        return BaseController::success('successful deleted');
    }

    private function parent_ids($parents, &$final_response, $id = null)
    {
        if (!is_null($id)) {
            $final_response[] = $id;
        }
        foreach ($parents as $parent) {
            $final_response[] = $parent->id;
            if (!empty($parent->parents)) {
                $this->parent_ids($parent->parents, $final_response);
            }
        }
    }
}
