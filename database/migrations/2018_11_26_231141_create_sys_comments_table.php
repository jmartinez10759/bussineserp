<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tarea')->unsigned();
            $table->string('titulo')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->boolean('estatus')->default(1);
            $table->timestamps();

            /*$table->integer('id_archivo')->unsigned();
            $table->foreign('id_archivo')->references('id')->on('sys_files')->onDelete('cascade');*/
            #$table->foreign('id_tarea')->references('id')->on('sys_tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_comments');
    }
}
