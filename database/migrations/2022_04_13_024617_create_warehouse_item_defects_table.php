<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouse_item_defects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\WarehouseBasketDefect::class);
            $table->foreignIdFor(App\Models\Postman::class);
            $table->foreignIdFor(App\Models\Product::class);
            $table->double('count');
            $table->string('code');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_item_defects');
    }
};
