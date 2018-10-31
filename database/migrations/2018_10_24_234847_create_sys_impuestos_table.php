<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysImpuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_impuestos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->boolean('retencion')->default(1);
            $table->boolean('traslado')->default(1);
            $table->string('localfederal')->nullable();
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
        Schema::dropIfExists('sys_impuestos');
    }
}
