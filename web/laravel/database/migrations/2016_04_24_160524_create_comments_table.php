<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id_comment');
            $table-> string('name'); //van de persoon die de comment geplaatst heeft
            $table->integer('age'); //van de persoon die de comment geplaatst heeft
            $table->string('comment'); //de tekst van de comment zelf
            $table->boolean('hidden');
            $table->integer('project_phase_id')->index();
            $table->integer('gender_id')->index();
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
        Schema::drop('comments');
    }
}
