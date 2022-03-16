<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse_basket extends Model
{
    use HasFactory;
   protected $guarded = ['id'];

    public function Postman(){
        return $this->belongsTo(Postman::class);
    }
    public function Admin(){
        return $this->belongsTo(Admin::class);
    }
}
