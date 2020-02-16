<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('coach_id');
			$table->foreign('coach_id')->references('id')->on('users');
			$table->unsignedBigInteger('player_id');
			$table->foreign('player_id')->references('id')->on('users');
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
        Schema::dropIfExists('coach_levels');
    }
}
