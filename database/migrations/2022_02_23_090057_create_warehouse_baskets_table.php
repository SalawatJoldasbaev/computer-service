<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_baskets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Admin::class);
            $table->foreignIdFor(App\Models\Postman::class)->constrained('postmen');
            $table->double('usd_price');
            $table->double('uzs_price');
            $table->string('description')->nullable();
            $table->boolean('is_deliver')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_baskets');
    }
};
