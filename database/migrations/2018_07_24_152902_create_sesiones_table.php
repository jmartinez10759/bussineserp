<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSesionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_sesiones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_users')->nullable();
            $table->string('ip_address',45)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('conect')->default(0);
            $table->boolean('disconect')->default(1);
            $table->string('time_conected')->nullable();
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
        Schema::dropIfExists('sys_sesiones');
    }
}
