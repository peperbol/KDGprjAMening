<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id_event');
            $table->dateTime('startdate');
            $table->dateTime('enddate');
            $table->string('name');
            $table->string('description');
            $table->string('imagepath')->nullable();
            $table->integer('project_id')->index(); //foreign key
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
        Schema::drop('events');
    }
}
