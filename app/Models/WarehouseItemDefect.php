<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseItemDefect extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function postman()
    {
        return $this->belongsTo(Postman::class)->withTrashed();
    }
}
