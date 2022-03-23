<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'codes'=> 'array'
    ];

    public function scopeSetWarehouse($query, int $postman_id, int $product_id, int $count, string $code){
        $date = date('Y-m-d');
        $warehouse = $query->where('postman_id', $postman_id)
            ->where('product_id', $product_id)
            ->where('active', true)
            ->orderBy('id', 'desc')->first();

        if($warehouse and $date == $warehouse->date){
            $codes = array_merge($warehouse->codes,[
                $code=>$count
            ]);
            $warehouse->update([
                'count'=> $warehouse->count+$count,
                'codes'=> $codes
            ]);
        }elseif ($warehouse and $date != $warehouse->date) {
            $codes = array_merge($warehouse->codes,[
                $code=>$count
            ]);
            $warehouse->update([
                'active'=> false
            ]);
            $this->create([
                'postman_id'=> $postman_id,
                'product_id'=> $product_id,
                'count'=> $warehouse->count+$count,
                'codes'=> $codes,
                'date'=> $date,
                'active'=> true
            ]);
        }else{
            $codes = [
                $code=>$count
            ];
            $warehouse = $this->create([
                'postman_id'=> $postman_id,
                'product_id'=> $product_id,
                'count'=> $count,
                'codes'=> $codes,
                'date'=> $date,
                'active'=> true
            ]);
        }
        // if($warehouse and $code){
            ProductCode::where('code', $code)->first()->update([
                'warehouse_id'=> $warehouse->id,
            ]);
        // }

    }

    public function product(){
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
