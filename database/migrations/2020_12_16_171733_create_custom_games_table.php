<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_games', function (Blueprint $table) {
            $table->id();
            $table->integer('id_igdb');
            $table->string('name', 100);
            $table->string('slug', 120);
            $table->foreignId('genre_id');
            $table->foreignId('theme_id');
            $table->foreignId('game_mode_id');
            $table->foreignId('player_perspective_id');
            $table->timestamp('publish_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('custom_games');
    }
}
