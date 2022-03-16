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

        Role::create([
            'name'=> 'Директор',
        ]);
        Role::create([
            'name'=> 'Бухгалтер',
        ]);
        Role::create([
            'name'=> 'Кассир',
        ]);
        Role::create([
            'name'=> 'Заведующий складом',
        ]);
        Role::create([
            'name'=> 'Контроль качество',
        ]);
        Role::create([
            'name'=> 'Торговый агент',
        ]);
        Role::create([
            'name'=> 'Продавец',
        ]);
        Role::create([
            'name'=> 'Пользователь',
        ]);
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
