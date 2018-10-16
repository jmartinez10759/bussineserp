<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysProveedoresEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_proveedores_empresas', function (Blueprint $table) {
            $table->integer('id_proveedor')->nullable();
            $table->integer('id_empresa')->nullable();
            $table->integer('id_sucursal')->nullable();
            $table->integer('id_contacto')->nullable();
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
        Schema::dropIfExists('sys_proveedores_empresas');
    }
}
