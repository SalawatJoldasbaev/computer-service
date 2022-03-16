<?php

use App\Models\Admin;
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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\Role::class);
            $table->string('pincode')->unique();
            $table->string('user_name')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Admin::create([
            'role_id'=>1,
            'pincode'=>md5(1234),
            'user_name'=>'ayba007',
            'name'=>'Aybergen'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
