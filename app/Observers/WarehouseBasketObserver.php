<?php

namespace App\Observers;

use App\Models\AccountNumber;
use App\Models\Warehouse_basket;

class WarehouseBasketObserver
{
    /**
     * Handle the Warehouse_basket "created" event.
     *
     * @param  \App\Models\Warehouse_basket  $warehouse_basket
     * @return void
     */
    public function created(Warehouse_basket $basket)
    {
        AccountNumber::create([
            'postman_id' => $basket->postman_id,
            'warehouse_basket_id' => $basket->id,
            'additional' => [
                'price' => [
                    'uzs' => $basket->uzs_price,
                    'usd' => $basket->usd_price,
                ]
            ]
        ]);
    }

    /**
     * Handle the Warehouse_basket "updated" event.
     *
     * @param  \App\Models\Warehouse_basket  $warehouse_basket
     * @return void
     */
    public function updated(Warehouse_basket $warehouse_basket)
    {
        //
    }

    /**
     * Handle the Warehouse_basket "deleted" event.
     *
     * @param  \App\Models\Warehouse_basket  $warehouse_basket
     * @return void
     */
    public function deleted(Warehouse_basket $warehouse_basket)
    {
        //
    }

    /**
     * Handle the Warehouse_basket "restored" event.
     *
     * @param  \App\Models\Warehouse_basket  $warehouse_basket
     * @return void
     */
    public function restored(Warehouse_basket $warehouse_basket)
    {
        //
    }

    /**
     * Handle the Warehouse_basket "force deleted" event.
     *
     * @param  \App\Models\Warehouse_basket  $warehouse_basket
     * @return void
     */
    public function forceDeleted(Warehouse_basket $warehouse_basket)
    {
        //
    }
}
