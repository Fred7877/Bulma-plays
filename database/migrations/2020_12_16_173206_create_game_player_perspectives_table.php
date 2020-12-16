<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamePlayerPerspectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_player_perspectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id');
            $table->foreignId('player_perspective_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_player_perspectives');
    }
}
