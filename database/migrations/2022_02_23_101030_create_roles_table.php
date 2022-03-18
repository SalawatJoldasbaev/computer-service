<?php

use App\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Role::upsert([
            ['name'=> 'Директор'],
            ['name'=> 'Бухгалтер'],
            ['name'=> 'Кассир'],
            ['name'=> 'Заведующий складом'],
            ['name'=> 'Контроль качество'],
            ['name'=> 'Торговый агент'],
            ['name'=> 'Продавец'],
            ['name'=> 'Пользователь'],
        ], ['name']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
