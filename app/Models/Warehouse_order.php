<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse_order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'codes'=> 'array',
    ];

    public function baskets(){
        return $this->hasMany(Warehouse_basket::class, 'warehouse_basket_id');
    }

    public function basket(){
        return $this->hasOne(Warehouse_basket::class, 'warehouse_basket_id');
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
