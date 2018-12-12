<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysUsersActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_users_activities', function (Blueprint $table) {
            $table->integer('id_users')->nullable();
            $table->integer('id_rol')->nullable();
            $table->integer('id_empresa')->nullable();
            $table->integer('id_sucursal')->nullable();
            $table->integer('id_cliente')->nullable();
            $table->integer('id_actividad')->nullable();
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
        Schema::dropIfExists('sys_users_activities');
    }
}
