<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysPaisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_paises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->string('formato_codigo_postal');
            $table->string('formato_registro')->nullable();
            $table->string('validacion_registro')->nullable();
            $table->string('agrupaciones')->nullable();
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
        Schema::dropIfExists('sys_paises');
    }
}
