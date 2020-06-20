<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('player_01_id')->unsigned();
            $table->bigInteger('player_02_id')->unsigned();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });

        Schema::table('games', function (Blueprint $table) {
            $table->foreign('player_01_id')->references('id')->on('users');
            $table->foreign('player_02_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
