<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_data', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('about_me',1024)->nullable();
			$table->string('qualification',1024)->nullable();
			$table->string('address',255)->nullable();  
			
			$table->string('step_check',255)->nullable();
			$table->string('doccument',1024)->nullable();  
			$table->string('stripecustomer_id',255)->nullable();
			
			$table->text('stripe_log_data')->nullable();
			$table->text('stripe_custom',255)->nullable();
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
        Schema::dropIfExists('player_data');
    }
}
