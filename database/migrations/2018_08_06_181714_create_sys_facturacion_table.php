<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysFacturacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_facturacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_estatus')->default(1);
            $table->date('fecha_factura')->default( date('Y-m-d') );
            $table->string('serie')->nullable();
            $table->string('folio')->nullable();
            $table->string('uuid')->nullable();
            $table->double('iva')->default(0.0000);
            $table->double('subtotal',4)->default(0.0000);
            $table->double('total',4)->default(0.0000);
            $table->double('comision',4)->default(0.0000);
            $table->double('pago',4)->default(0.0000);
            $table->string('fecha_pago')->nullable();
            $table->string('fecha_estimada')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->string('archivo')->nullable();
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
        Schema::dropIfExists('sys_facturacion');
    }
}
