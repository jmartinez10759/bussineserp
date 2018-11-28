<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->timestamps();

            /*$table->integer('id_comentario')->unsigned();
            $table->foreign('id_comentario')->references('id')->on('sys_comments')->onDelete('cascade');*/

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_tasks');
    }
}
