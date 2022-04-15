<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseBasketDefect extends Model
{

    use HasFactory;
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(WarehouseItemDefect::class);
    }

    public function scopeFinished($query)
    {
        return $query->where('status', 'finished');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
