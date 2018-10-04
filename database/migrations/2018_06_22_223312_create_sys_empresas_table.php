<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_empresas', function (Blueprint $table) {            
            $table->increments('id');
            $table->string('rfc_emisor');
            $table->string('nombre_comercial')->nullable();
            $table->mediumText('razon_social');
            $table->string('calle')->nullable();
            $table->string('colonia')->nullable();
            $table->string('municipio')->nullable();
            $table->string('cp')->nullable();
            $table->integer('id_estado')->nullable();
            $table->string('giro_comercial')->nullable();
            $table->string('telefono')->nullable();
            $table->mediumText('logo')->nullable();
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
        Schema::dropIfExists('sys_empresas');
    }
}
