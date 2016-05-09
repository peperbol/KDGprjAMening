<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phases', function (Blueprint $table) {
            $table->increments('id_project_phase');
            $table->string('name');
            $table->date('enddate');
            $table->integer('order');
            $table->string('description');
            $table->string('bannerpath')->nullable();
            $table->string('imagepath')->nullable(); //path naar afbeelding van huidige fase
            $table->integer('project_id')->index();
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
        Schema::drop('phases');
    }
}
