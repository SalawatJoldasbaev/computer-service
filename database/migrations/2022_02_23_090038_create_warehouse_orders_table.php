<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up():void
    {
        Schema::create('warehouse_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Warehouse_basket::class);
            $table->foreignIdFor(App\Models\Product::class);
            $table->foreignIdFor(App\Models\Postman::class);
            $table->integer('count');
            $table->json('codes')->nullable();
            $table->integer('get_count')->default(0);
            $table->enum('unit', ['UZS', 'USD']);
            $table->double('price');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('warehouse_orders');
    }
};
