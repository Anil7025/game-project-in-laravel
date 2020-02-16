<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectedPlayerToCoachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connected_player_to_coaches', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('logged_player_id');
			$table->unsignedBigInteger('connected_coach_id');
			$table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('connected_player_to_coaches');
    }
}
