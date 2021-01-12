<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCustomGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_games', function ($table) {
            $table->renameColumn('date_release', 'first_release_date')->change();
            $table->renameColumn('synopsis', 'summary')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('moderation_custom_games', function ($table) {
            $table->renameColumn('first_release_date', 'date_release')->change();
            $table->renameColumn('summary', 'synopsis')->change();
        });
    }
}
