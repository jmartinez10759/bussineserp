<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysUsersFacturacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_users_facturacion', function (Blueprint $table) {
            $table->integer('id_users');
            $table->integer('id_rol');
            $table->integer('id_empresa');
            $table->integer('id_sucursal');
            $table->integer('id_cliente');
            $table->integer('id_factura');
            $table->integer('id_forma_pago');
            $table->integer('id_metodo_pago');
            $table->integer('id_concepto');
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
        Schema::dropIfExists('sys_users_facturacion');
    }
}
