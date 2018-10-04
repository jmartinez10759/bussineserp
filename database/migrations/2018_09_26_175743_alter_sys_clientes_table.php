<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSysClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_clientes', function (Blueprint $table) {
            $table->dropColumn('contacto');
            $table->dropColumn('departamento');
            $table->dropColumn('correo');
            $table->mediumText('logo')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_clientes', function (Blueprint $table) {
            //
        });
    }
}
