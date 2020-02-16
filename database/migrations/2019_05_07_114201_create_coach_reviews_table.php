<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoachReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coach_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('coach_id')->references('id')->on('users');
			
			$table->unsignedInteger('sender_id')->nullable();
			$table->unsignedInteger('rating')->default(0);
			$table->string('review',1024)->nullable();
			$table->boolean('status');
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
        Schema::dropIfExists('coach_reviews');
    }
}
