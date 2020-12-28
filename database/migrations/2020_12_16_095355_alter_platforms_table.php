<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('platforms');

        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->integer('id_igdb');
            $table->string('alternative_name', 100)->nullable();
            $table->string('name', 100);
            $table->integer('platform_logo')->nullable();
            $table->json('data');
            $table->string('slug', 100);
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
        Schema::dropIfExists('platforms');
    }
}
