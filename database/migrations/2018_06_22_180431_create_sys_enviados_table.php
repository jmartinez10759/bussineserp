<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysEnviadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_enviados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_users');
            $table->integer('id_sucursal')->default(0);
            $table->integer('id_empresa')->default(0);
            $table->string('correo');
            $table->string('asunto')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->boolean('estatus_destacados')->default(0);
            $table->boolean('estatus_papelera')->default(0);
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
        Schema::dropIfExists('sys_enviados');
    }
}
