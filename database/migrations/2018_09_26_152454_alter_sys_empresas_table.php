<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSysEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_empresas', function (Blueprint $table) {
            $table->renameColumn('rfc_emisor','rfc_emisor');
            $table->renameColumn('empresa','nombre_comercial');
            $table->dropColumn('descripcion');
            $table->string('calle')->nullable();
            $table->string('colonia')->nullable();
            $table->string('municipio')->nullable();
            $table->string('cp')->nullable();
            $table->integer('id_estado')->nullable();
            $table->string('giro_comercial')->nullable();
            $table->string('telefono')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_empresas', function (Blueprint $table) {
            $table->renameColumn('rfc_emisor','rfc');
            $table->renameColumn('nombre_comercial','empresa');
        });
    }
}
