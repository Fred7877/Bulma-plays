<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomGameGameModesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_game_game_modes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_game_id')->constrained();
            $table->foreignId('game_mode_id')->constrained();
            $table->json('metas')->nullable();
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
        Schema::dropIfExists('custom_game_game_modes');
    }
}
