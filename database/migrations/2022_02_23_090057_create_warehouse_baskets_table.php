<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouse_baskets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Admin::class);
            $table->foreignIdFor(App\Models\Postman::class);
            $table->double('usd_price');
            $table->double('uzs_price');
            $table->string('description')->nullable();
            $table->string('description_checked')->nullable();
            $table->enum('status', ['unchecked', 'checked', 'confirmed']);
            $table->timestamp('ordered_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_baskets');
    }
};
