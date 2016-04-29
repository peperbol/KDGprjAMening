<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id_answer');
            $table->boolean('answer'); //answer kan zowel true (1) of false (0) zijn, aangezien we maar met twee opties werken telkens
            $table->integer('age'); //leeftijd van de antwoorder
            $table->integer('question_id')->index();
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
        Schema::drop('answers');
    }
}
