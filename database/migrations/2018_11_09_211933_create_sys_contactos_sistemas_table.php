<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysContactosSistemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_contactos_sistemas', function (Blueprint $table) {
            $table->integer('id_empresa')->nullable();
            $table->integer('id_cliente')->nullable();
            $table->integer('id_proveedor')->nullable();
            $table->integer('id_cuenta')->nullable();
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
        Schema::dropIfExists('sys_contactos_sistemas');
    }
}
