<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachPlayerStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_player_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('coach_id')->references('id')->on('users');
			$table->bigInteger('player_id')->references('id')->on('users');
			$table->boolean('status')->default(1);
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
        Schema::dropIfExists('coach_player_statuses');
    }
}
