<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse_basket extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];
    public function Postman()
    {
        return $this->belongsTo(Postman::class)->withTrashed();
    }
    public function Admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function orders()
    {
        return $this->hasMany(Warehouse_order::class);
    }
}
