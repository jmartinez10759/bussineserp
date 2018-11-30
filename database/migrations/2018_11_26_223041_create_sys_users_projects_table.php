<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysUsersProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_users_projects', function (Blueprint $table) {
            $table->integer('id_users')->nullable();
            $table->integer('id_rol')->nullable();
            $table->integer('id_empresa')->nullable();
            $table->integer('id_sucursal')->nullable();
            $table->integer('id_proyecto')->nullable();
            $table->integer('id_tarea')->nullable();
            $table->timestamps();
            /*$table->integer('id_proyecto')->unsigned();
            $table->foreign('id_proyecto')->references('id')->on('sys_projects')->onDelete('cascade');

            $table->integer('id_tarea')->unsigned();
            $table->foreign('id_tarea')->references('id')->on('sys_tasks')->onDelete('cascade');*/

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_users_projects');
    }
}
