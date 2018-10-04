<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysConceptosPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_conceptos_pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('concepto')->nullable();
            $table->bigInteger('cantidad')->default(1);
            $table->double('precio',4)->default(0.0000);;
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
        Schema::dropIfExists('sys_conceptos_pedidos');
    }
}
