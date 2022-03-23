<?php

namespace App\Observers;

use App\Models\ProductCode;
use Illuminate\Support\Str;
use App\Models\Warehouse_order;

class WarehouseOrderObserver
{
    /**
     * Handle the Warehouse_order "created" event.
     *
     * @param  \App\Models\Warehouse_order  $warehouse_order
     *
     */
    public function creating(Warehouse_order $warehouse_order)
    {
        $code = Str::random(5);
        $create = ProductCode::where('code', $code)->first();
        while($create){
            $code = Str::random(5);
            $create = ProductCode::where('code', $code)->first();
        }
        $warehouse_order->code = $code;

        if(!$create){
            $create = ProductCode::create([
                'postman_id'=> $warehouse_order->postman_id,
                'product_id'=> $warehouse_order->product_id,
                'warehouse_basket_id'=> $warehouse_order->warehouse_basket_id,
                'count'=> $warehouse_order->count,
                'code'=> $code,
                'cost_price'=> $warehouse_order->price
            ]);
        }
    }

    /**
     * Handle the Warehouse_order "updated" event.
     *
     * @param  \App\Models\Warehouse_order  $warehouse_order
     * @return void
     */
    public function updated(Warehouse_order $warehouse_order)
    {
        //
    }

    /**
     * Handle the Warehouse_order "deleted" event.
     *
     * @param  \App\Models\Warehouse_order  $warehouse_order
     * @return void
     */
    public function deleted(Warehouse_order $warehouse_order)
    {
        //
    }

    /**
     * Handle the Warehouse_order "restored" event.
     *
     * @param  \App\Models\Warehouse_order  $warehouse_order
     * @return void
     */
    public function restored(Warehouse_order $warehouse_order)
    {
        //
    }

    /**
     * Handle the Warehouse_order "force deleted" event.
     *
     * @param  \App\Models\Warehouse_order  $warehouse_order
     * @return void
     */
    public function forceDeleted(Warehouse_order $warehouse_order)
    {
        //
    }
}
