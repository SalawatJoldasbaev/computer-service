<?php

namespace App\Providers;

use App\Models\Warehouse_basket;
use App\Models\Warehouse_order;
use App\Observers\WarehouseBasketObserver;
use App\Observers\WarehouseOrderObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Warehouse_order::observe(WarehouseOrderObserver::class);
        Warehouse_basket::observe(WarehouseBasketObserver::class);
    }
}
