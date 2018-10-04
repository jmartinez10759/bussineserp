<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSysEmpresasSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_empresas_sucursales', function (Blueprint $table) {
            $table->integer('id_cuenta')->nullable()->after('id_sucursal');
            $table->integer('id_contacto')->nullable()->after('id_sucursal');
            $table->integer('id_cliente')->nullable()->after('id_sucursal');
            $table->integer('id_proveedor')->nullable()->after('id_sucursal');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_empresas_sucursales', function (Blueprint $table) {
            //
        });
    }
}
