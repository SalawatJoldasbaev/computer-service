<?php

use App\Models\Postman;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Postman::class);
            $table->foreignIdFor(App\Models\Product::class);
            $table->foreignIdFor(App\Models\Warehouse::class)->nullable();
            $table->foreignIdFor(App\Models\Warehouse_basket::class)->nullable();
            $table->string('code')->unique();
            $table->double('cost_price');
            $table->double('count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_codes');
    }
};
