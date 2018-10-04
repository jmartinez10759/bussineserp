<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_categoria')->default(1);
            $table->integer('id_unidadmedida')->default(1);
            $table->string('clave_producto_servicio')->nullable();
            $table->string('clave_unidad')->nullable();
            $table->string('codigo')->nullable();
            $table->string('modelo')->nullable();
            $table->mediumText('nombre')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->double('subtotal',4)->default(0.0000);
            $table->double('iva',4)->default(0.0000);
            $table->double('total',4)->default(0.0000);
            $table->bigInteger('stock')->default(1);
            $table->mediumText('logo')->nullable();
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
        Schema::dropIfExists('sys_productos');
    }
}
