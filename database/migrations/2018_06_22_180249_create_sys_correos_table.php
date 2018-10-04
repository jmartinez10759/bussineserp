<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysCorreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_correos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('correo');
            $table->string('asunto')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->boolean('estatus_destacados')->default(0);
            $table->boolean('estatus_papelera')->default(0);
            $table->boolean('estatus_vistos')->default(0);
            $table->boolean('estatus_enviados')->default(0);
            $table->boolean('estatus_recibidos')->default(0);
            $table->boolean('estatus_borradores')->default(0);
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
        Schema::dropIfExists('sys_correos');
    }
}
