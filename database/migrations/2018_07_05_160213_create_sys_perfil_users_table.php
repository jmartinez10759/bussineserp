<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysPerfilUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_perfil_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_users');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('puesto')->nullable();
            $table->enum('genero',['Masculino','Femenino'])->default('Masculino');
            $table->string('estado_civil')->nullable();
            $table->mediumText('experiencia')->nullable();
            $table->mediumText('notas')->nullable();
            $table->mediumText('foto')->nullable();
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
        Schema::dropIfExists('sys_perfil_users');
    }
}
