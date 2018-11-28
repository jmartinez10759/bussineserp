<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_proyecto')->unsigned();
            $table->integer('id_cometario')->unsigned();
            $table->mediumText('ruta_archivo')->nullable();
            $table->boolean('estatus')->default(1);
            $table->timestamps();

            //$table->foreign('id_proyecto')->references('id')->on('sys_projects')->onDelete('cascade');

            //$table->foreign('id_cometario')->references('id')->on('sys_comments')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_files');
    }
}
