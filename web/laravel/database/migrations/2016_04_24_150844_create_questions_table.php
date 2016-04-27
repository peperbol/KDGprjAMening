<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id_question');
            $table->string('questiontext');
            $table->string('leftlabel'); //de tekst van optie één
            $table->string('rightlabel'); //de tekst van optie twee
            $table->string('left_picture_path')->nullable(); //de afbeelding van optie één (voor de app)
            $table->string('right_picture_path')->nullable(); //de afbeelding van optie twee (voor de app)
            $table->boolean('hidden'); //hidden komt op true te staan als de fase is afgelopen, want dan kunnen er geen vragen meer over beantwoord worden
            $table->integer('project_phase_id')->index();
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
        Schema::drop('questions');
    }
}
