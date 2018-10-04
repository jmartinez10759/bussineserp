<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSysSucursalesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_sucursales', function (Blueprint $table) {
            $table->string('codigo')->after('id')->nullable();
            $table->dropColumn('descripcion');
            $table->string('direccion')->nullable()->after('sucursal');
            $table->string('telefono')->nullable()->after('sucursal');
            $table->integer('id_estado')->default(1)->after('sucursal');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_sucursales', function (Blueprint $table) {
            //
        });
    }
}
