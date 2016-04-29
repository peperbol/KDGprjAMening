<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id_project');
            $table->string('name'); //bvb heraanleg van het Testplein
            $table->string('description');
            $table->date('startdate');
            $table->boolean('hidden'); //als een project op hidden true staat, is het niet meer zichtbaar voor de bezoekers van de site
            $table->string('imagepath')->nullable(); //path naar de main image van het project
            $table->string('street'); //straat (adres) van de locatie van het project (stad en postcode zijn niet belangrijk omdat deze standaard op Antwerpen zullen staan)
            $table->integer('house_number');
            $table->float('latitude')->nullable(); //coördinaten (voor google maps eventueel) (breedtegraad)
            $table->float('longitude')->nullable(); //coördinaten (voor google maps eventueel) (lengtegraad)
            $table->integer('user_id')->index(); //foreign key
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
        Schema::drop('projects');
    }
}
