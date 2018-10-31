<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysConceptosFacturacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_conceptos_facturaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_producto');
            $table->integer('id_plan');
            $table->bigInteger('cantidad')->default(1);
            $table->double('precio',4)->default(0.0000);
            $table->double('total',4)->default(0.0000);
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
        Schema::dropIfExists('sys_conceptos_facturaciones');
    }
}
