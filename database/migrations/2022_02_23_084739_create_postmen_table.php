<?php

use App\Models\Postman;
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
        Schema::create('postmen', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone')->unique();
            $table->string('inn')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Postman::create([
            'full_name'=> 'Saliq',
            'phone'=> '998906622939',
            'inn'=> '123456789'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('postmen');
    }
};
