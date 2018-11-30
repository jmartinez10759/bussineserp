<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_estatus')->unsigned();
            $table->integer('id_cliente')->unsigned();
            $table->string('titulo')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->string('fecha_cierre')->default('0000-00-00');
            $table->timestamps();

            #$table->foreign('id_estatus')->references('id')->on('sys_estatus')->onDelete('cascade');

            #$table->foreign('id_cliente')->references('id')->on('sys_clientes')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_projects');
    }
}
