<?php

use App\Models\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->default(0);
            $table->string('name');
            $table->integer('min_percent');
            $table->integer('max_percent');
            $table->integer('whole_percent');
            $table->timestamps();
            $table->softDeletes();
        });

        Category::create([
            'parent_id'=> 0,
            'name'=> 'Computer',
            'min_percent'=> 1,
            'max_percent'=> 1,
            'whole_percent'=> 1,
        ]);
        Category::create([
            'parent_id'=> 1,
            'name'=> 'PC',
            'min_percent'=> 1,
            'max_percent'=> 1,
            'whole_percent'=> 1,
        ]);
        Category::create([
            'parent_id'=> 2,
            'name'=> 'Gaming',
            'min_percent'=> 1,
            'max_percent'=> 1,
            'whole_percent'=> 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
