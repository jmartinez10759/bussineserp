<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysUsersPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_users_pedidos', function (Blueprint $table) {
            $table->integer('id_users')->nullable();
            $table->integer('id_rol')->nullable();
            $table->integer('id_empresa')->nullable();
            $table->integer('id_sucursal')->nullable();
            $table->integer('id_modulo')->nullable();
            $table->integer('id_pedido')->nullable();
            $table->integer('id_concepto')->nullable();
            $table->integer('id_producto')->nullable();
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
        Schema::dropIfExists('sys_users_pedidos');
    }
}
