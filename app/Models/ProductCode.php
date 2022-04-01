<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCode extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function postman(){
        return $this->belongsTo(Postman::class)->withTrashed();
    }

    public function product(){
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function warehouse(){
        if(is_null($this->warehouse_basket_id)){
            return $this->belongsTo(Warehouse::class);
        }else{
            return $this->belongsTo(Warehouse::class, 'product_id', 'product_id')->where('postman_id', $this->postman_id);
        }
    }

    public function basket(){
        return $this->belongsTo(Warehouse_basket::class, 'warehouse_basket_id');
    }
}
