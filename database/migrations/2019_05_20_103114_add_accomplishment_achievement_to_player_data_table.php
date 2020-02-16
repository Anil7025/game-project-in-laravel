<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccomplishmentAchievementToPlayerDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('player_data', function (Blueprint $table) {
            $table->string('accomplishment',1024)->nullable();
			$table->string('achievement',1024)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('player_data', function (Blueprint $table) {
            //
        });
    }
}
