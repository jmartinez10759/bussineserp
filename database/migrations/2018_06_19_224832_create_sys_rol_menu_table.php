<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysRolMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_rol_menu', function (Blueprint $table) {
            $table->integer('id_rol');
            $table->integer('id_users');
            $table->integer('id_empresa')->default(0);
            $table->integer('id_sucursal')->default(0);
            $table->integer('id_menu')->default(0);
            $table->integer('id_permiso')->default(0);
            $table->boolean('estatus');
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
        Schema::dropIfExists('sys_rol_menu');
    }
}
