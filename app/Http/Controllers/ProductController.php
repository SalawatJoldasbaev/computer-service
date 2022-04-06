<?php
//Aysdjkfsdhfbn
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'product.name' => 'required|unique:products,name',
            'product.brand' => 'nullable',
            'product.cost_price' => 'required',
            'product.min_price' => 'required',
            'product.max_price' => 'required',
            'product.whole_price' => 'required',
            'product.unit' => 'required'
        ]);
        if ($validation->fails()) {
            return BaseController::error($validation->errors()->first(), 422);
        }
        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->product['name'],
            'brand' => $request->product['brand'],
            'cost_price' => $request->product['cost_price'],
            'min_price' => $request->product['min_price'],
            'whole_price' => $request->product['whole_price'],
            'max_price' => $request->product['max_price']
        ]);

        return BaseController::success();
    }

    public function all_products(Request $request)
    {
        $limit = $request->limit ?? 40;
        $search = $request->search;
        $category_id = $request->category_id;
        $products = Product::with(['category'])->select(
            'id',
            'category_id',
            'name',
            'brand',
            'cost_price',
            'max_price',
            'whole_price',
            'min_price',
            'unit'
        );
        if ($category_id) {
            try {
                $category = Category::findOrFail($category_id);
            } catch (ModelNotFoundException $e) {
                return BaseController::error('not found', 404);
            }
            if ($category->parent_id == 0) {
                $final_response = [];
                $this->parent_ids($category->parents, $final_response, $category->id);
                $products = $products->whereIn('category_id', $final_response);
            } else {
                $products = $products->where('category_id', $category->id);
            }
        }
        if ($search) {
            $products = $products->where('name', 'like', '%' . $search . '%')->orWhere('brand', 'like', '%' . $search . '%');
        }
        $products = $products->paginate($limit);
        $final = [];
        foreach ($products as $product) {
            $product['warehouse'] = (int)$product->WarehouseCount($product->id);
            $final[] = $product;
        }
        return $final;
    }

    public function delete($product_id)
    {
        Product::destroy($product_id);
        return BaseController::success();
    }

    public function update($product_id, Request $request)
    {
        $validation = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'product.name' => 'required',
            'product.brand' => 'nullable',
            'product.cost_price' => 'required',
            'product.min_price' => 'required',
            'product.max_price' => 'required',
            'product.whole_price' => 'required',
            'product.unit' => 'required'
        ]);
        if ($validation->fails()) {
            return BaseController::error($validation->errors()->first(), 422);
        }
        $product = Product::find($product_id);
        if (empty($product)) {
            return BaseController::error('Product not found', 404);
        } else {
            Product::find($product_id)
                ->update([
                    'category_id' => $request->category_id,
                    'name' => $request->product['name'],
                    'brand' => $request->product['brand'],
                    'cost_price' => $request->product['cost_price'],
                    'min_price' => $request->product['min_price'],
                    'whole_price' => $request->product['whole_price'],
                    'max_price' => $request->product['max_price']
                ]);
            return BaseController::success();
        }
    }

    public function single($product_id, Request $request)
    {
        $product = Product::find($product_id);
        if (empty($product)) {
            return BaseController::response([]);
        }
        return BaseController::response($product->toArray());
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
