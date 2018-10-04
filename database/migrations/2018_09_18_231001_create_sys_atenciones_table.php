<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysAtencionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_atenciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('primer_apellido')->nullable();
            $table->string('segundo_apellido')->nullable();
            $table->string('fecha_nacimiento')->nullable();
            $table->mediumText('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('solicitud')->nullable();
            $table->mediumText('foto')->nullable();
            $table->mediumText('ine')->nullable();
            $table->mediumText('ine_tutores')->nullable();
            $table->mediumText('descripcion')->nullable();
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
        Schema::dropIfExists('sys_atenciones');
    }
}
