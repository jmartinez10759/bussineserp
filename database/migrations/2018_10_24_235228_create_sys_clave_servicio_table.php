<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysClaveServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_clave_servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->string('iva_trasladado')->nullable();
            $table->string('ieps_trasladado')->nullable();
            $table->string('complemento')->nullable();
            $table->string('fecha_inicio_vigencia')->nullable();
            $table->string('fecha_final_vigencia')->nullable();
            $table->mediumText('similares')->nullable();
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
        Schema::dropIfExists('sys_clave_servicios');
    }
}
