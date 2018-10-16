<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysEmpresasSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_empresas_sucursales', function (Blueprint $table) {
            $table->integer('id_empresa')->nullable();
            $table->integer('id_sucursal')->nullable();
            $table->integer('id_contacto')->nullable();
            $table->integer('id_cliente')->nullable();
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
        Schema::dropIfExists('sys_empresas_sucursales');
    }
}
