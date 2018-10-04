<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysCategoriasCorreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_categorias_correos', function (Blueprint $table) {
            $table->string('id_users');
            $table->integer('id_register');
            $table->integer('id_sucursal')->default(0);
            $table->integer('id_empresa')->default(0);
            $table->integer('id_categorias')->default(0);
            $table->integer('id_correo');
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
        Schema::dropIfExists('sys_categorias_correos');
    }
}
