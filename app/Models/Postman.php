<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Postman extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function Warehouse_basket(){
        return $this->hasMany(Warehouse_basket::class, 'postman_id');
    }
}
