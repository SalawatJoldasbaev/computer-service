<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id', 'parent_id', 'name', 'min_percent', 'max_percent', 'whole_percent');
    }

    public function ScopeWarehouseCount($query, $product_id = null)
    {
        return Warehouse::where('product_id', $product_id)->where('active', true)->sum('count');
    }
}
