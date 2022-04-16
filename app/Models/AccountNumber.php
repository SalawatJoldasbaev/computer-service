<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountNumber extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'additional' => 'json'
    ];

    public function basket()
    {
        return $this->belongsTo(Warehouse_basket::class, 'warehouse_basket_id');
    }
}
