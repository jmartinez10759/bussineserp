<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysTasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_tasas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rango')->nullable();
            $table->double('valor_minimo',6)->default(0.000000);
            $table->double('valor_maximo',6)->default(0.000000);
            $table->string('clave')->nullable();
            $table->string('factor')->nullable();
            $table->boolean('trasladado')->default(1);
            $table->boolean('retencion')->default(1);
            $table->string('fecha_inicio_vigencia')->nullable();
            $table->string('fecha_final_vigencia')->nullable();
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
        Schema::dropIfExists('sys_tasas');
    }
}
