<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysFacturacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_facturaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->double('iva',4)->default(0);
            $table->double('subtotal',4)->default(0);
            $table->double('total',4)->default(0);
            $table->integer('id_pedido')->default(0);
            $table->integer('id_moneda')->default(1);
            $table->integer('id_contacto')->default(1);
            $table->integer('id_forma_pago')->default(1);
            $table->integer('id_metodo_pago')->default(1);
            $table->integer('id_estatus')->default(1);
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
        Schema::dropIfExists('sys_facturaciones');
    }
}
