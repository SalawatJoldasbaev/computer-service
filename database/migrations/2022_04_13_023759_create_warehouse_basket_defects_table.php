<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouse_basket_defects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Admin::class);
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'finished']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouse_basket_defects');
    }
};
