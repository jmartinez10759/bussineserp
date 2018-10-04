<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bitacora')->nullable();
            $table->string('name');
            $table->string('first_surname');
            $table->string('second_surname')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('remember_token');
            $table->string('api_token');
            $table->boolean('estatus');
            $table->boolean('confirmed')->default(0);
            $table->string('confirmed_code')->nullable();
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
        Schema::dropIfExists('sys_users');
    }
}
