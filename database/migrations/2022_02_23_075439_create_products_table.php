<?php

use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Category::class);
            $table->string('name');
            $table->string('brand');
            $table->double('cost_price');
            $table->double('max_price');
            $table->double('whole_price');
            $table->double('min_price');
            $table->double('min_count')->nullable();
            $table->enum('unit', ['USD', 'UZS']);
            $table->timestamps();
            $table->softDeletes();
        });
        Product::create([
            'category_id' => 3,
            'name' => 'Kerek 1',
            'brand' => 'Kerek 1',
            'cost_price' => 5000,
            'max_price' => 1,
            'whole_price' => 1,
            'min_price' => 1,
            'min_price' => 1,
            'unit' => 'USD',
            'min_count' => 10
        ]);
        Product::create([
            'category_id' => 3,
            'name' => 'Kerek 2',
            'brand' => 'Kerek 2',
            'cost_price' => 5000,
            'max_price' => 1,
            'whole_price' => 1,
            'min_price' => 1,
            'min_price' => 1,
            'unit' => 'USD',
            'min_count' => 10,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
