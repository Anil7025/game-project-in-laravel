<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachPitchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_pitches', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('coach_id')->references('id')->on('users');
			$table->unsignedBigInteger('pitch_id')->references('id')->on('pitches');
			$table->string('postcode',20)->nullable();
			$table->string('pitch_name',255)->nullable();
			$table->string('location',1024)->nullable();
			$table->decimal('latitude',25,6)->nullable();
			$table->decimal('longitude',25,6)->nullable();
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
        Schema::dropIfExists('coach_pitches');
    }
}
