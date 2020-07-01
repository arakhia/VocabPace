<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_results', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('game_id')->unsigned();
            $table->bigInteger('player_id')->unsigned()->nullable();
            $table->bigInteger('vocabulary_id')->unsigned();
            $table->string('answer')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('finished_time')->nullable();
            $table->timestamps();
        });

        Schema::table('game_results', function (Blueprint $table) {
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('vocabulary_id')->references('id')->on('vocabulary_base');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_results');
    }
}
