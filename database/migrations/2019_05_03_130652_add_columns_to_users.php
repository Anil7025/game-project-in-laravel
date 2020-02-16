<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('fname',255)->nullable();
			$table->string('lname',255)->nullable();
			$table->string('jwt_token',300)->nullable();
			$table->string('phone',20)->unique();
			$table->string('facebook_id',100)->nullable();
			$table->string('google_id',255)->nullable();
			$table->string('location',255)->nullable();
			$table->integer('otp')->nullable();
			$table->string('trainnig_pitch',255)->nullable();
			
			$table->string('social_id',255)->nullable();
			$table->string('profile_pic',255)->nullable();
			$table->string('social_token',255)->nullable();
			$table->string('user_from',255)->nullable();
			$table->string('social_type',255)->nullable();
			
			$table->bigInteger('coachdata_id')->nullable();
			$table->boolean('player_status')->nullable();
			$table->integer('transaction_id')->nullable();
			$table->string('token',255)->nullable();
			
			
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
