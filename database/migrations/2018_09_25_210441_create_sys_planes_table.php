<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysPlanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_planes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_unidadmedida')->default(1);
            $table->string('clave_unidad')->nullable();
            $table->string('clave_producto_servicio')->nullable();
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->double('subtotal',4)->default(0.0000);
            $table->double('iva')->default(0.0000);
            $table->double('total',4)->default(0.0000);
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
        Schema::dropIfExists('sys_planes');
    }
}
