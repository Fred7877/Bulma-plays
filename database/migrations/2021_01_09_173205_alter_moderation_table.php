<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterModerationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('moderations', 'moderation_comments');

        Schema::table('moderation_comments', function ($table) {
            $table->string('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('moderation_comments', 'moderations');

        Schema::table('moderations', function ($table) {
            $table->string('status')->nullable(false)->change();
        });
    }
}
