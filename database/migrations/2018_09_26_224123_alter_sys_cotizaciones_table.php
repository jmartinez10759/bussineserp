<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSysCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_cotizaciones', function (Blueprint $table) {
            $table->integer('id_forma_pago')->default(1)->after('id_contacto');
            $table->integer('id_metodo_pago')->default(1)->after('id_contacto');
            $table->dropColumn('condiciones_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_cotizaciones', function (Blueprint $table) {
            //
        });
    }
}
