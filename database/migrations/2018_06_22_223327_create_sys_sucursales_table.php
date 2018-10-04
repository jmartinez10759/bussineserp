<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_sucursales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->string('sucursal');
            $table->string('direccion');
            $table->string('telefono');
            $table->integer('id_estado')->default(1);
            $table->boolean('estatus')->default(1);
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
        Schema::dropIfExists('sys_sucursales');
    }
}
